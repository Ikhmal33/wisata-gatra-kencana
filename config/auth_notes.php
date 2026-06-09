<?php
// Add this to your config/auth.php providers section:
// 'users' => [
//     'driver' => 'eloquent',
//     'model'  => App\Models\User::class,
// ],
//
// Also add this method to App\Models\User.php to use 'username' instead of 'email':
//
// public function getAuthIdentifierName(): string
// {
//     return 'username';
// }
//
// ── OR ── add to config/fortify.php if using Fortify:
// 'username' => 'username',
//
// The simplest approach: Override getAuthPassword() is NOT needed.
// Instead, ensure your LoginController passes ['username' => ..., 'password' => ...]
// to Auth::attempt() — which is already done in AuthController.php.
//
// Also add to your User model:
// protected $casts = ['email_verified_at' => 'datetime']; // remove if no email column

return [
    'NOTE' => 'This file documents the auth config changes needed. Apply them to your actual config/auth.php',
];
