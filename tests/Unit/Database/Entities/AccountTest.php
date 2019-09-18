<?php
declare(strict_types=1);

namespace Tests\App\Unit\Database\Entities;

use App\Database\Entities\Account;
use App\Database\Entities\User;
use Tests\App\Tools\TestCases\DoctrineAnnotationsTestCase;

/**
 * @covers \App\Database\Entities\Account
 */
final class AccountTest extends DoctrineAnnotationsTestCase
{
    /**
     * Test entity do get rules.
     *
     * @return void
     *
     * @throws \Exception
     */
    public function testDoGetRules(): void
    {
        $this->assertDoGetRules(Account::class, [
            'accountNumber' => 'required|string',
            'subscriptionType' => 'required|in:monthly,lifetime',
            'user' => 'required|instance_of:' . User::class
        ]);
    }

    /**
     * Test do to array.
     *
     * @return void
     *
     * @throws \ReflectionException
     */
    public function testDoToArray(): void
    {
        $this->assertDoToArray(Account::class, [
            'id',
            'account_number',
            'subscription_type',
            'user'
        ]);
    }

    /**
     * Test assert id property.
     *
     * @return void
     *
     * @throws \ReflectionException
     */
    public function testAssertIdProperty(): void
    {
        $this->assertIdProperty(Account::class, 'accountId');
    }

    /**
     * Test the rules validation format.
     *
     * @return void
     *
     * @throws \ReflectionException
     */
    public function testGetRules(): void
    {
        $entity = $this->app->get(Account::class);
        $doGetRules = $this->getMethodAsPublic(Account::class, 'doGetRules');
        $userRules = $doGetRules->invoke($entity, new Account());
        self::assertEquals(
            [
                'accountNumber' => 'required|string',
                'subscriptionType' => 'required|in:monthly,lifetime',
                'user' => 'required|instance_of:' . User::class
            ],
            $userRules
        );
    }
}
