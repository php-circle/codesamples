<?php
declare(strict_types=1);

namespace App\Database\Entities;

use App\Database\Schema\UserSchema;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @method \Doctrine\Common\Collections\Collection getAccounts()
 *
 * @ORM\Entity()
 */
class User extends AbstractEntity
{
    use UserSchema;

    /**
     * @ORM\OneToMany(
     *     targetEntity="\App\Database\Entities\UserAccount",
     *     mappedBy="user",
     *     cascade={"persist"}
     * )
     *
     * @var \Doctrine\Common\Collections\Collection
     */
    protected $accounts;

    /**
     * User constructor.
     *
     * @param null|mixed $data
     *
     * @throws \Exception
     */
    public function __construct(?array $data = null)
    {
        $this->accounts = new ArrayCollection();

        parent::__construct($data);
    }

    /**
     * Get array representation of children.
     *
     * @return mixed[]
     */
    protected function doToArray(): array
    {
        return [
            'active' => $this->isActive(),
            'email' => $this->getEmail(),
            'id' => $this->getUserId(),
            'first_name' => $this->getFirstName(),
            'last_name' => $this->getLastName()
        ];
    }

    /**
     * Get entity specific validation rules as an array.
     *
     * @return mixed[]
     */
    protected function doGetRules(): array
    {
        return [
            'active' => 'boolean',
            'email' => 'required|email',
            'firstName' => 'required|string',
            'lastName' => 'required|string'
        ];
    }

    /**
     * Get the id property for this entity
     *
     * @return string
     */
    protected function getIdProperty(): string
    {
        return 'userId';
    }
}
