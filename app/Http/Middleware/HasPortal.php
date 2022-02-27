<?php

namespace App\Http\Middleware;

use App\Models\UserPortal;
use Closure;
use Illuminate\Support\Facades\Auth;

class HasPortal
{
    /**
     * Handle an incoming request.
     *
     * @param \Illuminate\Http\Request $request
     * @param \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */

    public function hasPortal($portal)
    {
        $userPortals = UserPortal::where('user_id', Auth::id())->get();
        $i = 0;
        foreach ($userPortals as $userPortal) {
            if ($userPortal->portal->name == $portal) {
                return true;
            } elseif ($i == $userPortal->count()) {
                return false;
            }
            $i++;
        }
    }

    public function handle($request, Closure $next, $agenda)
    {
        if (!$this->hasPortal($agenda)) {
            return response([
                'hasPortal' => false,
            ]);
        }

        return $next($request);
    }

}
