<?php

namespace App\Http\Middleware;

use App\Models\Users\User;
use App\Services\MessageService;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class ChildMiddleware
{
    public function handle(Request $request, Closure $next): Response
    {

        $user = User::auth();

        if (!$user->isPatient()) {
            MessageService::abort(403, 'ليس لديك الصلاحية للقيام بهذه العملية');
        }

        if (!$user->patient->isChild()) {
            MessageService::abort(403, 'ليس لديك الصلاحية للقيام بهذه العملية');
        }

        return $next($request);
    }
}
