<?php

namespace Latus\Laravel\Http\Middleware;


use Closure;
use Illuminate\Http\Request;
use Latus\UI\Events\AdminNavDefined;

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
            $closure();
        }

        if (app()->bound('admin-nav')) {
            $this->dispatchAdminNavDefinedEvent();
        }

        return $next($request);
    }

    protected function dispatchAdminNavDefinedEvent()
    {
        AdminNavDefined::dispatch(app('admin-nav'));
    }
}