<?php

namespace AppBundle\Entity\User;

use Doctrine\ORM\Mapping as ORM;
use Sonata\UserBundle\Entity\BaseUser as BaseUser;

/**
 * Class User
 * @package AppBundle\Entity\User
 *
 * @ORM\Table(name="security__user")
 * @ORM\Entity()
 */
class User extends BaseUser
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
     * @var \Sonata\MediaBundle\Entity\BaseMedia
     *
     * @ORM\OneToOne(targetEntity="\Sonata\MediaBundle\Entity\BaseMedia", cascade={"all"})
     * @ORM\JoinColumn(name="photo_id", referencedColumnName="id", nullable=true)
     */
    protected $media;

    /**
     * @return guid
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return \Sonata\MediaBundle\Entity\BaseMedia
     */
    public function getMedia()
    {
        return $this->media;
    }

    /**
     * @param \Sonata\MediaBundle\Entity\BaseMedia $media
     * @return User
     */
    public function setMedia($media)
    {
        $this->media = $media;
        return $this;
    }


}
