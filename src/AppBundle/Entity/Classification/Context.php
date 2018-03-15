<?php

namespace AppBundle\Entity\Classification;

use Doctrine\ORM\Mapping as ORM;
use Sonata\ClassificationBundle\Entity\BaseContext as BaseContext;

/**
 * Class Context
 * @package AppBundle\Entity\Classification
 *
 * @ORM\Table(name="sonata_classification__context")
 * @ORM\Entity()
 */
class Context extends BaseContext
{

    /**
     * @var string
     *
     * @ORM\Id
     * @ORM\Column(type="string")
     */
    protected $id;

    /**
     * @return string
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
