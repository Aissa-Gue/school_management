<?php

namespace App\Http\Controllers;

use App\Models\Agenda;
use Illuminate\Http\Request;

class AgendaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return Agenda::all();
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'class_id' => 'required',
            'course_id' => 'required',
            'day' => 'required',
            'from' => 'required',
            'to' => 'required',
            'color' => 'required',
        ]);
        return Agenda::create($validated);
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
       return Agenda::find($id);
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
        $agenda = Agenda::find($id);
        $validated = $request->validate([
            'classroom_id' => 'required',
            'course_id' => 'required',
            'day' => 'required',
            'from' => 'required',
            'to' => 'required',
            'color' => 'required',
        ]);
        $agenda->update($validated);
        return $agenda;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        if(Agenda::destroy($id))
            return response(['result' => 'record has been deleted']);
        else
            return response(['result' => 'Error: delete operation is failed']);
    }
}
