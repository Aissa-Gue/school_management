<?php

namespace App\Http\Controllers;

use App\Models\Student;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class StudentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return Student::with(['level','courses'])->get();
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
            'notes' => 'nullable|size:255',
            'created_by' => 'required|numeric|exists:users,id',
        ]);
        return Student::create($validated);
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return Student::with(['level','courses','createdBy','updatedBy'])->find($id);
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
            'notes' => 'nullable|size:255',
            'updated_by' => 'required|numeric|exists:users,id',
        ]);
        $student->update($validated);
        return $student;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Student::where('id', $id)->update([
            'deleted_by' => Auth::user()->id,
        ]);
        DB::beginTransaction();
        try {
            Student::where('id', $id)->update([
                'deleted_by' => Auth::user()->id,
            ]);
            Student::destroy($id);
            DB::commit();
            return response(['message' => 'record has been deleted']);

        } catch (\Exception $e) {
            DB::rollBack();
            return response(['message' => 'Error: delete operation is failed']);
        }
    }
}
