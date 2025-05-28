<?php

namespace App\Http\Controllers;

use App\Http\Resources\ProjectDetailResource;
use App\Http\Resources\ProjectResource;
use App\Models\Project;

class ProjectController extends Controller
{
    /**
     * @OA\Get(
     *     path="/api/projects",
     *     summary="Get all projects",
     *     tags={"Projects"},
     *
     *     @OA\Response(
     *         response=200,
     *         description="Get all projects"
     *     )
     * )
     */
    public function index()
    {
        return ProjectResource::collection(Project::active()->paginate(12));
    }

    /**
     * @OA\Get(
     *     path="/api/projects/{project:slug}",
     *     summary="Get an project by slug",
     *     tags={"Projects"},
     *
     *     @OA\Parameter(
     *         name="project",
     *         in="path",
     *         required=true,
     *         description="Project slug",
     *
     *         @OA\Schema(type="string")
     *     ),
     *
     *     @OA\Response(
     *         response=200,
     *         description="Get an project by slug"
     *     )
     * )
     */
    public function show(Project $project)
    {
        return ProjectDetailResource::make($project);
    }
}
