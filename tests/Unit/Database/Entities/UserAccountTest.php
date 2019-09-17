<?php
declare(strict_types=1);

namespace Tests\App\Unit\Database\Entities;

use App\Database\Entities\User;
use App\Database\Entities\UserAccount;
use Tests\App\TestCases\DoctrineAnnotationsTestCase;

/**
 * @covers \App\Database\Entities\UserAccount
 */
final class UserAccountTest extends DoctrineAnnotationsTestCase
{

    /** string */
    public const SUBSCRIPTION_TYPE_LIFETIME = 'lifetime';
    public const SUBSCRIPTION_TYPE_MONTHLY = 'monthly';

    /** string[] */
    public const SUBSCRIPTION_TYPES = [
        self::SUBSCRIPTION_TYPE_LIFETIME,
        self::SUBSCRIPTION_TYPE_MONTHLY
    ];

    /**
     * Test assert id property.
     *
     * @return void
     *
     * @throws \ReflectionException
     */
    public function testAssertIdProperty(): void
    {
        $this->assertIdProperty(UserAccount::class, 'userAcctId');
    }

    /**
     * Test entity do get rules.
     *
     * @return void
     *
     * @throws \Exception
     */
    public function testDoGetRules(): void
    {

        $this->assertDoGetRules(UserAccount::class, [
            'accountNumber' => 'required|string',
            'subscriptionType' => 'required|in:' . \implode( ',', self::SUBSCRIPTION_TYPES ),
            'user' => 'required|instance_of:App\Database\Entities\User'
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
        $this->assertDoToArray(UserAccount::class, [
            'account_number',
            'id',
            'subscription_type',
            'user'
        ]);
    }

}
