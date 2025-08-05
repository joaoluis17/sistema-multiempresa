<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Task;
use Illuminate\Support\Facades\Auth;

class TaskController extends Controller
{
    public function index(Request $request)
    {
        $user = Auth::user();

        $tasks = Task::where('company_id', $user->company_id)
            ->when($request->status, fn($q) => $q->where('status', $request->status))
            ->when($request->priority, fn($q) => $q->where('priority', $request->priority))
            ->get();

        return response()->json($tasks);
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'status' => 'required|in:pendente,em_andamento,concluida',
            'priority' => 'required|in:baixa,media,alta',
            'due_date' => 'nullable|date',
        ]);

        $user = Auth::user();

        $task = Task::create(array_merge(
            $request->only(['title', 'description', 'status', 'priority', 'due_date']),
            [
                'user_id' => $user->id,
                'company_id' => $user->company_id,
            ]
        ));

        return response()->json($task, 201);
    }

    public function show($id)
    {
        $task = Task::where('id', $id)
            ->where('company_id', Auth::user()->company_id)
            ->firstOrFail();

        return response()->json($task);
    }

    public function update(Request $request, $id)
    {
        $task = Task::where('id', $id)
            ->where('company_id', Auth::user()->company_id)
            ->firstOrFail();

        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'status' => 'required|in:pendente,em_andamento,concluida',
            'priority' => 'required|in:baixa,media,alta',
            'due_date' => 'nullable|date',
        ]);

        $task->update($request->only(['title', 'description', 'status', 'priority', 'due_date']));

        return response()->json($task);
    }

    public function destroy($id)
    {
        $task = Task::where('id', $id)
            ->where('company_id', Auth::user()->company_id)
            ->firstOrFail();

        $task->delete();

        return response()->json(['message' => 'Tarefa deletada com sucesso']);
    }
}
