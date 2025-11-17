<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class EnsurePaymentApproved
{
    public function handle(Request $request, Closure $next)
    {
        $user = $request->user();
        if (!$user) {
            return redirect()->route('login');
        }

        // allow admins and teachers
        if ($user->isAdmin() || $user->isTeacher()) {
            return $next($request);
        }

        // allow free lessons if route has lesson model bound
        $lesson = $request->route('lesson');
        if ($lesson && $lesson->is_free) {
            return $next($request);
        }

        // allow if user's payment is approved and not expired
        if ($user->payment_status === 'approved' && $user->payment_expiry && $user->payment_expiry->isFuture()) {
            return $next($request);
        }

        return redirect()->route('payment.upload')->with('warning', 'Access locked. Upload payment proof.');
    }
}
