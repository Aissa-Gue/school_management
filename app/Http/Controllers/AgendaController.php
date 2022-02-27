<?php

namespace App\Http\Controllers;

use App\Models\Agenda;
use Illuminate\Http\Request;

class AgendaController extends Controller
{

    public function __construct()
    {
        $this->middleware('hasPortal:agenda');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public
    function index()
    {
        $agenda = Agenda::with(['classroom', 'course'])->get();
        return response([
            'hasPortal' => true,
            'agenda' => $agenda
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public
    function store(Request $request)
    {
        $validated = $request->validate([
            'class_id' => 'required|numeric|exists:classrooms,id',
            'course_id' => 'required|numeric|exists:courses,id',
            'day' => 'required|integer|between:1,7',
            'from' => 'required|date_format:H:i',
            'to' => 'required|date_format:H:i',
            'color' => 'required',
        ]);

        return response([
            'hasPortal' => true,
            'agenda' => Agenda::create($validated),
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public
    function show($id)
    {
        $agenda = Agenda::with(['classroom', 'course'])->find($id);
        return response([
            'hasPortal' => true,
            'agenda' => $agenda,
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public
    function update(Request $request, $id)
    {
        $validated = $request->validate([
            'classroom_id' => 'required|numeric|exists:classrooms,id',
            'course_id' => 'required|numeric|exists:courses,id',
            'day' => 'required|integer|between:1,7',
            'from' => 'required|date_format:H:i',
            'to' => 'required|date_format:H:i',
            'color' => 'required',
        ]);
        $agenda = Agenda::find($id);
        $agenda->update($validated);
        return response([
            'hasPortal' => true,
            'agenda' => $agenda,
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public
    function destroy($id)
    {
        if (Agenda::destroy($id))
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
