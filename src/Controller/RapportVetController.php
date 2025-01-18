<?php

namespace App\Controller;

use App\Entity\User;
use App\Repository\RapportVetRepository;
use App\Entity\RapportVet;
use Doctrine\ORM\EntityManagerInterface;
use OpenApi\Attributes as OA;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Symfony\Component\Security\Http\Attribute\CurrentUser;
use Symfony\Component\Security\Http\Attribute\IsGranted;
use Symfony\Component\Serializer\SerializerInterface;

#[Route('/api/rapportVet', name: 'app_api_rapportVet_')]
class RapportVetController extends AbstractController
{
    public function __construct(
        private EntityManagerInterface $manager,
        private SerializerInterface $serializer,
        private RapportVetRepository $repository,
        private UrlGeneratorInterface $urlGenerator
    ){
    }

    //CREATE RAPPORTVET - POST
    #[Route(name: 'new', methods: ['POST'])]
    #[IsGranted('ROLE_VETERINAIRE')]
    #[OA\Post(
        path: '/api/rapportVet',
        summary: 'Create a new Rapport Vétérinaire',
        requestBody: new OA\RequestBody(
            description: 'The new Rapport Vétérinaire',
            required: true,
            content: new OA\JsonContent(
                properties: [
                    new OA\Property(property: 'etatSante', type: 'string', example: 'bonne santé'),
                    new OA\Property(property: 'alimentationRecommendee', type: 'string', example: 'foin, paille, granulés, ...'),
                    new OA\Property(property: 'quantiteRecommendee', type: 'string', example: '2kg'),
                    new OA\Property(property: 'etatHabitat', type: 'string', enum: ['Très bon état', 'Bon état', 'Etat moyen', 'Mauvais état'], example: 'Bon état'),
                    new OA\Property(property: 'commentHabitat', type: 'string', example: 'bon état - RAS'),
                    new OA\Property(property: 'animal', type: 'integer', example: 1),
                ],
                type: 'object'
            )
        ),
        tags: ['Rapport Vétérinaire'],
        responses: [
            new OA\Response(
                response: 201,
                description: 'Rapport Vétérinaire created',
                content: new OA\JsonContent(
                    properties: [
                        new OA\Property(property: 'id', type: 'integer', example: 1),
                        new OA\Property(property: 'etatSante', type: 'string', example: 'bonne santé'),
                        new OA\Property(property: 'alimentationRecommendee', type: 'string', example: 'foin, paille, granulés, ...'),
                        new OA\Property(property: 'quantiteRecommendee', type: 'string', example: '2kg'),
                        new OA\Property(property: 'etatHabitat', type: 'string', enum: ['Très bon état', 'Bon état', 'Etat moyen', 'Mauvais état'], example: 'Bon état'),
                        new OA\Property(property: 'commentHabitat', type: 'string', example: 'bon état - RAS'),
                        new OA\Property(property: 'createdAt', type: 'string', format: 'date-time', example: '2021-10-01T12:00:00+02:00'),
                        new OA\Property(property: 'createdBy', type: 'integer', example: 1),
                        new OA\Property(property: 'animal', type: 'integer', example: 1),
                    ],
                    type: 'object'
                )
            ),
            new OA\Response(
                response: 404,
                description: 'Rapport Vétérinaire not found'
            )
        ]
    )]

    public function new(Request $request, #[CurrentUser] ?User $user): JsonResponse
    {
        $rapportVet = $this->serializer->deserialize($request->getContent(), RapportVet::class, 'json');
        $rapportVet->setCreatedBy($user);
        $rapportVet->setCreatedAt(new \DateTimeImmutable());

        if ($rapportVet->getAnimal() && !$this->manager->contains($rapportVet->getAnimal())) {
            $this->manager->persist($rapportVet->getAnimal());
        }

        $this->manager->persist($rapportVet);
        $this->manager->flush();

        return new JsonResponse(
            $this->serializer->serialize($rapportVet, 'json'),
            Response::HTTP_CREATED,
            ['Location' => $this->urlGenerator->generate('app_api_rapportVet_read', ['id' => $rapportVet->getId()])]
        );
    }

    //READ RAPPORTVET - GET
    #[Route('/{id}', name: 'read', methods: ['GET'])]
    #[OA\Get(
        path: '/api/rapportVet/{id}',
        summary: 'Get a Rapport Vétérinaire by its ID',
        tags: ['Rapport Vétérinaire'],
        parameters: [
            new OA\Parameter(
                name: 'id',
                description: 'ID of the Rapport Vétérinaire to get',
                in: 'path',
                required: true,
                schema: new OA\Schema(type: 'integer', example: 1)
            )
        ],
        responses: [
            new OA\Response(
                response: 200,
                description: 'Rapport Vétérinaire found',
                content: new OA\JsonContent(
                    properties: [
                        new OA\Property(property: 'id', type: 'integer', example: 1),
                        new OA\Property(property: 'etatSante', type: 'string', example: 'bonne santé'),
                        new OA\Property(property: 'alimentationRecommendee', type: 'string', example: 'foin, paille, granulés, ...'),
                        new OA\Property(property: 'quantiteRecommendee', type: 'string', example: '2kg'),
                        new OA\Property(property: 'etatHabitat', type: 'string', enum: ['Très bon état', 'Bon état', 'Etat moyen', 'Mauvais état'], example: 'Bon état'),
                        new OA\Property(property: 'commentHabitat', type: 'string', example: 'bon état - RAS'),
                        new OA\Property(property: 'createdAt', type: 'string', format: 'date-time', example: '2021-10-01T12:00:00+02:00'),
                        new OA\Property(property: 'createdBy', type: 'integer', example: 1),
                        new OA\Property(property: 'animal', type: 'integer', example: 1),
                    ],
                    type: 'object'
                )
            ),
            new OA\Response(
                response: 404,
                description: 'Rapport Vétérinaire not found'
            )
        ]
    )]
    public function read(int $id): JsonResponse
    {
        $rapportVet = $this->repository->findOneBy(['id' => $id]);

        if (!$rapportVet) {
            return new JsonResponse(null, Response::HTTP_NOT_FOUND);
        }

        return new JsonResponse(
            $this->serializer->serialize($rapportVet, 'json'),
            Response::HTTP_OK
        );
    }

}
