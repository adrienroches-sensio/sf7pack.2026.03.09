<?php

namespace App\Controller\Api;

use App\Search\Conference\ConferenceSearchInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Serializer\SerializerInterface;

#[Route(
    path: '/api/conferences',
    name: 'api_conferences_list',
    methods: ['GET'],
)]
final class ListConferenceController
{
    public function __construct(
        private readonly SerializerInterface $serializer,
        private readonly ConferenceSearchInterface $conferenceSearch,
    ) {
    }

    public function __invoke(Request $request): JsonResponse
    {
        $conferences = $this->conferenceSearch->searchByName($request->query->getString('name'));

        $data = $this->serializer->serialize($conferences, 'json');

        return new JsonResponse(
            $data,
            json: true,
        );
    }
}
