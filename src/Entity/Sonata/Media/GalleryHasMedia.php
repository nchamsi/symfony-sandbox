<?php
namespace App\Entity\Sonata\Media;

use Doctrine\ORM\Mapping as ORM;
use Sonata\MediaBundle\Entity\BaseGalleryHasMedia as BaseGalleryHasMedia;

/**
 * Class GalleryHasMedia
 * @package App\Entity\Sonata\Media
 *
 * @ORM\Table(name="sonata_media__gallery_has_media")
 * @ORM\Entity()
 */
class GalleryHasMedia extends BaseGalleryHasMedia
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
