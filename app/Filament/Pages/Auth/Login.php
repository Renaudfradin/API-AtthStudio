<?php

namespace App\Filament\Pages\Auth;

class Login extends \Filament\Auth\Pages\Login
{
    public function mount(): void
    {
        parent::mount();

        $this->form->fill([
            'email' => 'demo@gmail.com',
            'password' => 'demo@gmail.com',
            'remember' => true,
        ]);
    }

    protected function rateLimit($maxAttempts, $decaySeconds = 60, $method = null, $component = null)
    {
        $method ??= debug_backtrace(DEBUG_BACKTRACE_IGNORE_ARGS, limit: 2)[1]['function'] ?? null;

        parent::rateLimit(
            (int) config('rate_limiting.login.limit', $maxAttempts),
            $decaySeconds,
            $method,
            $component,
        );
    }
}
