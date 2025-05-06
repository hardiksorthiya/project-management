<?php

namespace App\Http\Controllers\Admin;

use App\Models\Task;
use App\Models\User;
use App\Models\Project;
use App\Exports\TaskExport;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Http\Controllers\Controller;
use Maatwebsite\Excel\Facades\Excel;

class TaskController extends Controller
{
    public function index(Project $project)
    {
        $tasks = $project->tasks()->with('assignee')->get(); // Make sure this line exists
        return view('admin.tasks.index', compact('project', 'tasks'));
    }
    public function createUnified()
{
    $allProjects = Project::all();
    $users = User::all();
    $tasks = Task::whereNull('parent_id')->get();

    return view('admin.tasks.create', [
        'allProjects' => $allProjects,
        'users' => $users,
        'tasks' => $tasks,
        'task' => null,
        'project' => null // so the blade knows it’s coming from global create
    ]);
}

public function storeUnified(Request $request)
{
    $request->validate([
        'project_id' => 'required|exists:projects,id',
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

    return redirect()->route('tasks.all')->with('success', 'Task created successfully.');
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

        return redirect()->route('projects.task.index', $project->id)->with('success', 'Task created successfully.');
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
public function show(Task $task)
{
    $project = $task->project;
    $assignee = $task->assignee;
    $subtasks = Task::where('parent_id', $task->id)->get();
    $allProjects = Project::all(); // ✅ Add this
    $users = User::all(); // ✅ Add this
    return view('admin.tasks.show', compact('task', 'project', 'assignee', 'subtasks', 'allProjects', 'users'));
}

    public function all()
{
    $tasks = Task::with('project', 'assignee')->latest()->get();
    return view('admin.tasks.all', compact('tasks'));
}

public function exportExcel()
{
    return Excel::download(new TaskExport, 'task.xlsx');
}

public function exportPdf()
{
    $tasks = Task::with('project', 'assignee')->latest()->get();
    $pdf = Pdf::loadView('admin.tasks.export-pdf', compact('tasks'));
    return $pdf->download('tasks.pdf');
}

public function bulkAction(Request $request)
{
    $action = $request->input('action');
    $selectedIds = $request->input('selected_ids', []);

    if (empty($selectedIds)) {
        return redirect()->back()->with('error', 'No tasks selected.');
    }

    if ($action === 'delete') {
        Task::whereIn('id', $selectedIds)->delete();
        return redirect()->back()->with('success', 'Selected tasks deleted.');
    }

    if ($action === 'export_excel') {
        return Excel::download(new TaskExport($selectedIds), 'selected_tasks.xlsx');
    }

    if ($action === 'export_pdf') {
        $tasks = Task::with('project', 'assignee')->whereIn('id', $selectedIds)->get();
        $pdf = Pdf::loadView('admin.tasks.export-pdf', compact('tasks'));
        return $pdf->download('selected_tasks.pdf');
    }

    return redirect()->back()->with('error', 'Invalid action.');
}
}
