<?php

declare(strict_types=1);

namespace App\Serializer\Normalizer\User;

use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Serializer\Normalizer\NormalizerInterface;

class UserInterfaceNormalizer implements NormalizerInterface
{
    /**
     * @param UserInterface $data
     */
    public function normalize(mixed $data, ?string $format = null, array $context = []): array|string|int|float|bool|\ArrayObject|null
    {
        return [
            'identifier' => $data->getUserIdentifier(),
            'roles' => $data->getRoles(),
        ];
    }

    public function supportsNormalization(mixed $data, ?string $format = null, array $context = []): bool
    {
        return $data instanceof UserInterface;
    }

    public function getSupportedTypes(?string $format): array
    {
        return [
            UserInterface::class => true,
        ];
    }
}
