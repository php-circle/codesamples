<?php
declare(strict_types=1);

namespace Tests\App\Functional\Repositories\ORM;

use App\Database\Entities\UserAccount;
use App\Repositories\Doctrine\AccountRepository;
use App\Repositories\Interfaces\AccountRepositoryInterface;
use Tests\App\TestCases\AbstractDatabaseTestCase;

final class AccountRepositoryTest extends AbstractDatabaseTestCase
{
    /**
     * Test entity class.
     *
     * @return void
     *
     * @throws \ReflectionException
     */
    public function testTypeOfSubscriptionMethod(): void
    {
        $repository = $this->app->get(AccountRepositoryInterface::class);

        $method = $this->getMethodAsPublic(AccountRepository::class, 'findBySubscriptionType');

        self::assertEquals(UserAccount::class, $method->invoke($repository));
    }
}
