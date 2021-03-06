<?php

namespace App\Http\Controllers;

use App\Models\Teacher;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class TeacherController extends Controller
{
    public function __construct()
    {
        $this->middleware('hasPortal:teachers');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $teachers = Teacher::with(['course'])->get();

        return response([
            'hasPortal' => true,
            'teachers' => $teachers
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->request->add([
            'created_by' => Auth::user()->id,
        ]);
        $validated = $request->validate([
            'lname' => 'required|regex:/^[\pL\s\-]+$/u',
            'fname' => 'required|regex:/^[\pL\s\-]+$/u',
            'sex' => 'required|boolean',
            'salary' => 'required|numeric',
            'email' => 'nullable|email|unique:teachers,email',
            'phone' => 'required|numeric|unique:teachers,phone',
            'notes' => 'nullable|size:255',
            'created_by' => 'required|numeric|exists:users,id',
        ]);
        $teacher = Teacher::create($validated);

        return response([
            'hasPortal' => true,
            'teacher' => $teacher
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $teacher = Teacher::with(['course', 'createdBy', 'updatedBy'])->find($id);

        return response([
            'hasPortal' => true,
            'teacher' => $teacher
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $teacher = Teacher::find($id);
        $request->request->add([
            'updated_by' => Auth::user()->id,
        ]);
        $validated = $request->validate([
            'lname' => 'required|regex:/^[\pL\s\-]+$/u',
            'fname' => 'required|regex:/^[\pL\s\-]+$/u',
            'sex' => 'required|boolean',
            'salary' => 'required|numeric',
            'email' => 'nullable|email|unique:teachers,email,' . $id,
            'phone' => 'required|numeric|unique:teachers,phone,' . $id,
            'notes' => 'nullable|size:255',
            'updated_by' => 'required|numeric|exists:users,id',
        ]);
        $teacher->update($validated);

        return response([
            'hasPortal' => true,
            'teacher' => $teacher
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        DB::beginTransaction();
        try {
            Teacher::where('id', $id)->update([
                'deleted_by' => Auth::user()->id,
            ]);
            Teacher::destroy($id);
            DB::commit();
            return response([
                'hasPortal' => true,
                'message' => 'record has been deleted'
            ]);

        } catch (\Exception $e) {
            DB::rollBack();
            return response([
                'hasPortal' => true,
                'message' => 'Error: delete operation is failed'
            ]);
        }
    }
}
