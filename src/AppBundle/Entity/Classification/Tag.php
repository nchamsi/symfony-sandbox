<?php
namespace AppBundle\Entity\Classification;

use Doctrine\ORM\Mapping as ORM;
use Sonata\ClassificationBundle\Entity\BaseTag as BaseTag;

/**
 * Class Tag
 * @package AppBundle\Entity\Classification
 *
 * @ORM\Table(name="sonata_classification__tag")
 * @ORM\Entity()
 */
class Tag extends BaseTag {

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

    public function __toString()
    {
        return $this->getName();
    }
}
