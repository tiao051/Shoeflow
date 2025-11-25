<?php

use Illuminate\Support\Facades\Broadcast;

// Kênh cho User thường
Broadcast::channel('chat.{id}', function ($user, $id) {
    return (int) $user->id === (int) $id || $user->role_id === 2; 
});

Broadcast::channel('admin.chat', function ($user) {
    return $user->role_id === 2; 
});