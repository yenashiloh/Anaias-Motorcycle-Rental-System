<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Symfony\Component\HttpFoundation\Response;

class AdminAuthenticate
{
    public function handle(Request $request, Closure $next)
    {
        try {
            if (!Auth::guard('admin')->check()) {
                return redirect()->route('admin.admin-login');
            }

            DB::connection()->getPdo()->setAttribute(\PDO::ATTR_EMULATE_PREPARES, true);
            
            return $next($request);
        } catch (\Exception $e) {
            \Log::error('Database connection error: ' . $e->getMessage());
            
            DB::disconnect();
            
            return redirect()->route('admin.admin-login')
                ->with('error', 'Database connection error. Please try again.');
        }
    }
}