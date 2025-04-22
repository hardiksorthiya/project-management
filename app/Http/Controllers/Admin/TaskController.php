<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Project;
use App\Models\Task;
use App\Models\User;
use Illuminate\Http\Request;

class TaskController extends Controller
{
    public function index(Project $project)
    {
        $tasks = $project->tasks()->with('assignee')->get(); // Make sure this line exists
        return view('admin.tasks.index', compact('project', 'tasks'));
    }

    public function create(Project $project)
    {
        $users = User::all();
        $tasks = $project->tasks()->whereNull('parent_id')->get();
        $allProjects = Project::all(); // ✅ Add this
    
        return view('admin.tasks.create', [
            'project' => $project,
            'users' => $users,
            'tasks' => $tasks,
            'task' => null,
            'allProjects' => $allProjects // ✅ Pass it to the view
        ]);
    }

    public function store(Request $request, Project $project)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'due_at' => 'required|date',
        ]);

        Task::create([
            'project_id' => $request->project_id,
            'parent_id' => $request->parent_id,
            'assigned_to' => $request->assigned_to,
            'title' => $request->title,
            'description' => $request->description,
            'start_at' => $request->start_at,
            'due_at' => $request->due_at,
            'status' => $request->status,
            'priority' => $request->priority,
        ]);

        return redirect()->route('task.index', $project->id)->with('success', 'Task created successfully.');
    }

    public function edit(Task $task)
{
    $project = $task->project;
    $users = User::all();
    $tasks = Task::where('project_id', $project->id)
                 ->whereNull('parent_id')
                 ->where('id', '!=', $task->id)
                 ->get();
    $allProjects = Project::all(); // ✅ Add this

    return view('admin.tasks.create', compact('project', 'task', 'users', 'tasks', 'allProjects'));
}

    public function update(Request $request, Task $task)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'due_at' => 'required|date',
        ]);

        $task->update([
            'parent_id' => $request->parent_id,
            'assigned_to' => $request->assigned_to,
            'title' => $request->title,
            'description' => $request->description,
            'start_at' => $request->start_at,
            'due_at' => $request->due_at,
            'status' => $request->status,
            'priority' => $request->priority,
        ]);

        return redirect()->route('projects.task.index', $task->project_id)->with('success', 'Task updated successfully.');
    }

    public function destroy(Task $task)
    {
        $projectId = $task->project_id;
        $task->delete();

        return redirect()->route('projects.task.index', $projectId)->with('success', 'Task deleted successfully.');
    }

    public function all()
{
    $tasks = \App\Models\Task::with('project', 'assignee')->latest()->get();
    return view('admin.tasks.all', compact('tasks'));
}
}
