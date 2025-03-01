<?php

namespace App\Http\Controllers;

use App\Http\Resources\PersonneResource;
use App\Models\Projet;
use Illuminate\Http\Request;
use App\Http\Resources\ProjetResource;

/**
 * @OA\Tag(
 *     name="Projets",
 *     description="Operations related to projects"
 * )
 */
class ProjetController extends Controller
{
    /**
     * @SWG\Get(
     *     path="/projets",
     *     summary="Get a list of projects",
     *     tags={"Projets"},
     *     @SWG\Response(response=200, description="Successful operation"),
     *     @SWG\Response(response=400, description="Invalid request")
     * )
     */
    public function index()
    {
        $projets = Projet::all();
        return ProjetResource::collection($projets);
    }

    /**
     * Store a newly created resource in storage.
     * 
     * @OA\Post(
     *     path="/api/projets",
     *     tags={"Projets"},
     *     summary="Create a new project",
     *     @OA\RequestBody(
     *         required=true,
     *         description="Project data",
     *         @OA\JsonContent(
     *             required={"intitule", "dateDebut", "dateFin", "duree"},
     *             @OA\Property(property="intitule", type="string"),
     *             @OA\Property(property="dateDebut", type="string", format="date"),
     *             @OA\Property(property="dateFin", type="string", format="date"),
     *             @OA\Property(property="duree", type="integer")
     *         )
     *     ),
     *     @OA\Response(
     *         response=201,
     *         description="Project created successfully",
     *         @OA\JsonContent(ref="#/components/schemas/Projet")
     *     )
     * )
     */
    public function store(Request $request)
    {
        $projet = Projet::create($request->all());
        return new ProjetResource($projet);
    }

    /**
     * Display the specified resource.
     * 
     * @OA\Get(
     *     path="/api/projets/{id}",
     *     tags={"Projets"},
     *     summary="Get project by ID",
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="ID of the project",
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Project details",
     *         @OA\JsonContent(ref="#/components/schemas/Projet")
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Project not found"
     *     )
     * )
     */
    public function show($id)
    {
        $projet = Projet::find($id);
        if (!$projet) {
            return response()->json([
                "error" => "Resource not Found",
                "message" => "projet with ID $id doesn't exist"
            ], 404);
        }
        return new ProjetResource($projet);
    }

    /**
     * Get project related persons
     * 
     * @OA\Get(
     *     path="/api/projets/{id}/personnes",
     *     tags={"Projets"},
     *     summary="Get persons related to a project",
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="Project ID",
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="List of persons related to the project",
     *         @OA\JsonContent(
     *             type="array",
     *             @OA\Items(ref="#/components/schemas/Personne")
     *         )
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Project not found"
     *     )
     * )
     */
    public function getPersonnes($id)
    {
        $projet = Projet::find($id);
        if (!$projet) {
            return response()->json([
                "error" => "Resource not Found",
                "message" => "projet with ID $id doesn't exist"
            ], 404);
        }
        return PersonneResource::collection($projet->personnes);
    }

    /**
     * Get closed projects
     * 
     * @OA\Get(
     *     path="/api/projets/closed",
     *     tags={"Projets"},
     *     summary="Get closed projects",
     *     @OA\Response(
     *         response=200,
     *         description="List of closed projects",
     *         @OA\JsonContent(type="array", @OA\Items(ref="#/components/schemas/Projet"))
     *     )
     * )
     */
    public function getClosed()
    {
        $projets = Projet::where('dateFin', '<', now())->get();
        return ProjetResource::collection($projets);
    }

    /**
     * Get late projects
     * 
     * @OA\Get(
     *     path="/api/projets/late",
     *     tags={"Projets"},
     *     summary="Get late projects",
     *     @OA\Response(
     *         response=200,
     *         description="List of late projects",
     *         @OA\JsonContent(type="array", @OA\Items(ref="#/components/schemas/Projet"))
     *     )
     * )
     */
    public function getLate()
    {
        $projets = Projet::where('dateFin', '<', now())->whereRaw("ABS(DATEDIFF(dateFin, dateDebut)) < duree")->get();
        return ProjetResource::collection($projets);
    }

