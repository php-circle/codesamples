<?php
declare(strict_types=1);

namespace App\External\Interfaces;

use App\Database\Entities\Users\ApiKey;

interface AuthInterface
{
    /**
     * Get current user.
     *
     * @return \App\Database\Entities\Users\ApiKey|null
     */
    public function user(): ?ApiKey;
}
