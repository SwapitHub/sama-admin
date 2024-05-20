<?php

namespace App\Http\Middleware;
use Illuminate\Support\Facades\View;
use App\Models\SiteInfo;

use Closure;
use Illuminate\Http\Request;

class ShareWebInfo
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        $webInfo = SiteInfo::first(); // Retrieve dynamic content from the database
        View::share('webInfo', $webInfo); // Share the content with all views
        return $next($request);
    }
}
