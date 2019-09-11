<?php
declare(strict_types=1);

namespace App\External\Libraries\Doctrine\Extensions;

use App\External\Interfaces\AuthInterface;
use Doctrine\Common\Annotations\Reader;
use Doctrine\Common\EventManager;
use Doctrine\ORM\EntityManagerInterface;
use EoneoPay\Externals\Environment\Interfaces\EnvInterface;
use LaravelDoctrine\Extensions\GedmoExtension;

class LoggableExtension extends GedmoExtension
{
    /**
     * @var \App\External\Interfaces\AuthInterface
     */
    private $auth;

    /**
     * @var \EoneoPay\Externals\Environment\Interfaces\EnvInterface
     */
    private $env;

    /**
     * LoggableExtension constructor.
     *
     * @param \App\External\Interfaces\AuthInterface $auth
     * @param \EoneoPay\Externals\Environment\Interfaces\EnvInterface $env
     */
    public function __construct(AuthInterface $auth, EnvInterface $env)
    {
        $this->auth = $auth;
        $this->env = $env;
    }

    /**
     * Add LoggableEventSubscriber in Doctrine events system.
     *
     * @param \Doctrine\Common\EventManager $manager
     * @param \Doctrine\ORM\EntityManagerInterface $entityManager
     * @param \Doctrine\Common\Annotations\Reader|null $reader
     *
     * @return void
     *
     * @SuppressWarnings(PHPMD.UnusedFormalParameter) Inherited from LaravelDoctrine Extensions
     */
    public function addSubscribers(
        EventManager $manager,
        EntityManagerInterface $entityManager,
        ?Reader $reader = null
    ): void {
        $this->addSubscriber(new LoggableEventSubscriber($this->getUsernameResolver()), $manager, $reader);
    }

    /**
     * Get filters provided by the extensions.
     *
     * @return mixed[]
     */
    public function getFilters(): array
    {
        return [];
    }

    /**
     * Get username resolver closure.
     *
     * @return \Closure
     */
    private function getUsernameResolver(): \Closure
    {
        return function (): ?string {
            // Handle command context
            if ($this->env->get('APP_CONSOLE', false)) {
                return 'console';
            }

            // Avoid troubleshooting during unit tests
            if ($this->env->get('APP_ENV') === 'testing') {
                return 'testing';
            }

            if ($this->auth->user() === null) {
                return null;
            }

            return $this->auth->user()->getApiKeyId();
        };
    }
}
