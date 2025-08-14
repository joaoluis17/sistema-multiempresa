<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Task;
use Illuminate\Support\Facades\Auth;

class TaskController extends Controller
{
    public function index()
    {
        return Task::where('company_id', auth()->user()->company_id)->get();
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'status' => 'required|in:pending,in_progress,completed',
            'priority' => 'required|in:low,medium,high',
            'due_date' => 'nullable|date'
        ]);

        $task = Task::create([
            'company_id' => auth()->user()->company_id,
            'user_id' => auth()->id(),
            ...$request->only(['title', 'description', 'status', 'priority', 'due_date'])
        ]);

        return response()->json($task, 201);
    }
}
