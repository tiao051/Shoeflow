// app/Http/Kernel.php

// ...

/**
 * The application's route middleware aliases.
 *
 * These middleware may be assigned to groups or used individually.
 *
 * @var array<string, class-string>
 */
protected array $routeMiddleware = [
    'auth' => \App\Http\Middleware\Authenticate::class,
    'auth.session' => \Illuminate\Session\Middleware\AuthenticateSession::class,
    'cache.headers' => \Illuminate\Http\Middleware\SetCacheHeaders::class,
    'can' => \Illuminate\Auth\Middleware\Authorize::class,
    'guest' => \App\Http\Middleware\RedirectIfAuthenticated::class,
    'has_role' => \App\Http\Middleware\HasRole::class, // Thường là tên thay thế nếu dùng gói Spatie
    'password.confirm' => \Illuminate\Auth\Middleware\RequirePasswordConfirmation::class,
    'signed' => \Illuminate\Routing\Middleware\ValidateSignature::class,
    'throttle' => \Illuminate\Routing\Middleware\ThrottleRequests::class,
    'verified' => \Illuminate\Auth\Middleware\EnsureEmailIsVerified::class,

    // Middleware Tùy chỉnh
    'role' => \App\Http\Middleware\RoleMiddleware::class, // Middleware kiểm tra vai trò động
];

// ...