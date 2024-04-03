<?php

namespace App\Controller;

use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Serializer\Normalizer\AbstractObjectNormalizer;
use Symfony\Component\Serializer\SerializerInterface;

class Serializer
{
    private SerializerInterface $serializer;

    public function __construct(SerializerInterface $serializer)
    {
        $this->serializer = $serializer;
    }

    public function serializeObject($object, $ignAttr): JsonResponse
    {
        $jsonData = $this->serializer->serialize($object, 'json', [
            AbstractObjectNormalizer::CIRCULAR_REFERENCE_HANDLER => function ($object) {
                return $object->getId();
            },
            AbstractObjectNormalizer::IGNORED_ATTRIBUTES => $ignAttr,
            AbstractObjectNormalizer::GROUPS => ['api'],
        ]);
        return new JsonResponse($jsonData, 200, [], true);
    }
}
