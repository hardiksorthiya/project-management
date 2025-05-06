<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\RoleController;
use App\Http\Controllers\Admin\TaskController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\ClientController;
use App\Http\Controllers\Admin\ProjectController;
use App\Http\Controllers\Admin\Export\ClientReportExportController;

Route::get('/', function () {
    return view('welcome');
});

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {
    Route::get('/dashboard', function () {
        return view('admin.dashboard');
    })->name('dashboard');
});

Route::resource('users', UserController::class);
Route::resource('roles', RoleController::class);
Route::resource('clients', ClientController::class);
Route::resource('projects', ProjectController::class);
Route::resource('projects.task', TaskController::class)->shallow(); // Shallow routing for tasks under projects
Route::get('tasks', [TaskController::class, 'all'])->name('tasks.all'); // Get all tasks
Route::get('tasks/create', [TaskController::class, 'createUnified'])->name('tasks.createUnified');
Route::post('tasks/store', [TaskController::class, 'storeUnified'])->name('tasks.storeUnified');





// Export Routes
Route::get('admin/clients/export/excel', [ClientController::class, 'exportExcel'])->name('clients.export.excel');
Route::get('admin/clients/export/pdf', [ClientController::class, 'exportPdf'])->name('clients.export.pdf');
