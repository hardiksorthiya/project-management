<?php

namespace App\Http\Controllers\Admin;

use App\Models\User;
use App\Models\Client;
use App\Models\Project;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class ProjectController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // Fetch all projects with their related users and client
        $projects = Project::with(['users', 'client'])->get();

        // Return the view with the projects data
        return view('admin.projects.index', compact('projects'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
{
    $clients = Client::all();
    $users = User::all();
    // pass empty $project and $selectedUsers
    return view('admin.projects.create', [
        'clients' => $clients,
        'users' => $users,
        'project' => null,
        'selectedUsers' => [],
    ]);
}


    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'status' => 'required',
            'priority' => 'required',
        ]);

        $project = Project::create([
            'name' => $request->name,
            'description' => $request->description,
            'start_date' => $request->start_date,
            'end_date' => $request->end_date,
            'status' => $request->status,
            'priority' => $request->priority,
            'client_id' => $request->client_id,
            'created_by' => Auth::id(),
        ]);

        $project->users()->sync($request->user_ids);

        return redirect()->route('projects.index')->with('success', 'Project created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    

    public function edit(Project $project)
{
    $clients = Client::all();
    $users = User::all();
    $selectedUsers = $project->users->pluck('id')->toArray();

    return view('admin.projects.create', compact('project', 'clients', 'users', 'selectedUsers'));
}


    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Project $project)
    {
        $request->validate([
            'name' => 'required',
            'status' => 'required',
            'priority' => 'required',
        ]);

        $project->update([
            'name' => $request->name,
            'description' => $request->description,
            'start_date' => $request->start_date,
            'end_date' => $request->end_date,
            'status' => $request->status,
            'priority' => $request->priority,
            'client_id' => $request->client_id,
            'updated_by' => Auth::id(),
        ]);

        $project->users()->sync($request->user_ids);

        return redirect()->route('projects.index')->with('success', 'Project updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $project = Project::findOrFail($id);
        $project->users()->detach();
        $project->delete();

        return redirect()->route('projects.index')->with('success', 'Project deleted successfully.');
    }
}
