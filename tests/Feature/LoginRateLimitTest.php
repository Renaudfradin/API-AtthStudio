<?php

use App\Filament\Pages\Auth\Login;
use Illuminate\Support\Facades\RateLimiter;
use Livewire\Livewire;

it('applies the configured login rate limit on the admin form', function () {
    config(['rate_limiting.login.limit' => 1]);

    Livewire::test(Login::class)
        ->set('data.email', 'nobody@example.com')
        ->set('data.password', 'wrong-password')
        ->call('authenticate')
        ->assertHasErrors(['data.email']);

    $key = 'livewire-rate-limiter:'.sha1(Login::class.'|authenticate|127.0.0.1');

    expect(RateLimiter::tooManyAttempts($key, 1))->toBeTrue();

    Livewire::test(Login::class)
        ->set('data.email', 'nobody@example.com')
        ->set('data.password', 'wrong-password')
        ->call('authenticate')
        ->assertHasNoErrors();
});
