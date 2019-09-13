<?php
declare(strict_types=1);

namespace App\External\Libraries;

use App\Database\Entities\Users\ApiKey;
use App\External\Interfaces\AuthInterface;
use Illuminate\Contracts\Auth\Factory as AuthFactory;

class Auth implements AuthInterface
{
    /**
     * @var null|\App\Database\Entities\Users\ApiKey
     */
    private $apiKey;

    /**
     * @var \Illuminate\Contracts\Auth\Factory
     */
    private $auth;

    /**
     * Create new authentication instance
     *
     * @param \Illuminate\Contracts\Auth\Factory $auth
     */
    public function __construct(AuthFactory $auth)
    {
        $this->auth = $auth;
    }

    /**
     * Handle all other functions of Auth.
     *
     * @param string $name
     * @param mixed[] $arguments
     *
     * @return mixed
     */
    public function __call(string $name, array $arguments)
    {
        return $this->auth->$name(...$arguments);
    }

    /**
     * Set current API key.
     *
     * @param \App\Database\Entities\Users\ApiKey|null $apiKey
     *
     * @return \App\External\Libraries\Auth
     */
    public function setApiKey(?ApiKey $apiKey = null): self
    {
        $this->apiKey = $apiKey;

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function user(): ?ApiKey
    {
        if ($this->apiKey !== null) {
            return $this->apiKey;
        }

        /** @noinspection PhpUndefinedMethodInspection Method exists on actual auth driver but lumen works this way */
        return $this->auth->user();
    }
}
