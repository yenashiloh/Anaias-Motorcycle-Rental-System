<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Symfony\Component\HttpFoundation\Response;

class CustomerAuthenticate
{
    public function handle(Request $request, Closure $next)
    {
        try {
            if (!Auth::guard('customer')->check()) {
                return redirect()->route('login');
            }

            DB::connection()->getPdo()->setAttribute(\PDO::ATTR_EMULATE_PREPARES, true);
            
            return $next($request);
        } catch (\Exception $e) {
            \Log::error('Database connection error in customer authentication: ' . $e->getMessage());
            
            DB::disconnect();
            
            return redirect()->route('login')
                ->with('error', 'Connection error. Please try again.');
        }
    }
}