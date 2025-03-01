<?php

namespace App\Http\Controllers;

use App\Models\Participation;
use Illuminate\Http\Request;

class ParticipationController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return Participation::all();
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $participation = Participation::create($request->all());
        return response()->json($participation, 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(Participation $participation)
    {
        return response()->json($participation);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Participation $participation)
    {
        $participation->update($request->all());
        return response()->json($participation, 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Participation $participation)
    {
        $participation->delete();
        return response()->json(null, 204);
    }
}