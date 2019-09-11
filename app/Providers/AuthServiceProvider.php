<?php
declare(strict_types=1);

namespace App\Providers;

use App\Database\Entities\Users\ApiKey;
use App\External\Interfaces\AuthInterface;
use App\External\Libraries\Auth;
use App\Services\Security\Interfaces\PermissionsCheckerInterface;
use App\Services\Security\PermissionsChecker;
use EoneoPay\Externals\ORM\Interfaces\EntityManagerInterface;
use Illuminate\Contracts\Auth\Factory as AuthFactory;
use Illuminate\Http\Request;
use Illuminate\Support\ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The application instance.
     *
     * @var \Laravel\Lumen\Application
     */
    protected $app;

    /**
     * Boot the authentication services for the application.
     *
     * @return void
     */
    public function boot(): void
    {
        $this->app->make('auth')->viaRequest('api', function (Request $request) {
            $apiKeyInRequest = $request->getUser();
            if ($apiKeyInRequest === null) {
                return null;
            }

            return $this->app
                ->make(EntityManagerInterface::class)
//                ->getRepository(ApiKey::class)
                ->findOneBy(['key' => $apiKeyInRequest]);
        });
    }

    /**
     * Decorate auth service.
     *
     * @return void
     *
     * @throws \InvalidArgumentException
     */
    public function register(): void
    {
        $this->app->extend(AuthFactory::class, function ($auth) {
            if ($auth instanceof AuthInterface) {
                return $auth;
            }

            return new Auth($auth);
        });

        $this->app->alias('auth', AuthInterface::class);
    }
}
