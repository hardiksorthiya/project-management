<?php

namespace App\Http\Controllers\Admin;

use App\Models\Client;
use Illuminate\Http\Request;
use App\Exports\ClientsExport;
use App\Http\Controllers\Controller;
use Maatwebsite\Excel\Facades\Excel;
use Barryvdh\DomPDF\Facade\Pdf;

class ClientController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $clients = Client::latest()->paginate(10); // Show 10 per page
        // Return the view with the clients data
        return view('admin.clients.index', compact('clients'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        // Return the view to create a new client
        return view('admin.clients.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Validate the request data
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'nullable|email|max:255',
            'phone' => 'nullable|string|max:20',
            'company_name' => 'nullable|string|max:255',
            'address' => 'nullable|string|max:500',
        ]);

        // Create a new client
        Client::create($request->all());

        // Redirect to the clients index with a success message
        return redirect()->route('clients.index')->with('success', 'Client created successfully.');
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
    public function edit(string $id)
    {
        // Find the client by ID
        $client = Client::findOrFail($id);

        // Return the view to edit the client
        return view('admin.clients.create', compact('client'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        // Validate the request data
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'nullable|email|max:255',
            'phone' => 'nullable|string|max:20',
            'company_name' => 'nullable|string|max:255',
            'address' => 'nullable|string|max:500',
        ]);

        // Find the client by ID and update it
        $client = Client::findOrFail($id);
        $client->update($request->all());

        // Redirect to the clients index with a success message
        return redirect()->route('clients.index')->with('success', 'Client updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        // Find the client by ID and delete it
        $client = Client::findOrFail($id);
        $client->delete();

        // Redirect to the clients index with a success message
        return redirect()->route('clients.index')->with('success', 'Client deleted successfully.');
    }

    public function exportExcel()
    {
        return Excel::download(new ClientsExport, 'clients.xlsx');
    }

    public function exportPdf()
    {
        $clients = Client::all();
        $pdf = Pdf::loadView('admin.clients.export-pdf', compact('clients'));
        return $pdf->download('clients.pdf');
    }
}
