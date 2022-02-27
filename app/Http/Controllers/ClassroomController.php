<?php

namespace App\Http\Controllers;

use App\Models\Classroom;
use Illuminate\Http\Request;

class ClassroomController extends Controller
{
    public function __construct()
    {
        $this->middleware('hasPortal:classrooms');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $classrooms =  Classroom::all();
        return response([
            'hasPortal' => true,
            'classrooms' => $classrooms
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required',
        ]);
        $classroom =  Classroom::create($validated);

        return response([
            'hasPortal' => true,
            'classroom' => $classroom
        ]);

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $classroom = Classroom::find($id);

        return response([
            'hasPortal' => true,
            'classroom' => $classroom
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'name' => 'required',
        ]);
        $classroom = Classroom::find($id);
        $classroom->update($validated);

        return response([
            'hasPortal' => true,
            'classroom' => $classroom
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        if(Classroom::destroy($id))
            return response([
                'hasPortal' => true,
                'message' => 'record has been deleted'
            ]);
        else
            return response([
                'hasPortal' => true,
                'message' => 'Error: delete operation is failed'
            ]);
    }
}
