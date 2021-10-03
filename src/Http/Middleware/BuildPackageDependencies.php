<?php

namespace Latus\Laravel\Http\Middleware;


use Closure;
use Illuminate\Http\Request;

class BuildPackageDependencies
{

    protected static array $middlewareDependencyClosures = [];

    public static function addDependencyClosure(Closure $closure)
    {
        self::$middlewareDependencyClosures[] = $closure;
    }

    /**
     * Handle an incoming request.
     *
     * @param Request $request
     * @param Closure $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next): mixed
    {

        foreach (self::$middlewareDependencyClosures as $closure) {
            app()->call($closure);
        }

        return $next($request);
    }
}