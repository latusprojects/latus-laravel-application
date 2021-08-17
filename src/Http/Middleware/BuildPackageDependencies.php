<?php

namespace Latus\Laravel\Http\Middleware;


use Latus\UI\Events\AdminNavDefined;

class BuildPackageDependencies
{

    protected static array $middlewareDependencyClosures = [];

    public static function addDependencyClosure(\Closure $closure)
    {
        self::$middlewareDependencyClosures[] = $closure;
    }

    public function handle()
    {

        foreach (self::$middlewareDependencyClosures as $closure) {
            $closure();
        }

        if (app()->bound('admin-nav')) {
            $this->dispatchAdminNavDefinedEvent();
        }
    }

    protected function dispatchAdminNavDefinedEvent()
    {
        AdminNavDefined::dispatch(app('admin-nav'));
    }
}