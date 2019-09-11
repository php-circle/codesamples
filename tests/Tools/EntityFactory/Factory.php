<?php
declare(strict_types=1);

namespace App\Tests\Tools\EntityFactory;

use LaravelDoctrine\ORM\Testing\Factory as LaravelDoctrineFactory;
use LaravelDoctrine\ORM\Testing\FactoryBuilder as DortrineFactoryBuilder;

final class Factory extends LaravelDoctrineFactory
{
    /**
     * Override the doctrine factory of to use the custom factory builder.
     *
     * @param mixed $class
     * @param mixed $name
     *
     * @return \LaravelDoctrine\ORM\Testing\FactoryBuilder
     */
    public function of($class, $name = 'default'): DortrineFactoryBuilder
    {
        return FactoryBuilder::construct(
            $this->registry,
            $class,
            $name,
            $this->definitions,
            $this->faker,
            $this->getStateFor($class)
        );
    }
}
