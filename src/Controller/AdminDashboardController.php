<?php

namespace App\Controller;

use App\Entity\Animal;
use App\Security\Roles;
use Doctrine\ORM\EntityManagerInterface;
use OpenApi\Attributes as OA;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;

#[Route('/api/adminDashboard', name: 'app_api_adminDashboard')]
class AdminDashboardController extends AbstractController
{
    #[Route('/incrementViews/{animalId}', name: 'app_api_adminDashboard_incrementViews', methods: ['POST'])]
    #[isGranted(Roles::ROLE_ADMIN)]
    #[OA\Post(
        path: '/api/adminDashboard/incrementViews/{animalId}',
        summary: 'Increment the views of an animal',
        requestBody: new OA\RequestBody(
            required: true,
            content: new OA\JsonContent(
                properties: [
                    new OA\Property(property: 'animalId', type: 'integer')
                ],
                type: 'object'
            )
        ),
        tags: ['Admin Dashboard'],
        parameters: [
            new OA\Parameter(
                name: 'animalId',
                description: 'The ID of the animal',
                in: 'path',
                required: true,
                schema: new OA\Schema(type: 'integer')
            )
        ],
        responses: [
            new OA\Response(
                response: 200,
                description: 'The views of the animal',
                content: new OA\JsonContent(
                    properties: [
                        new OA\Property(property: 'views', type: 'integer')
                    ],
                    type: 'object'
                )
            ),
            new OA\Response(
                response: 404,
                description: 'Animal not found',
                content: new OA\JsonContent(
                    properties: [
                        new OA\Property(property: 'error', type: 'string')
                    ],
                    type: 'object'
                )
            )
        ]
    )]
    public function incrementViews(int $animalId, EntityManagerInterface $manager): JsonResponse
    {
        $animal = $manager->getRepository(Animal::class)->findOneBy(['id' => $animalId]);

        if (!$animal) {
            return new JsonResponse(['error' => 'Animal not found'], Response::HTTP_NOT_FOUND);
        }

        $animal->incrementViews();
        $manager->flush();

        return new JsonResponse(['views' => $animal->getViews()], Response::HTTP_OK);
    }
}