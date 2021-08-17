<?php

namespace Latus\Laravel\Http\Middleware;


use Latus\UI\Events\AdminNavDefined;

class BuildPackageDependencies
{

    public function handle()
    {
        if (app()->bound('admin-nav')) {
            $this->dispatchAdminNavDefinedEvent();
        }
    }

    protected function dispatchAdminNavDefinedEvent()
    {
        AdminNavDefined::dispatch(app('admin-nav'));
    }
}