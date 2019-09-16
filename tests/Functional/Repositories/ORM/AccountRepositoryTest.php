<?php
declare(strict_types=1);

namespace Tests\App\Functional\Repositories\ORM;

use App\Database\Entities\Account;
use App\Database\Entities\User;
use App\Database\Exceptions\InvalidSubscriptionTypeException;
use App\Repositories\Interfaces\AccountRepositoryInterface;
use Tests\App\Tools\TestCases\AbstractDatabaseTestCase;

/**
 * @covers \App\Repositories\Doctrine\AccountRepository
 */
final class AccountRepositoryTest extends AbstractDatabaseTestCase
{
    /**
     * Find by subscription type with correct subscription type.
     *
     * @return void
     *
     * @throws \Exception
     */
    public function testFindBySubscriptionCorrectType(): void
    {
        $repository = $this->app->get(AccountRepositoryInterface::class);

        $account = new Account([
            'subscriptionType' => Account::SUBSCRIPTION_TYPE_MONTHLY,
            'user' => new User([
                'email' => 'johndoe@gmail.com',
                'firstName' => 'John',
                'lastName' => 'Doe'
            ]),
            'accountNumber' => '0923-232'
        ]);
        $this->getEntityManager()->persist($account);
        $this->getEntityManager()->flush();

        $accounts = $repository->findBySubscriptionType('monthly');
        self::assertContains($account, $accounts);
    }

    /**
     * Find by subscription type with wrong subscription type.
     *
     * @return void
     */
    public function testFindBySubscriptionWrongType(): void
    {
        $this->expectException(InvalidSubscriptionTypeException::class);

        $repository = $this->app->get(AccountRepositoryInterface::class);

        $repository->findBySubscriptionType('daily');
    }
}
