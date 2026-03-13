<?php

namespace App\Security\Conference;

use App\Security\ConferencePermission;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Authorization\AccessDecisionManagerInterface;
use Symfony\Component\Security\Core\Authorization\Voter\Vote;
use Symfony\Component\Security\Core\Authorization\Voter\VoterInterface;

final class CanCreateVoter implements VoterInterface
{
    public function __construct(
        private readonly AccessDecisionManagerInterface $accessDecisionManager,
    ) {
    }

    public function vote(TokenInterface $token, mixed $subject, array $attributes, ?Vote $vote = null): int
    {
        [$attribute] = $attributes;

        if (ConferencePermission::CREATE !== $attribute) {
            return self::ACCESS_ABSTAIN;
        }

        $isRoleOrganizer = $this->accessDecisionManager->decide($token, ['ROLE_ORGANIZER'], $subject);

        if (true === $isRoleOrganizer) {
            $vote?->addReason('User is an organizer.');

            return self::ACCESS_GRANTED;
        }

        return self::ACCESS_ABSTAIN;
    }
}
