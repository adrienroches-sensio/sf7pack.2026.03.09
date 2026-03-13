<?php

declare(strict_types=1);

namespace App\Serializer\Normalizer;

use App\Entity\Organization;
use Symfony\Component\DependencyInjection\Attribute\Autowire;
use Symfony\Component\Serializer\Normalizer\NormalizerInterface;
use function in_array;

class OrganizationNormalizer implements NormalizerInterface
{
    public function __construct(
        #[Autowire(service: 'serializer.normalizer.object')]
        private readonly NormalizerInterface $normalizer,
    ) {
    }

    /**
     * @param Organization $data
     */
    public function normalize(mixed $data, ?string $format = null, array $context = []): array|string|int|float|bool|\ArrayObject|null
    {
        if (in_array('conference:list', $context['groups'], true)) {
            return $data->getName();
        }

        return $this->normalizer->normalize($data, $format, $context);
    }

    public function supportsNormalization(mixed $data, ?string $format = null, array $context = []): bool
    {
        return $data instanceof Organization;
    }

    public function getSupportedTypes(?string $format): array
    {
        return [
            Organization::class => true,
        ];
    }
}
