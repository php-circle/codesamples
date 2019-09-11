<?php
declare(strict_types=1);

namespace Tests\App\TestCases;

use App\Database\Entities\AbstractEntity;
use Doctrine\ORM\Tools\SchemaTool;
use EoneoPay\Externals\ORM\Interfaces\EntityManagerInterface;
use Tests\App\AbstractTestCase;

/**
 * @coversNothing
 *
 * @SuppressWarnings(PHPMD.CouplingBetweenObjects) Test case sets up database for testing
 * @SuppressWarnings(PHPMD.NumberOfChildren) Test case, all database tests extend this
 */
abstract class AbstractDatabaseTestCase extends AbstractTestCase
{
    /**
     * @var string
     */
    private static $sql;

    /**
     * @var string
     */
    private static $truncateSql;

    /**
     * @var \EoneoPay\Externals\ORM\Interfaces\EntityManagerInterface
     */
    private $entityManager;

    /**
     * Create database using doctrine command.
     *
     * @return void
     *
     * @throws \Doctrine\DBAL\DBALException
     */
    public function setUp(): void
    {
        parent::setUp();

//        $this->app->singleton(LaravelDoctrineFactory::class, function () {
//            return EntityFactory::construct(
//                $this->getFaker(),
//                $this->app->make('registry')
//            );
//        });

        // phpunit.xml sets env to `testing`
        if (\getenv('DB_CONNECTION') !== 'testing') {
            $this->getConsole()->call('doctrine:migrations:migrate');

            return;
        }

        /** @var \Doctrine\ORM\EntityManager $entityManager */
        $this->entityManager = $entityManager = $this->app->make('registry')->getManager();

        // If schema hasn't been defined, define it, this will happen once per run
        if (self::$sql === null) {
            $tool = new SchemaTool($entityManager);
            $metadata = $entityManager->getMetadataFactory()->getAllMetadata();
            self::$sql = \implode(';', $tool->getCreateSchemaSql($metadata));
        }

        // Create schema
        $entityManager->getConnection()->exec(self::$sql);

        // Define truncate query after schema created to have the tables
        if (self::$truncateSql === null) {
            $platform = $entityManager->getConnection()->getDatabasePlatform();
            $truncate = '';

            foreach ($entityManager->getConnection()->getSchemaManager()->listTables() as $table) {
                $truncate .= \sprintf('%s;', $platform->getTruncateTableSQL($table->getName()));
            }

            self::$truncateSql = $truncate;
        }
    }

    /**
     * Reset database using doctrine command and close the connection.
     *
     * @return void
     *
     * @throws \Doctrine\DBAL\DBALException
     */
    public function tearDown(): void
    {
        $this->entityManager->getConnection()->exec(self::$truncateSql);

        // phpunit.xml sets env to `testing`
        if (\getenv('DB_CONNECTION') !== 'testing') {
            $this->getConsole()->call('doctrine:migrations:reset');

            $this->entityManager->getConnection()->close();
        }

        parent::tearDown();
    }

    /**
     * Test validation failure on an entity
     *
     * @param string $entityClass The entity class to test
     * @param string $exceptionClass The expected exception class
     *
     * @return void
     */
    protected function assertValidationFailedException(string $entityClass, string $exceptionClass): void
    {
        $this->expectException($exceptionClass);
        $this->getEntityManager()->persist(new $entityClass());
    }

    /**
     * Get entity manager instance
     *
     * @return \EoneoPay\Externals\ORM\Interfaces\EntityManagerInterface
     */
    protected function getEntityManager(): EntityManagerInterface
    {
        if ($this->entityManager !== null) {
            return $this->entityManager;
        }

        return $this->entityManager = $this->app->make(EntityManagerInterface::class);
    }

    /**
     * Send Json request to uri with api key header.
     *
     * @param string $method
     * @param string $uri
     * @param string $key
     * @param mixed[]|null $data
     * @param string[]|null $headers
     *
     * @return void
     */
    protected function jsonWithApiKey(
        string $method,
        string $uri,
        string $key,
        ?array $data = null,
        ?array $headers = null
    ): void {
        $headers = \array_merge(
            ['Authorization' => \sprintf('Basic %s', \base64_encode($key . ':'))],
            $headers ?? []
        );

        $this->json($method, $uri, $data ?? [], $headers);
    }

    /**
     * Refresh the entity.
     *
     * @param \App\Database\Entities\AbstractEntity $entity
     *
     * @return void
     */
    protected function refreshEntity(AbstractEntity $entity): void
    {
        /** @var \Doctrine\Common\Persistence\ManagerRegistry $managerRegistry */
        $managerRegistry = $this->app->get('registry');

        $managerRegistry->getManager()->refresh($entity);
    }
}
