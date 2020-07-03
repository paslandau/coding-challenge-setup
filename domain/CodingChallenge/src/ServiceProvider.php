<?php

namespace CodingChallenge;

use CodingChallenge\Commands\VerifyCommand;
use Illuminate\Support\ServiceProvider as BaseServiceProvider;

class ServiceProvider extends BaseServiceProvider
{
    public function boot(): void
    {
        if ($this->app->runningInConsole()) {
            $this->commands([
                VerifyCommand::class,
            ]);
        }
    }
}
