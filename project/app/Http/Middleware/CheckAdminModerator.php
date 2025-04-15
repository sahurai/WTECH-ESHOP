<?php

namespace App\Http\Middleware;

use App\Models\User;
use Closure;
use Illuminate\Http\Request;

class CheckAdminModerator
{
    /**
     * Handle an incoming request.
     *
     * @param Request $request
     * @param Closure $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next): mixed
    {
        $user = auth()->user();

        // Check if the authenticated user has role 'admin' or 'moderator'
        if (!$user instanceof User || !$user->roles()->whereIn('name', ['admin', 'moderator'])->exists()) {
            return redirect()->route('books.index')
                ->with('error', 'You are not authorized to perform this action.');
        }

        return $next($request);
    }
}
