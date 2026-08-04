<?php

namespace App\Http\Middleware;

use Filament\Facades\Filament;
use Filament\Models\Contracts\FilamentUser;
use Illuminate\Auth\Middleware\Authenticate;
use Illuminate\Database\Eloquent\Model;

class AuthenticateDashboardUser extends Authenticate
{
    /**
     * @param  array<string>  $guards
     */
    protected function authenticate($request, array $guards): void
    {
        $guard = Filament::auth();

        if (! $guard->check()) {
            $this->unauthenticated($request, $guards);

            return;
            /** @phpstan-ignore-line */
        }

        $this->auth->shouldUse(Filament::getAuthGuard());

        /** @var Model $user */
        $user = $guard->user();

        $panel = Filament::getCurrentOrDefaultPanel();

        // Security: If the user model does not implement `FilamentUser`,
        // access is only allowed in local environments. In production,
        // implement `FilamentUser` with `canAccessPanel()`.

        $userCanAccessPanel = $user instanceof FilamentUser ? $user->canAccessPanel($panel) : (config('app.env') !== 'local');
        $userIsEnabled = $user->is_active ?? false;

        abort_if(! $userCanAccessPanel || ! $userIsEnabled, 403);
    }

    protected function redirectTo($request): ?string
    {
        return Filament::getLoginUrl();
    }
}
