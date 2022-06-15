<?php

namespace App\Http\Controllers;

use App\Models\Student;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class StudentController extends Controller
{
    public function __construct()
    {
        $this->middleware('hasPortal:students');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $students = Student::with(['level', 'courses'])->paginate(7);

        return response([
            'hasPortal' => true,
            'students' => $students
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
            'birthdate' => 'required|date',
            'address' => 'nullable',
            'sex' => 'required|boolean',
            'level_id' => 'required|numeric|exists:levels,id',
            'father' => 'nullable|regex:/^[\pL\s\-]+$/u',
            'mother' => 'nullable|regex:/^[\pL\s\-]+$/u',
            'email' => 'nullable|email',
            'phone1' => 'required_without:phone2|numeric',
            'phone2' => 'required_without:phone1|numeric',
            'notes' => 'nullable|max:255',
            'created_by' => 'required|numeric|exists:users,id',
        ]);
        $student = Student::create($validated);

        return response()->json([
            'hasPortal' => true,
            'student' => $student
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
        $student = Student::with(['level', 'courses', 'createdBy', 'updatedBy'])->find($id);

        return response([
            'hasPortal' => true,
            'student' => $student
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
        $student = Student::find($id);
        $request->request->add([
            'updated_by' => Auth::user()->id,
        ]);
        $validated = $request->validate([
            'lname' => 'required|regex:/^[\pL\s\-]+$/u',
            'fname' => 'required|regex:/^[\pL\s\-]+$/u',
            'birthdate' => 'required|date',
            'address' => 'nullable',
            'sex' => 'required|boolean',
            'level_id' => 'required|numeric|exists:levels,id',
            'father' => 'nullable|regex:/^[\pL\s\-]+$/u',
            'mother' => 'nullable|regex:/^[\pL\s\-]+$/u',
            'email' => 'nullable|email',
            'phone1' => 'required_without:phone2|numeric',
            'phone2' => 'required_without:phone1|numeric',
            'notes' => 'nullable|max:255',
            'updated_by' => 'required|numeric|exists:users,id',
        ]);
        $student->update($validated);

        return response([
            'hasPortal' => true,
            'student' => $student
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
            Student::where('id', $id)->update([
                'deleted_by' => Auth::user()->id,
            ]);
            Student::destroy($id);
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
