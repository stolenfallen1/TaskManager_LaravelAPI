<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreProjectRequest;
use App\Http\Requests\UpdateProjectRequest;
use App\Http\Resources\ProjectCollection;
use App\Http\Resources\ProjectResource;
use App\Models\Project;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Spatie\QueryBuilder\QueryBuilder;

class ProjectController extends Controller
{
    //
    // Index all projects
    public function index(Request $request)
    {
        $projects = QueryBuilder::for(Project::class)
            ->allowedIncludes('tasks')
            ->paginate();
        return new ProjectCollection($projects);
    }

    // Store / Create a new project
    public function store(StoreProjectRequest $request)
    {
        // Validate the request
        $validate = $request->validated();
        // Create the project
        $project = Auth::user()->projects()->create($validate);
        return new ProjectResource($project);
    }

    // Show a project
    public function show(Request $request, Project $project)
    {
        return (new ProjectResource($project))->load('tasks');
    }

    // Update a project
    public function update(UpdateProjectRequest $request, Project $project)
    {
        $validate = $request->validated();
        // Update the project
        $project->update($validate);
        return new ProjectResource($project);
    }

    // Delete a project
    public function destroy(Request $request, Project $project)
    {
        $project->delete();
        return response()->noContent();
    }
}
