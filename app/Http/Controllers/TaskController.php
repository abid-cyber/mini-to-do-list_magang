<?php

namespace App\Http\Controllers;

use App\Models\Task;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;

class TaskController extends Controller
{
    /**
     * Display the user's task list (Dashboard).
     */
    public function index(Request $request): Response
    {
        $tasks = $request->user()->tasks()->latest()->get();

        return Inertia::render('Dashboard', [
            'tasks' => $tasks,
        ]);
    }

    /**
     * Store a newly created task.
     */
    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string|max:1000',
        ]);

        $request->user()->tasks()->create($validated);

        return redirect()->back()->with('success', 'Tugas berhasil ditambahkan!');
    }

    /**
     * Update the specified task.
     */
    public function update(Request $request, Task $task): RedirectResponse
    {
        // Ensure the user owns this task (privacy)
        if ($task->user_id !== $request->user()->id) {
            abort(403);
        }

        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string|max:1000',
        ]);

        $task->update($validated);

        return redirect()->back()->with('success', 'Tugas berhasil diperbarui!');
    }

    /**
     * Toggle the completion status of a task.
     */
    public function toggleComplete(Request $request, Task $task): RedirectResponse
    {
        // Ensure the user owns this task (privacy)
        if ($task->user_id !== $request->user()->id) {
            abort(403);
        }

        $task->update([
            'is_completed' => !$task->is_completed,
        ]);

        return redirect()->back();
    }

    /**
     * Remove the specified task.
     */
    public function destroy(Request $request, Task $task): RedirectResponse
    {
        // Ensure the user owns this task (privacy)
        if ($task->user_id !== $request->user()->id) {
            abort(403);
        }

        $task->delete();

        return redirect()->back()->with('success', 'Tugas berhasil dihapus!');
    }
}
