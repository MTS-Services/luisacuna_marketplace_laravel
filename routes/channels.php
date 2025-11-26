<?php

use App\Models\Admin;
use App\Models\User;
use Illuminate\Support\Facades\Broadcast;


/*
|--------------------------------------------------------------------------
| Broadcast Channels
|--------------------------------------------------------------------------
|
| Here you may register all of the event broadcasting channels that your
| application supports. The given channel authorization callbacks are
| used to check if an authenticated user can listen to the channel.
|
*/

Broadcast::routes();



// Broadcast::channel('App.Models.User.{id}', function ($user, $id) {
//     return (int) $user->id === (int) $id;
// });


// // User private notification channel
// Broadcast::channel('users.{id}', function (User $user, $id) {
//     return (int) $user->id === (int) $id;
// });

// // Admin private notification channel
// Broadcast::channel('admins.{id}', function (Admin $admin, $id) {
//     return (int) $admin->id === (int) $id;
// }, ['guards' => ['admin']]);

// // Example: User-specific order channel
// Broadcast::channel('orders.{orderId}', function (User $user, int $orderId) {
//     return $user->id === \App\Models\Order::findOrNew($orderId)->user_id;
// });

// // Public channel (optional - no authorization needed)
// Broadcast::channel('public-announcements', function () {
//     return true;
// });

Broadcast::channel('user.{userId}', function ($user, $userId) {
    return (int) $user->id === (int) $userId;
}, ['guards' => ['web']]);

Broadcast::channel('admin.{adminId}', function ($admin, $adminId) {
    return (int) $admin->id === (int) $adminId;
}, ['guards' => ['admin']]);
