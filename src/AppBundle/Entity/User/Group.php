<?php
namespace AppBundle\Entity\User;

use Doctrine\ORM\Mapping as ORM;
use Sonata\UserBundle\Entity\BaseGroup as BaseGroup;

/**
 * Class Group
 * @package AppBundle\Entity\User
 *
 * @ORM\Table(name="security__group")
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
