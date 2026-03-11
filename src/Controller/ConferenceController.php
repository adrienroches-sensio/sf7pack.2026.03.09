<?php

namespace App\Controller;

use App\Entity\Conference;
use App\Repository\ConferenceRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Routing\Requirement\Requirement;

class ConferenceController extends AbstractController
{
    #[Route(
        path: '/conference/{name}/{start}/{end}',
        name: 'app_conference_new',
        requirements: [
            'name' => Requirement::ASCII_SLUG,
            'start' => Requirement::DATE_YMD,
            'end' => Requirement::DATE_YMD,
        ],
        methods: ['GET'],
    )]
    public function newConference(string $name, string $start, string $end, EntityManagerInterface $entityManager): Response
    {
        $conference = (new Conference())
            ->setName($name)
            ->setDescription('Some generic description')
            ->setAccessible(true)
            ->setStartAt(new \DateTimeImmutable($start))
            ->setEndAt(new \DateTimeImmutable($end))
        ;

        $entityManager->persist($conference);
        $entityManager->flush();

        return new Response('Conference created');
    }

    #[Route(
        path: '/conferences',
        name: 'app_conference_list',
        methods: ['GET'],
    )]
    public function list(ConferenceRepository $conferenceRepository): Response
    {
        $conferences = $conferenceRepository->listAll();

        return $this->render('conference/list.html.twig', [
            'conferences' => $conferences
        ]);
    }

    #[Route(
        path: '/conferences/{id}',
        name: 'app_conference_show',
        requirements: [
            'id' => Requirement::DIGITS,
        ],
        methods: ['GET'],
    )]
    public function show(Conference $conference): Response
    {
        return $this->render('conference/show.html.twig', [
            'conference' => $conference,
        ]);
    }
}
