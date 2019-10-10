<?php
declare(strict_types=1);

namespace Tests\App\Functional\Repositories\ORM;

use App\Database\Entities\Account;
use App\Repositories\Doctrine\ORM\AccountRepository;
use App\Repositories\Interfaces\AccountRepositoryInterface;
use Tests\App\Tools\TestCases\AbstractDatabaseTestCase;

/**
 * @covers \App\Repositories\Doctrine\ORM\AccountRepository
 */
final class AccountRepositoryTest extends AbstractDatabaseTestCase
{
    /**
     * Test Entity Class
     *
     * @return void
     *
     * @throws \ReflectionException
     */
    public function testEntityClass(): void
    {
        $repository = $this->app->get(AccountRepositoryInterface::class);
        $method = $this->getMethodAsPublic(AccountRepository::class, 'getEntityClass');
        
        self::assertEquals(Account::class, $method->invoke($repository));
    }
    
    /**
     * Test find by subscription type
     *
     * @return void
     *
     * @throws \Exception
     */
    public function testFindBySubscriptionType(): void
    {
        $account = new Account([
            'accountNumber' => \strval($this->getFaker()->randomNumber(7)),
            'subscriptionType' => 'monthly'
        ]);
        
        $this->getEntityManager()->persist($account);
        $this->getEntityManager()->flush();
    
        $repository = $this->app->get(AccountRepositoryInterface::class);
        
        $result = $repository->findBySubscriptionType('monthly');
        
        self::assertCount(1, $result);
        self::assertContains($account, $result);
    }
}
