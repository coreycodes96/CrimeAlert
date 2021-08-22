<?php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdminController;

//View
Route::get('/admin', [AdminController::class, 'index']);

Route::middleware('ajax')->group(function () {
    //Admin
    Route::get('/admin/user_posts', [AdminController::class, 'showUsersPosts']);
    Route::put('/admin/update/post', [AdminController::class, 'updatePostStatus']);
    Route::get('/admin/users', [AdminController::class, 'allUsers']);
    Route::delete('/admin/delete/users/account/{id}', [AdminController::class, 'deleteUsersAccount']);
    Route::get('/admin/announcements', [AdminController::class, 'getAnnouncements']);
    Route::post('/admin/create/announcement', [AdminController::class, 'createAnnouncement']);
    Route::delete('/admin/delete/announcement/{id}', [AdminController::class, 'deleteAnnouncement']);
});
