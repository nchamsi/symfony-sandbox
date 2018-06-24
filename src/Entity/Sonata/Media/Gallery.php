<?php
namespace App\Entity\Sonata\Media;

use Doctrine\ORM\Mapping as ORM;
use Sonata\MediaBundle\Entity\BaseGallery as BaseGallery;

/**
 * Class Gallery
 * @package App\Entity\Sonata\Media
 *
 * @ORM\Table(name="sonata_media__gallery")
 * @ORM\Entity()
 */
class Gallery extends BaseGallery
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
