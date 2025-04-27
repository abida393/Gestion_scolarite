<?php

namespace App\Providers;

use Illuminate\Auth\Passwords\DatabaseTokenRepository;
use Illuminate\Support\ServiceProvider;
use Illuminate\Auth\Passwords\PasswordBrokerManager;

class CustomAuthServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->app->singleton('auth.password', function ($app) {
            return new class($app) extends PasswordBrokerManager {
                protected function createTokenRepository(array $config)
                {
                    return new class(
                        $this->app['db'],
                        $this->app['hash'],
                        $config['table'],
                        $config['expire'],
                        $config['throttle'] ?? 0
                    )
                    extends DatabaseTokenRepository {
                        protected function getPayload($email, $token)
                        {
                            return [
                                'email' => $email, // Ensure email is never null
                                'token' => $this->hasher->make($token),
                                'created_at' => now()
                            ];
                        }
                    };
                }
            };
        });
    }
}
