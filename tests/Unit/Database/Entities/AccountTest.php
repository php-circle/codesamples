<?php
declare(strict_types=1);

namespace Tests\App\Unit\Database\Entities;

use App\Database\Entities\Account;
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
            'subscriptionType' => 'required|in:monthly,lifetime'
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
            'subscription_type'
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
}
