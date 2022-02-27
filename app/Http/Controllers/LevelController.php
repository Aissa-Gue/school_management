<?php

namespace App\Http\Controllers;

use App\Models\Level;
use Illuminate\Http\Request;

class LevelController extends Controller
{
    public function __construct()
    {
        $this->middleware('hasPortal:levels');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $levels = Level::all();

        return response([
            'hasPortal' => true,
            'levels' => $levels
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
        $validated = $request->validate([
            'name' => 'required',
        ]);
        $level = Level::create($validated);

        return response([
            'hasPortal' => true,
            'level' => $level
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
        $level = Level::find($id);

        return response([
            'hasPortal' => true,
            'level' => $level
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
        $level = Level::find($id);
        $validated = $request->validate([
            'name' => 'required',
        ]);
        $level->update($validated);

        return response([
            'hasPortal' => true,
            'level' => $level
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
        if (Level::destroy($id))
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
