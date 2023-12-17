<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateTaskRequest;
use App\Http\Requests\UpdateTaskRequest;
use App\Models\Task;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TaskController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function __construct()
    {
        $this->middleware('auth:sanctum');
    }

    public function index(Request $request)
    {
        $tasks = Task::latest()->with("user");

        if ($request->has('status')) {
            $tasks->where('status', $request->status);
        }
        $tasks = $tasks->paginate(8);

        $isOwner = function ($task) {
            return $task->user_id === Auth::id();
        };

        $tasks->getCollection()->transform(function ($task) use ($isOwner) {
            $task['is_owner'] = $isOwner($task);
            return $task;
        });

        return response()->json($tasks);
    }


    /**
     * Store a newly created resource in storage.
     */
    public function store(CreateTaskRequest $request)
    {
        Task::create([
            'title' => $request->title,
            'description' => $request->description,
            'date' => $request->date,
            'user_id' => Auth::user()->id
        ]);
        return response()->json([
            "success" => "task create with success"
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(Task $task)
    {
        // $this->authorize('view', $task);

        $task->load('user'); // Ensure the 'user' relationship is loaded

        $isOwner = auth()->user()->id === $task->user->id;

        return response()->json([
            'task' => $task,
            'is_owner' => $isOwner,
        ]);
    }


    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateTaskRequest $request, Task $task)
    {
        $task->update([
            'title' => $request->title,
            'description' => $request->description,
            'date' => $request->date
        ]);
        return response()->json([
            "success" => "task update with success"
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Task $task)
    {
        //
        $task->delete();
        return response()->json([
            "success" => "task delete with success"
        ]);
    }

    public function SwitchStatus(Task $task)
    {
        $task->update([
            'status' => $task->status == 0 ? 1 : 0
        ]);
        return response()->json([
            "success" => "task update with success"
        ]);
    }
}
