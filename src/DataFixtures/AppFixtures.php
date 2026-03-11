<?php

namespace App\DataFixtures;

use App\Entity\Conference;
use App\Entity\Organization;
use DateTimeImmutable;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $sensioLabs = $this->createOrganization('SensioLabs');
        $manager->persist($sensioLabs);

        $currentYear = date('Y');

        for ($year = $currentYear - 15; $year <= $currentYear; $year++) {
            $symfonyLive = $this->createConference(
                name: "Symfony Live {$year}",
                start: new DateTimeImmutable("last thursday of March {$year}"),
                organizations: [$sensioLabs],
                description: "{$year} annual conference in Paris."
            );
            $manager->persist($symfonyLive);
        }

        $manager->flush();
    }

    private function createOrganization(string $name): Organization
    {
        $organization = new Organization();
        $organization->setName($name);
        $organization->setPresentation("Random presentation for {$name}.");
        $organization->setCreatedAt(new DateTimeImmutable('2025-11-05'));

        return $organization;
    }

    private function createConference(
        string $name,
        DateTimeImmutable $start,
        array $organizations = [],
        bool $accessible = true,
        string|null $description = null,
        string|null $prerequisites = null,
    ): Conference {
        $conference = new Conference();
        $conference->setName($name);
        $conference->setStartAt($start);
        $conference->setEndAt($start->modify('+1 day'));
        $conference->setAccessible($accessible);
        $conference->setDescription($description ?? "Random description for {$name}.");
        $conference->setPrerequisites($prerequisites);

        foreach ($organizations as $organization) {
            $conference->addOrganization($organization);
        }

        return $conference;
    }
}
