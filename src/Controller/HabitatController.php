<?php

namespace App\Controller;

use App\Repository\HabitatRepository;
use App\Entity\Habitat;
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

#[Route('/api/habitat', name: 'app_api_habitat_')]
class HabitatController extends AbstractController{
    public function __construct(
        private EntityManagerInterface $manager,
        private HabitatRepository $repository,
        private SerializerInterface $serializer,
        private UrlGeneratorInterface $urlGenerator
    ){
    }

    //CREATE HABITAT - POST
    #[Route(name: 'new', methods: ['POST'])]
    #[isGranted('ROLE_ADMIN')]
    #[OA\Post(
        path: '/api/habitat',
        summary: 'Create a new habitat',
        requestBody: new OA\RequestBody(
            description: 'The new habitat',
            required: true,
            content: new OA\JsonContent(
                properties: [
                    new OA\Property(property: 'habitatName', type: 'string', example: "Nom de l'habitat test"),
                    new OA\Property(property: 'habitatDescription', type: 'string', example: "Description de l'habitat test"),
                    new OA\Property(property: 'habitatImg', type: 'string', example: "img.jpg test"),
                ]
            )
        ),
        tags: ['Habitat'],
        responses: [
            new OA\Response(
                response: '201',
                description: 'Habitat created',
                content: new OA\JsonContent(
                    properties: [
                        new OA\Property(property: 'id', type: 'integer', example: 1),
                        new OA\Property(property: 'habitatName', type: 'string', example: "Nom de l'habitat test"),
                        new OA\Property(property: 'habitatDescription', type: 'string', example: "Description de l'habitat test"),
                        new OA\Property(property: 'habitatImg', type: 'string', example: "img.jpg test"),
                    ],
                    type:'object'
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
    public function new(Request $request) : JsonResponse
    {
        $habitat = $this->serializer->deserialize($request->getContent(), Habitat::class, 'json');

        $this->manager->persist($habitat);
        $this->manager->flush();

        return new JsonResponse(
            $this->serializer->serialize($habitat, 'json'),
            Response::HTTP_CREATED,
            ['Location' => $this->urlGenerator->generate('app_api_habitat_read', ['id' => $habitat->getId()])]
        );
    }


    //READ HABITAT - GET
    #[Route('/{id}', name: 'read', methods: ['GET'])]
    #[OA\Get(
        path: '/api/habitat/{id}',
        summary: 'Get a habitat',
        tags: ['Habitat'],
        parameters: [
            new OA\Parameter(
                name: 'id',
                description: 'The habitat id',
                in: 'path',
                required: true,
                schema: new OA\Schema(type: 'integer'),
                example: 1
            )
        ],
        responses: [
            new OA\Response(
                response: '200',
                description: 'Habitat found',
                content: new OA\JsonContent(
                    properties: [
                        new OA\Property(property: 'id', type: 'integer', example: 1),
                        new OA\Property(property: 'habitatName', type: 'string', example: "Nom de l'habitat test"),
                        new OA\Property(property: 'habitatDescription', type: 'string', example: "Description de l'habitat test"),
                        new OA\Property(property: 'habitatImg', type: 'string', example: "img.jpg test"),
                    ],
                    type: 'object'
                )
            ),
            new OA\Response(
                response: '404',
                description: 'Habitat not found',
                content: new OA\JsonContent(
                    properties: [
                        new OA\Property(property: 'message', type: 'string', example: 'Habitat not found')
                    ],
                    type: 'object'
                )
            )
        ]
    )]
    public function read(int $id): JsonResponse
    {
        $habitat = $this->repository->findOneBy(['id' => $id]);

        if(!$habitat){
            return new JsonResponse(
                ['message' => 'Habitat not found'],
                Response::HTTP_NOT_FOUND
            );
        }

        return new JsonResponse(
            $this->serializer->serialize($habitat, 'json'),
            Response::HTTP_OK
        );
    }


    //UPDATE HABITAT - PUT
    #[Route('/{id}', name: 'update', methods: ['PUT'])]
    #[isGranted('ROLE_ADMIN')]
    #[OA\Put(
        path: '/api/habitat/{id}',
        summary: 'Update a habitat',
        requestBody: new OA\RequestBody(
            description: 'The updated habitat',
            required: true,
            content: new OA\JsonContent(
                properties: [
                    new OA\Property(property: 'habitatName', type: 'string', example: "Nom de l'habitat test"),
                    new OA\Property(property: 'habitatDescription', type: 'string', example: "Description de l'habitat test"),
                    new OA\Property(property: 'habitatImg', type: 'string', example: "img.jpg test"),
                ]
            )
        ),
        tags: ['Habitat'],
        parameters: [
            new OA\Parameter(
                name: 'id',
                description: 'The habitat id',
                in: 'path',
                required: true,
                schema: new OA\Schema(type: 'integer'),
                example: 1
            )
        ],
        responses: [
            new OA\Response(
                response: '200',
                description: 'Habitat updated',
                content: new OA\JsonContent(
                    properties: [
                        new OA\Property(property: 'id', type: 'integer', example: 1),
                        new OA\Property(property: 'habitatName', type: 'string', example: "Nom de l'habitat test"),
                        new OA\Property(property: 'habitatDescription', type: 'string', example: "Description de l'habitat test"),
                        new OA\Property(property: 'habitatImg', type: 'string', example: "img.jpg test"),
                    ],
                    type: 'object'
                )
            ),
            new OA\Response(
                response: '404',
                description: 'Habitat not found',
                content: new OA\JsonContent(
                    properties: [
                        new OA\Property(property: 'message', type: 'string', example: 'Habitat not found')
                    ],
                    type: 'object'
                )
            )
        ]
    )]
    public function update(int $id, Request $request): JsonResponse
    {
        $habitat = $this->repository->findOneBy(['id' => $id]);

        if(!$habitat){
            return new JsonResponse(
                ['message' => 'Habitat not found'],
                Response::HTTP_NOT_FOUND
            );
        }

        $this->serializer->deserialize($request->getContent(), Habitat::class, 'json', ['object_to_populate' => $habitat]);

        $this->manager->flush();

        return new JsonResponse(
            $this->serializer->serialize($habitat, 'json'),
            Response::HTTP_OK
        );
    }


    //DELETE HABITAT - DELETE
    #[Route('/{id}', name: 'delete', methods: ['DELETE'])]
    #[isGranted('ROLE_ADMIN')]
    #[OA\Delete(
        path: '/api/habitat/{id}',
        summary: 'Delete a habitat',
        tags: ['Habitat'],
        parameters: [
            new OA\Parameter(
                name: 'id',
                description: 'The habitat id',
                in: 'path',
                required: true,
                schema: new OA\Schema(type: 'integer'),
                example: 1
            )
        ],
        responses: [
            new OA\Response(
                response: '200',
                description: 'Habitat deleted',
                content: new OA\JsonContent(
                    properties: [
                        new OA\Property(property: 'message', type: 'string', example: 'Habitat deleted')
                    ],
                    type: 'object'
                )
            ),
            new OA\Response(
                response: '404',
                description: 'Habitat not found',
                content: new OA\JsonContent(
                    properties: [
                        new OA\Property(property: 'message', type: 'string', example: 'Habitat not found')
                    ],
                    type: 'object'
                )
            )
        ]
    )]
    public function delete(int $id): JsonResponse
    {
    $habitat = $this->repository->findOneBy(['id' => $id]);

    if(!$habitat){
        return new JsonResponse(
            ['message' => 'Habitat not found'],
            Response::HTTP_NOT_FOUND
        );
    }

    $this->manager->remove($habitat);
    $this->manager->flush();

    return new JsonResponse(
        ['message' => 'Habitat deleted'],
        Response::HTTP_OK
    );
}
}