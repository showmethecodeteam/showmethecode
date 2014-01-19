<?php

namespace SMTC\MainBundle\Form\DataTransformer;

use Symfony\Component\Form\DataTransformerInterface;
use Symfony\Component\Form\Exception\TransformationFailedException;
use Doctrine\Common\Persistence\ObjectManager;

class EntityToIdTransformer implements DataTransformerInterface
{
    /**
     * @var ObjectManager
     */
    private $om;
    private $entityClass;

    /**
     * @param ObjectManager $om
     */
    public function __construct(ObjectManager $om, $entityClass)
    {
        $this->om = $om;
        $this->entityClass = $entityClass;
    }

    /**
     * Transforms an object to an id.
     *
     * @param  Object|null $entity
     * @return string
     */
    public function transform($entity)
    {
        if (null === $entity) {
            return "";
        }

        return $entity->getId();
    }

    /**
     * Transforms an id to an object.
     *
     * @param  string                        $id
     * @return Object|null
     * @throws TransformationFailedException if object is not found.
     */
    public function reverseTransform($id)
    {
        $entity = $this->om->getRepository($this->entityClass)->find($id);

        if (null === $entity) {
            throw new TransformationFailedException(sprintf('There is no entity of %s with id %s', $this->entityClass, $id
            ));
        }

        return $entity;
    }
}
