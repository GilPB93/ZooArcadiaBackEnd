<?php

namespace App\Controller;

use App\Repository\RaceAnimalRepository;
use App\Entity\RaceAnimal;
use Doctrine\ORM\EntityManagerInterface;
use OpenApi\Attributes as OA;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Symfony\Component\Security\Http\Attribute\IsGranted;
use Symfony\Component\Serializer\SerializerInterface;

#[Route('/api/raceAnimal', name: 'app_api_raceAnimal_')]
class RaceAnimalController extends AbstractController
{
    public function __construct(
        private EntityManagerInterface $manager,
        private RaceAnimalRepository $repository,
        private SerializerInterface $serializer,
        private UrlGeneratorInterface $urlGenerator,
    ){
    }

    //CREATE RACE ANIMAL
    #[Route(name: 'new', methods: ['POST'])]
    #[isGranted('ROLE_ADMIN')]
    #[OA\Post(
        path: "/api/raceAnimal",
        summary: "Create a new Race Animal",
        requestBody: new OA\RequestBody(
            description: 'Race Animal data',
            required: true,
            content: new OA\JsonContent(
                properties:  [
                    new OA\Property(property: 'raceLabel', type: 'string', example: 'Race Test')
                ]
            )
        ),
        tags: ["RaceAnimal"],
        responses: [
            new OA\Response(
                response: '201',
                description: 'Animal created',
                content: new OA\JsonContent(
                    properties: [
                        new OA\Property(property: 'id', type: 'integer', example: 1),
                        new OA\Property(property: 'raceLabel', type: 'string', example: 'Race Test')
                    ]
                )
            ),
            new OA\Response(
                response: '400',
                description: 'Bad request'
            )
        ]
    )]
    public function new(Request $request): JsonResponse
    {
        $raceAnimal = $this->serializer->deserialize($request->getContent(), RaceAnimal::class, 'json');

        $this->manager->persist($raceAnimal);
        $this->manager->flush();

        return new JsonResponse(
            $this->serializer->serialize($raceAnimal, 'json'),
            Response::HTTP_CREATED,
            ['Location' => $this->urlGenerator->generate('app_api_raceAnimal_show', ['id' => $raceAnimal->getId()])]
        );
    }


    //READ RACE ANIMAL
    #[Route('/{id}', name: 'show', methods: ['GET'])]
    #[OA\Get(
        path: '/api/raceAnimal/{id}',
        summary: 'Show details of a Race Animal',
        tags: ["RaceAnimal"],
        parameters: [
            new OA\Parameter(
                name: 'id',
                description: 'The ID of the Race Animal',
                in: 'path',
                required: true,
                schema: new OA\Schema(type: 'integer', example: 1)
            )
        ],
        responses: [
            new OA\Response(
                response: '200',
                description: 'Animal found',
                content: new OA\JsonContent(
                    properties: [
                        new OA\Property(property: 'id', type: 'integer', example: 1),
                        new OA\Property(property: 'raceLabel', type: 'string', example: 'Race Test')
                    ]
                )
            ),
            new OA\Response(
                response: '404',
                description: 'Animal not found'
            )
        ]
    )]
    public function show(int $id): JsonResponse
    {
        $raceAnimal = $this->repository->findOneBy(['id' => $id]);
        if (!$raceAnimal) {
            return new JsonResponse(null, Response::HTTP_NOT_FOUND);
        }

        return new JsonResponse(
            $this->serializer->serialize($raceAnimal, 'json'),
            Response::HTTP_OK,
            [],
            true
        );
    }


    //DELETE RACE ANIMAL
    #[Route('/{id}', name: 'delete', methods: ['DELETE'])]
    #[isGranted('ROLE_ADMIN')]
    #[OA\Delete(
        path: '/api/raceAnimal/{id}',
        summary: 'Delete Race Animal',
        tags: ["RaceAnimal"],
        parameters: [
            new OA\Parameter(
                name: 'id',
                description: 'The ID of the Race Animal',
                in: 'path',
                required: true,
                schema: new OA\Schema(type: 'integer', example: 1)
            )
        ],
        responses: [
            new OA\Response(
                response: '204',
                description: 'Animal deleted'
            ),
            new OA\Response(
                response: '404',
                description: 'Animal not found'
            )
        ]
    )]
    public function delete(int $id): JsonResponse
    {
        $raceAnimal = $this->repository->findOneBy(['id' => $id]);
        if (!$raceAnimal) {
            return new JsonResponse(null, Response::HTTP_NOT_FOUND);
        }

        $this->manager->remove($raceAnimal);
        $this->manager->flush();

        return new JsonResponse(null, Response::HTTP_NO_CONTENT);
    }
}