    /**
     * Get closed projects with delays
     * 
     * @OA\Get(
     *     path="/api/projets/closed-with-late",
     *     tags={"Projets"},
     *     summary="Get closed projects with delays",
     *     @OA\Response(
     *         response=200,
     *         description="List of closed projects with delays",
     *         @OA\JsonContent(type="array", @OA\Items(ref="#/components/schemas/Projet"))
     *     )
     * )
     */
    public function getClosedWithLate()
    {
        $projets = Projet::where('dateFin', '<=', now())->whereRaw("ABS(DATEDIFF(dateFin, dateDebut)) > duree")->get();
        return ProjetResource::collection($projets);
    }

    /**
     * Update the specified resource in storage.
     * 
     * @OA\Put(
     *     path="/api/projets/{id}",
     *     tags={"Projets"},
     *     summary="Update project details",
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="ID of the project",
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\RequestBody(
     *         required=true,
     *         description="Updated project data",
     *         @OA\JsonContent(
     *             required={"intitule", "dateDebut", "dateFin", "duree"},
     *             @OA\Property(property="intitule", type="string"),
     *             @OA\Property(property="dateDebut", type="string", format="date"),
     *             @OA\Property(property="dateFin", type="string", format="date"),
     *             @OA\Property(property="duree", type="integer")
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Project updated successfully",
     *         @OA\JsonContent(ref="#/components/schemas/Projet")
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Project not found"
     *     )
     * )
     */
    public function update(Request $request, $id)
    {
        $projet = Projet::find($id);
        if (!$projet) {
            return response()->json([
                "error" => "Resource not Found",
                "message" => "projet with ID $id doesn't exist"
            ], 404);
        }
        $projet->update($request->all());
        return new ProjetResource($projet);
    }

    /**
     * Remove the specified resource from storage.
     * 
     * @OA\Delete(
     *     path="/api/projets/{id}",
     *     tags={"Projets"},
     *     summary="Delete project",
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="ID of the project",
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Project deleted successfully"
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Project not found"
     *     )
     * )
     */
    public function destroy($id)
    {
        $projet = Projet::find($id);
        if (!$projet) {
            return response()->json([
                "error" => "Resource not Found",
                "message" => "projet with ID $id doesn't exist"
            ], 404);
        }
        Projet::destroy($id);
        return response()->json("projet with ID $id is deleted succesfully", 200);
    }

     /**
     * Attach personnes to a project
     * 
     * @OA\Post(
     *     path="/api/projets/{id}/attach-personnes",
     *     tags={"Projets"},
     *     summary="Attach personnes to a project",
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="ID of the project",
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\RequestBody(
     *         required=true,
     *         description="Array of personne IDs to attach",
     *         @OA\JsonContent(
     *             required={"personne_ids"},
     *             @OA\Property(
     *                 property="personne_ids",
     *                 type="array",
     *                 @OA\Items(type="integer")
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Personnes attached successfully",
     *         @OA\JsonContent(ref="#/components/schemas/Projet")
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Project not found"
     *     )
     * )
     */
    public function attachPersonnes(Request $request, $id)
    {
        // Find the project
        $projet = Projet::find($id);
        if (!$projet) {
            return response()->json([
                "error" => "Resource not Found",
                "message" => "projet with ID $id doesn't exist"
            ], 404);
        }

        // Validate the request
        $request->validate([
            'personne_ids' => 'required|array',
            'personne_ids.*' => 'integer|exists:personnes,id',
        ]);

        // Attach the personnes to the project
        $projet->personnes()->syncWithoutDetaching($request->personne_ids);

        return response()->json([
            "message" => "Personnes attached successfully",
            "projet" => new ProjetResource($projet)
        ], 200);
    }
}
