<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Task;
use App\Http\Requests\TaskStore;
use App\Http\Requests\TaskUpdate;
use App\Http\Resources\TaskResources;
use App\Http\Resources\TaskCollection;
use Illuminate\Http\Request;

use Illuminate\Http\JsonResponse;

class TaskController extends Controller
{
    protected $task;

    public function __construct(Task $task){
        $this->task =  $task;
    }

    /**
     * Display a listing of the resource.
     */
    public function index(): JsonResponse
    {
        return response()->json(
            new TaskCollection(
                $this->task->orderBy('id','desc')->get()
            )
        );
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request): JsonResponse
    {
        $task = $this->task->create($request->all());
        return response()->json(new TaskResources($task), 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(Task $task)
    {
        return response()->json(
            new TaskResources($task)
        );
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(TaskRequest $request, Task $task): JsonResponse
    {
        $task->update($request->all());
        return response()->json(new TaskResources($task));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Task $task)
    {
        $task->delete();
        return response()->json(null, 204);
    }

    public function changeStatus(Task $task, $taskId) {
        $task->where('id',$taskId)->update(['status' => request()->status]);
        return response()->json(new TaskResources($task));
    }
}
