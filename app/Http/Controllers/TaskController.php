<?php

namespace App\Http\Controllers;

use App\Models\Task;
use Illuminate\Http\Request;

class TaskController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function __construct()
    {
        $this->middleware('auth:sanctum');
    }

    public function index()
    {
        $tasks = Task::latest()->paginate(8);
        return response()->json($tasks);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|unique:tasks,title|max:200',
            'description' => 'required|max:2000',
            'date' => 'required|date|after:today',
        ]);
        Task::create([
            'title' => $request->title,
            'description' => $request->description,
            'date' => $request->date
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
        return response()->json($task);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Task $task)
    {
        $request->validate([
            'title' => 'required|max:200',
            'description' => 'required|max:2000',
            'date' => 'required|date|after:today',
        ]);
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
}
