<?php
declare(strict_types=1);

namespace Tests\App\Functional\Repositories\ORM;

use App\Database\Entities\User;
use App\Database\Entities\UserAccount;
use App\Repositories\Interfaces\AccountRepositoryInterface;
use Exception;
use Tests\App\TestCases\AbstractDatabaseTestCase;

/**
 * @covers \App\Database\Entities\UserAccount
 */
final class AccountRepositoryTest extends AbstractDatabaseTestCase
{
    /**
     * Test Success on Account Subscription.
     *
     * @return void
     *
     * @throws Exception
     */
    public function testTypeOfSubscriptionSuccessMethod(): void
    {
        $repository = $this->app->get(AccountRepositoryInterface::class);

        $userAccount = new UserAccount([
            "accountNumber" => "099-99",
            "subscriptionType" => UserAccount::SUBSCRIPTION_TYPE_MONTHLY,
            "user" => new User([
                "active" => true,
                "email" => "sample@info.com",
                "lastName" => "Angelo",
                "firstName" => "Michael"
            ])
        ]);

        $this->getEntityManager()->persist( $userAccount );
        $this->getEntityManager()->flush();

        $accounts = $repository->findBySubscriptionType( 'monthly' );

        self::assertContains($userAccount, $accounts);
    }

    /**
     * Test Failure on Account Subscription.
     *
     * @return void
     *
     * @throws Exception
     */
    public function testTypeOfSubscriptionFailMethod(): void
    {
        $repository = $this->app->get(AccountRepositoryInterface::class);
        $result = $repository->findBySubscriptionType('monthly');

        self::assertIsArray( $result );
    }

    /**
     * Test setUser function.
     *
     * @return void
     *
     * @throws Exception
     */
    public function testSetUser(): void
    {
        $userAccount = new UserAccount([
            "accountNumber" => "099-99",
            "subscriptionType" => UserAccount::SUBSCRIPTION_TYPE_MONTHLY,
        ]);

        $user = new User([
            "active" => true,
            "email" => "sample@info.com",
            "lastName" => "Angelo",
            "firstName" => "Michael"
        ]);

        $this->getEntityManager()->persist( $user );
        $this->getEntityManager()->flush();

        $userAccount->setUser( $user );

        $this->getEntityManager()->persist( $userAccount );
        $this->getEntityManager()->flush();

        self::assertNotEmpty( $userAccount->getUser() );
    }

}