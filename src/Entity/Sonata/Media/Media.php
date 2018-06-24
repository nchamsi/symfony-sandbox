<?php

namespace App\Entity\Sonata\Media;

use Doctrine\ORM\Mapping as ORM;
use Sonata\MediaBundle\Entity\BaseMedia as BaseMedia;

/**
 * Class Media
 * @package App\Entity\Sonata\Media
 *
 * @ORM\Table(name="sonata_media__media")
 * @ORM\Entity()
 */
class Media extends BaseMedia
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
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
