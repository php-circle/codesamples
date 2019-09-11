<?php
declare(strict_types=1);

namespace App\External\Libraries\Doctrine\Extensions;

use Doctrine\Common\Persistence\ObjectManager;
use Doctrine\ORM\Mapping\Column;
use EoneoPay\Externals\ORM\Interfaces\EntityInterface;
use EoneoPay\Utils\AnnotationReader;
use Gedmo\Loggable\LoggableListener as BaseLoggableListener;

class LoggableEventSubscriber extends BaseLoggableListener
{
    /**
     * Closure to resolve username.
     *
     * @var callable
     */
    private $usernameResolver;

    /**
     * LoggableEventSubscriber constructor.
     *
     * @param callable $usernameResolver
     */
    public function __construct(callable $usernameResolver)
    {
        $this->usernameResolver = $usernameResolver;

        parent::__construct();
    }

    /**
     * Get configuration for given object manager and class.
     *
     * @param \Doctrine\Common\Persistence\ObjectManager $objectManager
     * @param string $class
     *
     * @return mixed[]
     *
     * @throws \EoneoPay\Utils\Exceptions\AnnotationCacheException
     *
     * @phpcsSuppress EoneoPay.Commenting.FunctionComment.ScalarTypeHintMissing
     * @phpcsSuppress SlevomatCodingStandard.TypeHints.TypeHintDeclaration.MissingParameterTypeHint
     */
    public function getConfiguration(ObjectManager $objectManager, $class): array
    {
        $config = parent::getConfiguration($objectManager, $class);
        $entity = new $class();

        if (($entity instanceof EntityInterface) === false || empty($this->getEntityFillable($entity))) {
            return $config;
        }

        $config['loggable'] = true;
        $config['versioned'] = $this->getEntityFillable($entity);

        return $config;
    }

    /**
     * Handle any custom LogEntry functionality that needs to be performed
     * before persisting it.
     *
     * @param mixed $logEntry The LogEntry being persisted
     * @param mixed $object The object being Logged
     *
     * @return void
     *
     * @SuppressWarnings(PHPMD.UnusedFormalParameter) Method needs to be compatible with parent
     */
    protected function prePersistLogEntry($logEntry, $object): void
    {
        $logEntry->setUsername(\call_user_func($this->usernameResolver) ?? 'not_set');
    }

    /**
     * Get fillable properties for given entity.
     *
     * @param \EoneoPay\Externals\ORM\Interfaces\EntityInterface $entity
     *
     * @return string[]
     *
     * @throws \EoneoPay\Utils\Exceptions\AnnotationCacheException
     */
    private function getEntityFillable(EntityInterface $entity): array
    {
        if (\in_array('*', $entity->getFillableProperties(), true) === false) {
            return $entity->getFillableProperties();
        }

        return \array_keys((new AnnotationReader())->getClassPropertyAnnotation(\get_class($entity), Column::class));
    }
}
