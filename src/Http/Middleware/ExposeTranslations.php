<?php

namespace Latus\Laravel\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\File;
use Illuminate\Translation\TranslationServiceProvider;

class ExposeTranslations
{
    /**
     * Handle an incoming request.
     *
     * @param Request $request
     * @param Closure $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next): mixed
    {

        $translations = $this->collectTranslations();

        foreach ($translations as $namespace => $localeGroups) {
            foreach ($localeGroups as $locale => $files) {
                foreach ($files as $fileName => $fileContents) {
                    $this->putFile(namespace: $namespace, locale: $locale, file: $fileName, contents: json_encode($fileContents));
                }
            }
        }

        return $next($request);
    }

    protected function putFile(string $namespace, string $locale, string $file, string $contents)
    {
        $fileDir = public_path('assets/translations/' . $namespace . '/' . $locale . '/');

        File::ensureDirectoryExists($fileDir);

        File::put($fileDir . $file . '.json', $contents);
    }

    protected function collectTranslations(): Collection
    {
        $translations = new Collection();

        foreach (app('translator')->getLoader()->namespaces() as $namespace => $path) {
            $translations->put($namespace, $this->getTranslations(path: $path));
        }

        return $translations;
    }

    protected function getTranslations(string $path): Collection
    {
        $translations = new Collection();

        foreach (File::directories($path) as $localeDir) {
            $locale = basename($localeDir);
            $translations->put($locale, collect());
            foreach (glob($localeDir . '/*.php') as $file) {
                $translations->get($locale)->put(basename($file, '.php'), require $file);
            }
        }

        return $translations;
    }
}