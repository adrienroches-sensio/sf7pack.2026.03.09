<?php

declare(strict_types=1);

namespace App\Serializer\Normalizer;

use App\Entity\Conference;
use Symfony\Component\DependencyInjection\Attribute\Autowire;
use Symfony\Component\Serializer\Normalizer\NormalizerInterface;
use function array_column;

class ConferenceNormalizer implements NormalizerInterface
{
    public function __construct(
        #[Autowire(service: 'serializer.normalizer.object')]
        private readonly NormalizerInterface $normalizer,
    ) {
    }

    /**
     * @param Conference $data
     */
    public function normalize(mixed $data, ?string $format = null, array $context = []): array|string|int|float|bool|\ArrayObject|null
    {
        $normalized = $this->normalizer->normalize($data, $format, $context);

//        $normalized['organizations'] = array_column($normalized['organizations'], 'name');

        return $normalized;
    }

    public function supportsNormalization(mixed $data, ?string $format = null, array $context = []): bool
    {
        return $data instanceof Conference;
    }

    public function getSupportedTypes(?string $format): array
    {
        return [
            Conference::class => true,
        ];
    }
}
