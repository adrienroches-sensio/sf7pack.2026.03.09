<?php

namespace App\Security\Conference;

use App\Entity\Conference;
use App\Security\ConferencePermission;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Authorization\AccessDecisionManagerInterface;
use Symfony\Component\Security\Core\Authorization\Voter\Vote;
use Symfony\Component\Security\Core\Authorization\Voter\VoterInterface;

final class IsWebsiteStaffVoter implements VoterInterface
{
    public function __construct(
        private readonly AccessDecisionManagerInterface $accessDecisionManager,
    ) {
    }

    public function vote(TokenInterface $token, mixed $subject, array $attributes, ?Vote $vote = null): int
    {
        [$attribute] = $attributes;

        if (! ConferencePermission::belong($attribute)) {
            return self::ACCESS_ABSTAIN;
        }

        if (! $subject instanceof Conference) {
            return self::ACCESS_ABSTAIN;
        }

        $isRoleWebsite = $this->accessDecisionManager->decide($token, ['ROLE_WEBSITE'], $subject);

        if (false === $isRoleWebsite) {
            $vote?->addReason('User is not a website staff.');

            return self::ACCESS_ABSTAIN;
        }

        return self::ACCESS_GRANTED;
    }
}
