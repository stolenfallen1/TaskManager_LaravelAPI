<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreProjectRequest;
use App\Http\Requests\UpdateProjectRequest;
use App\Http\Resources\ProjectResource;
use App\Models\Project;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProjectController extends Controller
{
    //

    // Store / Create a new project
    public function store(StoreProjectRequest $request)
    {
        // Validate the request
        $validate = $request->validated();
        // Create the project
        $project = Auth::user()->projects()->create($validate);
        return new ProjectResource($project);
    }

    // Update a project
    public function update(UpdateProjectRequest $request, Project $project)
    {
        $validate = $request->validated();
        // Update the project
        $project->update($validate);
        return new ProjectResource($project);
    }
}
