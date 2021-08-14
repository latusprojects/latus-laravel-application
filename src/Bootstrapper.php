<?php

namespace Latus\Laravel;

use Latus\Laravel\Exceptions\Handler;
use Latus\Laravel\Http\Kernel as HttpKernel;
use Latus\Laravel\Console\Kernel as ConsoleKernel;


class Bootstrapper
{

    protected Application|null $app = null;
    protected array $baseProviders = [];
    protected string $basePath = '';

    public function __construct(string $basePath)
    {
        $this->basePath = $basePath;
    }

    public function addBaseProviders(array|string $baseProviders)
    {
        if (is_array($baseProviders)) {
            $this->baseProviders += $baseProviders;
            return;
        }

        $this->baseProviders[] = $baseProviders;

    }

    public function build()
    {
        $this->app = new Application($this->basePath, $this->baseProviders);
        $this->createBaseBindings();
    }

    protected function createBaseBindings()
    {
        $this->app->singleton(
            \Illuminate\Contracts\Http\Kernel::class,
            HttpKernel::class
        );

        $this->app->singleton(
            \Illuminate\Contracts\Console\Kernel::class,
            ConsoleKernel::class
        );

        $this->app->singleton(
            \Illuminate\Contracts\Debug\ExceptionHandler::class,
            Handler::class
        );
    }

    public function finish()
    {
        $this->app->boot();
    }

    public function getApp(): Application|null
    {
        return $this->app;
    }
}