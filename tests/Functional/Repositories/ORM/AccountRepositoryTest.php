<?php
declare(strict_types=1);

namespace Tests\App\Functional\Repositories\ORM;

use App\Repositories\Doctrine\AccountRepository;
use App\Repositories\Interfaces\AccountRepositoryInterface;
use App\Database\Exceptions\InvalidTypeSubscriptionException;
use Tests\App\Tools\TestCases\AbstractDatabaseTestCase;

/**
 * @covers \App\Repositories\Doctrine\AccountRepository
 */
final class AccountRepositoryTest extends AbstractDatabaseTestCase
{
    /**
     * Test findBySubscriptionType method which is passed by a paramater value not equal to lifetime and monthly.
     *
     * @return void
     */
    public function testFindBySubscriptionTypeNotLifetime(): void
    {
        $this->expectException(InvalidTypeSubscriptionException::class);
        $repository = $this->app->get(AccountRepositoryInterface::class);
        $repository->findBySubscriptionType('quarterly');
    }
}
