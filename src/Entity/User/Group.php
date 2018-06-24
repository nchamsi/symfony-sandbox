<?php
namespace App\Entity\User;

use Doctrine\ORM\Mapping as ORM;
use Sonata\UserBundle\Entity\BaseGroup as BaseGroup;

/**
 * Class Group
 * @package App\Entity\Security
 *
 * @ORM\Table(name="users_groups")
 * @ORM\Entity()
 */
class Group extends BaseGroup
{
    /**
     * @var guid
     *
     * @ORM\Id
     * @ORM\Column(type="guid")
     * @ORM\GeneratedValue(strategy="UUID")
     */
    protected $id;

    /**
     * @return guid
     */
    public function getId()
    {
        return $this->id;
    }

}
