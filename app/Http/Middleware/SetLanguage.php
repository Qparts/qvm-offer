<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class SetLanguage
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
        // Set Languages Array
        $languages = ['en', 'ar'];
        // Get locale parameter from request
        $locale = request('locale');
        // Set app language if locale inside language array
        if(in_array($locale, $languages)) {
            app()->setLocale($locale);
        }
        return $next($request);
    }
}
