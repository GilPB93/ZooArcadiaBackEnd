<?php

namespace App\Controller;

use App\Entity\Animal;
use App\Repository\AnimalRepository;
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

#[Route('/api/animal', name: 'app_api_animal_')]
class AnimalController extends AbstractController
{
    public function __construct(
        private EntityManagerInterface $manager,
        private AnimalRepository $repository,
        private SerializerInterface $serializer,
        private UrlGeneratorInterface $urlGenerator,
    ){
    }

    //CREATE ANIMAL - POST
    #[Route(name: 'new', methods: ['POST'])]
    #[isGranted('ROLE_ADMIN')]
    #[OA\Post(
        path: '/api/animal',
        summary: 'Create a new animal',
        requestBody: new OA\RequestBody(
            description: 'Animal data',
            required: true,
            content: new OA\JsonContent(
                properties: [
                    new OA\Property(property: 'prenomAnimal', type: 'string', example: "Nom de l'animal"),
                    new OA\Property(property: 'imgAnimal', type: 'string', example: "Image de l'animal"),
                    new OA\Property(property: 'curiositesAnimal', type: 'string', example: "Curiosités de l'animal"),
                    new OA\Property(property: 'descriptionAnimal', type: 'string', example: "Description de l'animal"),
                    new OA\Property(property: 'raceAnimal', type: 'object', example: "Race de l'animal"),
                    new OA\Property(property: 'habitat', type: 'object', example: "Habitat d'affectation de l'animal")
                ]
            )
        ),
        tags: ['Animal'],
        responses: [
            new OA\Response(
                response: '201',
                description: 'Animal created',
                content: new OA\JsonContent(
                    properties: [
                        new OA\Property(property: 'id', type: 'integer', example: 1),
                        new OA\Property(property: 'prenomAnimal', type: 'string', example: "Nom de l'animal"),
                        new OA\Property(property: 'imgAnimal', type: 'string', example: "Image de l'animal"),
                        new OA\Property(property: 'curiositesAnimal', type: 'string', example: "Curiosités de l'animal"),
                        new OA\Property(property: 'descriptionAnimal', type: 'string', example: "Description de l'animal"),
                        new OA\Property(property: 'raceAnimal', type: 'object', example: "Race de l'animal"),
                        new OA\Property(property: 'habitat', type: 'object', example: "Habitat d'affectation de l'animal")
                    ],
                    type: 'object'
                )
            ),
            new OA\Response(
                response: '400',
                description: 'Invalid data',
                content: new OA\JsonContent(
                    properties: [
                        new OA\Property(property: 'message', type: 'string', example: "Invalid data")
                    ],
                    type: 'object'
                )
            )
        ]
    )]
    public function create(Request $request): JsonResponse
    {
        $animal = $this->serializer->deserialize($request->getContent(), Animal::class, 'json');
        $this->manager->persist($animal);
        $this->manager->flush();

        return new JsonResponse(
            $this->serializer->serialize($animal, 'json'),
            Response::HTTP_CREATED,
            ['location' => $this->urlGenerator->generate('app_api_animal_show', ['id' => $animal->getId()])],
        );
    }

    //READ ANIMAL - GET
    #[Route('/{id}' ,name: 'show', methods: ['GET'])]
    #[OA\Get(
        path: '/api/animal/{id}',
        summary: 'Get an animal by its ID',
        tags: ['Animal'],
        parameters: [
            new OA\Parameter(
                name: 'id',
                description: 'The ID of the animal',
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
                        new OA\Property(property: 'prenomAnimal', type: 'string', example: "Nom de l'animal"),
                        new OA\Property(property: 'imgAnimal', type: 'string', example: "Image de l'animal"),
                        new OA\Property(property: 'curiositesAnimal', type: 'string', example: "Curiosités de l'animal"),
                        new OA\Property(property: 'descriptionAnimal', type: 'string', example: "Description de l'animal"),
                        new OA\Property(property: 'raceAnimal', type: 'object', example: "Race de l'animal"),
                        new OA\Property(property: 'habitat', type: 'object', example: "Habitat d'affectation de l'animal")
                    ],
                    type: 'object'
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
        $animal = $this->repository->findOneBy(['id' => $id]);
        if ($animal === null) {
            return new JsonResponse(null, Response::HTTP_NOT_FOUND);
        }
        return new JsonResponse($this->serializer->serialize($animal, 'json'), Response::HTTP_OK, [], true);
    }


    //UPDATE ANIMAL - PUT
    #[Route('/{id}', name: 'update', methods: ['PUT'])]
    #[isGranted('ROLE_ADMIN')]
    #[OA\Put(
        path: '/api/animal/{id}',
        summary: 'Update an animal by its ID',
        requestBody: new OA\RequestBody(
            description: 'Animal data',
            required: true,
            content: new OA\JsonContent(
                properties: [
                    new OA\Property(property: 'prenomAnimal', type: 'string', example: "Nom de l'animal"),
                    new OA\Property(property: 'imgAnimal', type: 'string', example: "Image de l'animal"),
                    new OA\Property(property: 'curiositesAnimal', type: 'string', example: "Curiosités de l'animal"),
                    new OA\Property(property: 'descriptionAnimal', type: 'string', example: "Description de l'animal"),
                    new OA\Property(property: 'raceAnimal', type: 'object', example: "Race de l'animal"),
                    new OA\Property(property: 'habitat', type: 'object', example: "Habitat d'affectation de l'animal")
                ],
                type: 'object'
            )
        ),
        tags: ['Animal'],
        parameters: [
            new OA\Parameter(
                name: 'id',
                description: 'The ID of the animal',
                in: 'path',
                required: true,
                schema: new OA\Schema(type: 'integer', example: 1)
            )
        ],
        responses: [
            new OA\Response(
                response: '200',
                description: 'Animal updated',
                content: new OA\JsonContent(
                    properties: [
                        new OA\Property(property: 'id', type: 'integer', example: 1),
                        new OA\Property(property: 'prenomAnimal', type: 'string', example: "Nom de l'animal"),
                        new OA\Property(property: 'imgAnimal', type: 'string', example: "Image de l'animal"),
                        new OA\Property(property: 'curiositesAnimal', type: 'string', example: "Curiosités de l'animal"),
                        new OA\Property(property: 'descriptionAnimal', type: 'string', example: "Description de l'animal"),
                        new OA\Property(property: 'raceAnimal', type: 'object', example: "Race de l'animal"),
                        new OA\Property(property: 'habitat', type: 'object', example: "Habitat d'affectation de l'animal")
                    ],
                    type: 'object'
                )
            ),
            new OA\Response(
                response: '404',
                description: 'Animal not found'
            )
        ]
    )]
    public function update(int $id, Request $request): JsonResponse
    {
        $animal = $this->repository->findOneBy(['id' => $id]);
        if ($animal === null) {
            return new JsonResponse(null, Response::HTTP_NOT_FOUND);
        }
        $this->serializer->deserialize($request->getContent(), Animal::class, 'json', ['object_to_populate' => $animal]);

        $this->manager->flush();

        return new JsonResponse($this->serializer->serialize($animal, 'json'), Response::HTTP_OK, [], true);
    }


    //DELETE ANIMAL - DELETE
    #[Route('/{id}', name: 'delete', methods: ['DELETE'])]
    #[isGranted('ROLE_ADMIN')]
    #[OA\Delete(
        path: '/api/animal/{id}',
        summary: 'Delete an animal by its ID',
        tags: ['Animal'],
        parameters: [
            new OA\Parameter(
                name: 'id',
                description: 'The ID of the animal',
                in: 'path',
                required: true,
                schema: new OA\Schema(type: 'integer', example: 1)
            )
        ],
        responses: [
            new OA\Response(
                response: '204',
                description: 'Animal deleted successfully',
            ),
            new OA\Response(
                response: '404',
                description: 'Animal not found'
            )
        ]
    )]
    public function delete(int $id): JsonResponse
    {
        $animal = $this->repository->find($id);
        if ($animal === null) {
            return new JsonResponse(null, Response::HTTP_NOT_FOUND);
        }
        $this->manager->remove($animal);
        $this->manager->flush();

        return new JsonResponse(null, Response::HTTP_NO_CONTENT);
    }
}
