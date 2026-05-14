<?php

namespace App\Http\Middleware;

use App\Models\Branch;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\View;
use Symfony\Component\HttpFoundation\Response;

class SetCurrentBranch
{
    public function handle(Request $request, Closure $next): Response
    {
        $branchId = session('current_branch_id');
        $branch   = $branchId ? Branch::find($branchId) : null;

        View::share('currentBranch', $branch);

        return $next($request);
    }
}
