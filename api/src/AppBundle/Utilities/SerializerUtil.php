<?php

namespace AppBundle\Utilities;

use Symfony\Component\Serializer\Mapping\Factory\ClassMetadataFactory;
use Doctrine\Common\Annotations\AnnotationReader;
use Symfony\Component\Serializer\Mapping\Loader\AnnotationLoader;
use Symfony\Component\Serializer\Serializer;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;

/**
 * Class SerializerUtil
 */
class SerializerUtil
{
    public function __construct()
    {
        $this->_factory = new ClassMetadataFactory(new AnnotationLoader(new AnnotationReader()));
        $this->_normalizer = new ObjectNormalizer($this->_factory);
        $this->_serializer = new Serializer(array($this->_normalizer));
    }

    /**
     * Serializes object.
     *
     * @param $object
     * @param string $group
     *
     * @return \Symfony\Component\Serializer\Normalizer\scalar
     */
    public function serialize($object, string $group = 'default')
    {
        return $this->_serializer->normalize($object, null, array('groups' => array($group)));
    }
}