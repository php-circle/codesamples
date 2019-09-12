<?php
declare(strict_types=1);

namespace Tests\App\Functional\Repositories\ORM;

use App\Repositories\Doctrine\AccountRepository;
use App\Repositories\Interfaces\AccountRepositoryInterface;
use Tests\App\Tools\TestCases\AbstractDatabaseTestCase;

/**
 * @covers \App\Repositories\Doctrine\AccountRepository
 */
final class AccountRepositoryTest extends AbstractDatabaseTestCase
{
    /**
     * Test findBySubscriptionType method which is passed by a paramater value not equal to lifetime and monthly that throws an error.
     *
     * @return void
     */
    public function testFindBySubscriptionTypeNotLifetime(): void
    {
        $repository = $this->app->get(AccountRepositoryInterface::class);
        $method = $this->getMethodAsPublic(AccountRepository::class, 'findBySubscriptionType');
        self::assertEquals($method->invoke($repository, 'annually'), ['error' => 1100]);
    }
}
