<?php

namespace App\Http\Middleware;

use App\Models\Users\User;
use App\Services\MessageService;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class AdminMiddlware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {


        $user = User::auth();

        if (!$user->isAdmin()) {
            MessageService::abort(403, 'ليس لديك الصلاحية للقيام بهذه العملية');
        }

        return $next($request);
    }
}
