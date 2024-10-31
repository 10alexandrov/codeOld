<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\DB;

class TimeoutMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $timeout = 3;

        if (function_exists('pcntl_alarm')) {
            pcntl_signal(SIGALRM, function() {
                throw new \Exception('Timeout exceeded');
            });

            pcntl_alarm($timeout);

            try {
                $response = null;

                DB::transaction(function () use ($request, $next, &$response) {
                    $response = $next($request);
                });

                pcntl_alarm(0);

                return $response;
            } catch (Throwable $e) {
                pcntl_alarm(0);

                if ($e->getMessage() === 'Timeout exceeded') {
                    return redirect()->route('timeout');
                }

                throw $e;
            }
        } else {
            try {
                $startTime = microtime(true);

                $response = DB::transaction(function () use ($request, $next) {
                    return $next($request);
                });

                $elapsedTime = microtime(true) - $startTime;
                if ($elapsedTime > $timeout) {
                    return redirect()->route('timeout');
                }

                return $response;
            } catch (Throwable $e) {
                return redirect()->route('timeout');
            }
        }
    }
}
