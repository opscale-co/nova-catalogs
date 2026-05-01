<?php

declare(strict_types=1);

namespace Opscale\NovaCatalogs\Tests;

use Laravel\Dusk\Browser;
use Orchestra\Testbench\Concerns\WithWorkbench;
use Orchestra\Testbench\Dusk\TestCase as BaseTestCase;
use Override;

abstract class DuskTestCase extends BaseTestCase
{
    use WithWorkbench;

    protected static $baseServePort = 8089;

    #[Override]
    protected static function defineChromeDriver(): void
    {
        parent::defineChromeDriver();

        $deadline = microtime(true) + 5.0;
        while (microtime(true) < $deadline) {
            $socket = @fsockopen('127.0.0.1', static::$chromeDriverPort, $errno, $errstr, 0.1);
            if ($socket !== false) {
                fclose($socket);

                return;
            }

            usleep(100_000);
        }
    }

    final protected function loginToNova(Browser $browser): Browser
    {
        $browser->visit('/nova');

        if ($browser->element('input[name="email"]')) {
            $browser->type('email', 'admin@laravel.com')
                ->type('password', 'password')
                ->press('Log In')
                ->waitForText('Get Started');
        }

        return $browser;
    }

    #[Override]
    protected function defineEnvironment($app): void
    {
        parent::defineEnvironment($app);

        $app['config']->set('app.key', 'base64:Hbq687KcHiIFuJzsmMZZZN6uOIk/O/0SQ4IHnFOpe6k=');
    }
}
