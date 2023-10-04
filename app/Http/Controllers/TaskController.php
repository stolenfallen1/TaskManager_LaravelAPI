<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreTaskRequest;
use App\Http\Requests\UpdateTaskRequest;
use App\Http\Resources\TaskCollection;
use App\Http\Resources\TaskResource;
use App\Models\Task;
use Illuminate\Http\Request;
use Spatie\QueryBuilder\QueryBuilder;

class TaskController extends Controller
{
    // This method returns a collection of tasks 
    public function index(Request $request)
    {
        // Adding pagination, filters and sorting to the query
        $tasks = QueryBuilder::for(Task::class)
            ->allowedFilters('is_done')
            ->defaultSort('-created_at')
            ->allowedSorts('title', 'is_done', 'created_at')
            ->paginate();
        return new TaskCollection($tasks);
    }

    // This method returns a single task
    public function show(Request $request, Task $task)
    {
        return new TaskResource($task);
    }

    // This method creates a new task
    public function store(StoreTaskRequest $request)
    {
        $validate = $request->validated();
        $task = Task::create($validate);
        return new TaskResource($task);
    }

    // This method updates a task
    public function update(UpdateTaskRequest $request, Task $task)
    {
        $validate = $request->validated();
        $task->update($validate);
        return new TaskResource($task);
    }

    // This method deletes a task
    public function destroy(Request $request, Task $task)
    {
        $task->delete();
        return response()->noContent();
    }
}
