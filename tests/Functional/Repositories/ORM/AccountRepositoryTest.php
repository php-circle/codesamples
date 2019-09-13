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
     * Find by subscription type with correct subscription type
     *
     * @return void
     *
     * @throws \ReflectionException
     */
    public function testFindBySubscriptionCorrectType(): void
    {
        $repository = $this->app->get(AccountRepositoryInterface::class);

        self::assertEquals($repository->findBySubscriptionType('monthly'), ['error' => 1100]);
    }

    /**
     * Find by subscription type with wrong subscription type
     *
     * @return void
     *
     * @throws \ReflectionException
     */
    public function testFindBySubscriptionWrongType(): void
    {
        $repository = $this->app->get(AccountRepositoryInterface::class);

        self::assertEquals($repository->findBySubscriptionType( 'daily'), ['error'=> 1000]);
    }
}
