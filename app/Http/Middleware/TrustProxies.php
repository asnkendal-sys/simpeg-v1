<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class TrustProxies
{
    /**
     * Proxy yang dipercaya. '*' = semua proxy.
     */
    protected $proxies = '*';

    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \Closure $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if ($this->proxies === '*') {
            // 1 = HEADER_X_FORWARDED_FOR
            // 2 = HEADER_X_FORWARDED_HOST
            // 4 = HEADER_X_FORWARDED_PROTO
            // 8 = HEADER_X_FORWARDED_PORT
            $flags = 1 | 2 | 4 | 8;

            $request->setTrustedProxies([$request->getClientIp()], $flags);
        } else {
            $flags = 1 | 2 | 4 | 8;
            $request->setTrustedProxies($this->proxies, $flags);
        }

        return $next($request);
    }
}
