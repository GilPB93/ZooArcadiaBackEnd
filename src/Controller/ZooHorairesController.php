<?php

namespace App\Controller;

use App\Repository\ZooHorairesRepository;
use App\Entity\ZooHoraires;
use Doctrine\ORM\EntityManagerInterface;
use OpenApi\Attributes as OA;
use OpenApi\Attributes\JsonContent;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;
use Symfony\Component\Serializer\SerializerInterface;

#[Route('/api/horaires', name: 'app_api_horaires_')]
class ZooHorairesController extends AbstractController{

    public function __construct(
        private ZooHorairesRepository $repository,
        private EntityManagerInterface $manager,
        private SerializerInterface $serializer,
        ){
        }


    //CREATE HORAIRES
    #[Route (name: 'new', methods: ['POST'])]
    #[isGranted('ROLE_ADMIN')]
    #[OA\Post(
        path: '/api/horaires',
        summary: 'Create a new horaire',
        requestBody: new OA\RequestBody(
            description: 'Create a new horaire',
            required: true,
            content: new OA\JsonContent(
                properties: [
                    new OA\Property(property: 'joursSemaine', type: 'string', example: 'Lundi'),
                    new OA\Property(property: 'statusOuverture', type: 'string', example: 'Ouvert'),
                    new OA\Property(property: 'horaireOuverture', type: 'string', example: '08:00:00'),
                    new OA\Property(property: 'horaireFermeture', type: 'string', example: '20:00:00')
                ],
                type: 'object'
            )
        ),
        tags: ['Horaires'],
        responses: [
            new OA\Response(
                response: 201,
                description: 'Created',
                content: new OA\JsonContent(
                    properties: [
                        new OA\Property(property: 'id', type: 'integer', example: 1),
                        new OA\Property(property: 'joursSemaine', type: 'string', example: 'Lundi'),
                        new OA\Property(property: 'statusOuverture', type: 'string', example: 'Ouvert'),
                        new OA\Property(property: 'horaireOuverture', type: 'string', example: '08:00:00'),
                        new OA\Property(property: 'horaireFermeture', type: 'string', example: '20:00:00')
                    ]
                )
            )
        ]
    )]
    public function new(Request $request): JsonResponse
    {
        $zooHoraires = $this->serializer->deserialize($request->getContent(), ZooHoraires::class, 'json');

        $this->manager->persist($zooHoraires);
        $this->manager->flush();

        return new JsonResponse(
            $this->serializer->serialize($zooHoraires, 'json'),
            Response::HTTP_CREATED,
        );
    }


    //SHOW HORAIRES
    #[Route ('/{id}', name: 'show', methods: ['GET'])]
    #[OA\Get(
        path: '/api/horaires/{id}',
        summary: 'Get a horaire by id',
        tags: ['Horaires'],
        parameters: [
            new OA\Parameter(
                name: 'id',
                description: 'The id of the horaire',
                in: 'path',
                required: true,
                schema: new OA\Schema(type: 'integer')
            )
        ],
        responses: [
            new OA\Response(
                response: 200,
                description: 'Success',
                content: new JsonContent(
                    properties: [
                        new OA\Property(property: 'id', type: 'integer', example: 1),
                        new OA\Property(property: 'joursSemaine', type: 'string', example: 'Lundi'),
                        new OA\Property(property: 'statusOuverture', type: 'string', example: 'Ouvert'),
                        new OA\Property(property: 'horaireOuverture', type: 'string', example: '08:00:00'),
                        new OA\Property(property: 'horaireFermeture', type: 'string', example: '20:00:00')
                    ]
                )
            ),
            new OA\Response(
                response: 404,
                description: 'Not found'
            )
        ]
    )]
    public function show(int $id): JsonResponse
    {
        $zooHoraires= $this->repository->findOneBy(['id' => $id]);
        if ($zooHoraires) {
            return new JsonResponse($this->serializer->serialize($zooHoraires, 'json'),
            Response::HTTP_OK,
        );
        }

        return new JsonResponse(
            null,
            Response::HTTP_NOT_FOUND
        );
    }


    //EDIT HORAIRES
    #[Route ('/{id}', name: 'edit', methods: ['PUT'])]
    #[isGranted('ROLE_ADMIN')]
    #[OA\Put(
        path: '/api/horaires/{id}',
        summary: 'Edit a horaire by id',
        requestBody: new OA\RequestBody(
            description: 'Edit a horaire',
            required: true,
            content: new OA\JsonContent(
                properties: [
                    new OA\Property(property: 'joursSemaine', type: 'string', example: 'Lundi'),
                    new OA\Property(property: 'statusOuverture', type: 'string', example: 'Ouvert'),
                    new OA\Property(property: 'horaireOuverture', type: 'string', example: '08:00:00'),
                    new OA\Property(property: 'horaireFermeture', type: 'string', example: '20:00:00')
                ],
                type: 'object'
            )
        ),
        tags: ['Horaires'],
        parameters: [
            new OA\Parameter(
                name: 'id',
                description: 'The id of the horaire',
                in: 'path',
                required: true,
                schema: new OA\Schema(type: 'integer')
            )
        ],
        responses: [
            new OA\Response(
                response: 204,
                description: 'Successfully updated',
            ),
            new OA\Response(
                response: 404,
                description: 'Not found'
            )
        ]

    )]
    public function edit(int $id, Request $request): JsonResponse
    {
        $zooHoraires = $this->repository->findOneBy(['id' => $id]);
        if ($zooHoraires) {
            $this->serializer->deserialize($request->getContent(),
                ZooHoraires::class,
                'json',
                ['object_to_populate' => $zooHoraires]
            );

            $this->manager->persist($zooHoraires);
            $this->manager->flush();

            return new JsonResponse(
                $this->serializer->serialize($zooHoraires, 'json'),
                Response::HTTP_OK,
            );
        }

        return new JsonResponse(
            null,
            Response::HTTP_NOT_FOUND
        );
    }
}
