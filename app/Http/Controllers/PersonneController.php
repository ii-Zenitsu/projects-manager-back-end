<?php

namespace App\Http\Controllers;

use App\Http\Resources\PersonneResource;
use App\Http\Resources\ProjetResource;
use App\Models\Personne;
use App\Models\Projet;
use Illuminate\Http\Request;

class PersonneController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $personnes = Personne::all();
        return PersonneResource::collection($personnes);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // $request->validate([
        //     'nom' => 'required|string|max:255',
        //     'prenom' => 'required|string|max:255',
        //     'email' => 'nullable|string|max:255',
        //     'tele' => 'nullable|string|max:255',
        // ]);
        $personne = Personne::create($request->all());
        return new PersonneResource($personne);
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $personne = Personne::find($id);
        if (!$personne) {
            return response()->json([
                "error" => "Resource not Found",
                "message" => "personne with ID $id doesn't exist"],404);
        }
        return new PersonneResource($personne);
    }

    public function getProjets($id)
    {
        $personne = Personne::find($id);
        if (!$personne) {
            return response()->json([
                "error" => "Resource not Found",
                "message" => "personne with ID $id doesn't exist"],404);
        }
        return ProjetResource::collection($personne->projets);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $personne = Personne::find($id);
        if (!$personne) {
            return response()->json([
                "error" => "Resource not Found",
                "message" => "personne with ID $id doesn't exist"],404);
        }
        $personne->update($request->all());
        return new PersonneResource($personne);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $personne = Personne::find($id);
        if (!$personne) {
            return response()->json([
                "error" => "Resource not Found",
                "message" => "personne with ID $id doesn't exist"],404);
        }
        Personne::destroy($id);
        return response()->json("personne with ID $id is deleted succesfully", 200);
    }
}