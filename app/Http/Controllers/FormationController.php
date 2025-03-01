<?php

namespace App\Http\Controllers;

use App\Models\Formation;
use Illuminate\Http\Request;

class FormationController extends Controller
{
    public function index()
    {
        return response()->json(Formation::all(), 200) ;
    }

    public function store(Request $request)
    {
        $formation = Formation::create($request->all());
        return response()->json($formation, 201);
    }

    public function show($id)
    {
        return Formation::find($id);
    }

    public function update(Request $request, $id)
    {
        $formation = Formation::findOrFail($id);
        $formation->update($request->all());
        return response()->json($formation, 200);
    }

    public function destroy($id)
    {
        Formation::destroy($id);
        return response()->json(null, 204);
    }
}