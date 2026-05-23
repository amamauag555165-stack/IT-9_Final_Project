<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Admin\AdminDashboardController;
use App\Http\Controllers\EventController;
use App\Http\Controllers\OrganizationController;
use App\Http\Controllers\VolunteerController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/userdashboard', [VolunteerController::class, 'userdashboard'])->name('userdashboard');

Route::get('/myevents', [VolunteerController::class, 'myevents'])->name('myevents');


Route::middleware(['auth', 'verified'])->group(function () {

    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');

});

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    Route::get('/account', [VolunteerController::class, 'accountSettings'])->name('account.settings');
    Route::post('/password/change', [VolunteerController::class, 'changePassword'])->name('password.change');
});

Route::middleware('auth')->group(function () {
    Route::get('/events', [EventController::class, 'index'])->name('events');
    Route::get('/events/create', [EventController::class, 'create'])->name('events.create');
    Route::post('/events', [EventController::class, 'store'])->name('events.store');
    Route::get('/events/{event}', [EventController::class, 'show'])->name('events.show');
    Route::post('/events/{event}/join', [EventController::class, 'join'])->name('events.join');
    Route::post('/events/{event}/leave', [EventController::class, 'leave'])->name('events.leave');
    Route::get('/events/{event}/edit', [EventController::class, 'edit'])->name('events.edit');
    Route::put('/events/{event}', [EventController::class, 'update'])->name('events.update');
    Route::post('/events/{event}/announcements', [EventController::class, 'createAnnouncement'])->name('events.announcements.create');
    Route::delete('/events/{event}', [EventController::class, 'destroy'])->name('events.cancel');
});

Route::middleware('auth')->group(function () {
    Route::get('/organization', [OrganizationController::class, 'index'])->name('organization.index');
    Route::post('/organization', [OrganizationController::class, 'store'])->name('organization.store');
});

Route::middleware('auth')->get('/profiles', function(){
    return view('volunteers.profile');
})->name('profiles');




Route::middleware(['auth', 'role:admin'])->group(function () {

    Route::get('/admin', [AdminDashboardController::class, 'index'])
        ->name('admin.dashboard');
    Route::get('/admin/organizations', [AdminDashboardController::class, 'organizations'])
        ->name('admin.organizations.index');
    Route::get('/admin/events', [AdminDashboardController::class, 'events'])
        ->name('admin.events.index');
    Route::patch('/admin/organizations/{organization}/approve', [AdminDashboardController::class, 'approveOrganization'])
        ->name('admin.organizations.approve');
    Route::patch('/admin/organizations/{organization}/reject', [AdminDashboardController::class, 'rejectOrganization'])
        ->name('admin.organizations.reject');
    Route::delete('/admin/organizations/{organization}', [AdminDashboardController::class, 'deleteOrganization'])
        ->name('admin.organizations.delete');
    Route::patch('/admin/events/{event}/approve', [EventController::class, 'approve'])
        ->name('admin.events.approve');
    Route::patch('/admin/events/{event}/reject', [EventController::class, 'reject'])
        ->name('admin.events.reject');

});

require __DIR__.'/auth.php';
