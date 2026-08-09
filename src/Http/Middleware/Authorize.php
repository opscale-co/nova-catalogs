<?php

declare(strict_types=1);

namespace Opscale\NovaCatalogs\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Laravel\Nova\Nova;
use Laravel\Nova\Tool as NovaTool;
use Opscale\NovaCatalogs\Package;
use Symfony\Component\HttpFoundation\Response;

class Authorize
{
    final public function handle(Request $request, Closure $next): Response
    {
        $package = $this->resolvePackage();

        if (! $package instanceof Package || ! $package->authorize($request)) {
            abort(403);
        }

        return $next($request);
    }

    final public function matchesPackage(NovaTool $novaTool): bool
    {
        return $novaTool instanceof Package;
    }

    private function resolvePackage(): ?Package
    {
        foreach (Nova::registeredTools() as $tool) {
            if ($this->matchesPackage($tool)) {
                /** @var Package $tool */
                return $tool;
            }
        }

        return null;
    }
}
