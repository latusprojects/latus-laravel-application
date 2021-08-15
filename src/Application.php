<?php

namespace Latus\Laravel;

use Illuminate\Foundation\Application as LaravelApplication;

class Application extends LaravelApplication
{

    protected array $additionalBaseProviders = [];
    protected string|null $publicPath = null;

    public function __construct($basePath = null, array $additionalBaseProviders = [])
    {

        $this->additionalBaseProviders = $additionalBaseProviders;
        
        parent::__construct($basePath);

    }

    protected function registerBaseServiceProviders()
    {
        parent::registerBaseServiceProviders();

        if (!empty($this->additionalBaseProviders)) {
            foreach ($this->additionalBaseProviders as $baseProvider) {
                $this->register($baseProvider);
            }
        }
    }

    public function usePublicPath(string|null $path)
    {
        $this->publicPath = $path;
    }

    public function publicPath(): string
    {
        return $this->publicPath ?? parent::publicPath();
    }
}