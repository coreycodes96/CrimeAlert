<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AnnouncementController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\SearchController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\NotificationController;

//Views
Route::get('/announcements', [AnnouncementController::class, 'index']);
Route::get('/posts', [PostController::class, 'index']);
Route::get('/profile/{username}', [ProfileController::class, 'show']);
Route::get('/notifications', [NotificationController::class, 'index']);

Route::middleware('ajax')->group(function () {
    //Announcements
    Route::get('/announcements/get_announcements', [AnnouncementController::class, 'getAnnouncements']);

    //Posts
    Route::get('/posts/show', [PostController::class, 'show']);
    Route::post('/posts/create', [PostController::class, 'create']);
    Route::delete('/posts/delete/{id}', [PostController::class, 'destroy']);
    Route::post('/posts/like', [PostController::class, 'like']);
    Route::delete('/posts/unlike/{id}', [PostController::class, 'unlike']);

    //Comments
    Route::get('/comments/show/{id}', [CommentController::class, 'show']);
    Route::post('/comments/create', [CommentController::class, 'create']);
    Route::delete('/comments/delete/{id}', [CommentController::class, 'destroy']);
    Route::post('/comments/like/', [CommentController::class, 'like']);
    Route::delete('/comments/unlike/{id}', [CommentController::class, 'unlike']);

    //Search
    Route::post('/search/show', [SearchController::class, 'show']);

    //Profile
    Route::get('/profile/get_user_information/{username}', [ProfileController::class, 'userProfileInformation']);
    Route::post('/profile/favourite/', [ProfileController::class, 'favourite']);
    Route::delete('/profile/unfavourite/{id}', [ProfileController::class, 'unfavourite']);
    Route::put('/profile/change/username', [ProfileController::class, 'changeUsername']);
    Route::put('/profile/change/password', [ProfileController::class, 'changePassword']);
    Route::delete('/profile/delete/account/{id}', [ProfileController::class, 'deleteAccount']);

    //Notifications
    Route::get('/notifications/get_notifications', [NotificationController::class, 'getNotifications']);
    Route::get('/notifications/notification_count', [NotificationController::class, 'notificationCount']);
    Route::get('/notifications/mark_as_read_notifications', [NotificationController::class, 'markNotificationsAsRead']);
    Route::delete('/notifications/delete/notification/{id}', [NotificationController::class, 'deleteNotification']);
    Route::get('/notifications/get_notification/{id}', [NotificationController::class, 'getNotification']);
});
