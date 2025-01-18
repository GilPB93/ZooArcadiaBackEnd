<?php

namespace App\Controller;

use App\Repository\ZooServicesRepository;
use App\Entity\ZooServices;
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

#[Route('/api/services', name: 'app_api_services_')]
class ZooSericesController extends AbstractController
{
    public function __construct(
        private ZooServicesRepository $repository,
        private EntityManagerInterface $manager,
        private SerializerInterface $serializer,
        private UrlGeneratorInterface $urlGenerator,
    ){
    }

    //CREATE SERVICE
    #[Route(name: 'new', methods: 'POST')]
    #[isGranted('ROLE_ADMIN')]
    #[OA\Post(
        path: '/api/services',
        summary: 'Create a new service',
        requestBody: new OA\RequestBody(
            description: 'Service data',
            required: true,
            content: new OA\JsonContent(
                properties: [
                    new OA\Property(property: 'serviceName', type: 'string', example: "Nom du service"),
                    new OA\Property(property: 'serviceDescription', type: 'string', example: "Description du service"),
                    new OA\Property(property: 'serviceImg', type: 'string', example: "Image du service")
                ]
            )
        ),
        tags: ['Services'],
        responses: [
            new OA\Response(
                response: '201',
                description: 'Service created',
                content: new OA\JsonContent(
                    properties: [
                        new OA\Property(property: 'id', type: 'integer', example: 1),
                        new OA\Property(property: 'serviceName', type: 'string', example: "Nom du service"),
                        new OA\Property(property: 'serviceDescription', type: 'string', example: "Description du service"),
                        new OA\Property(property: 'serviceImg', type: 'string', example: "Image du service")
                    ],
                    type: 'object'
                )
            ),
            new OA\Response(
                response: '400',
                description: 'Invalid data'
            )
        ]
    )]
    public function new(Request $request) : JsonResponse
    {
        $zooServices = $this->serializer->deserialize($request->getContent(), ZooServices::class, 'json');

        $this->manager->persist($zooServices);
        $this->manager->flush();

        return new JsonResponse(
            $this->serializer->serialize($zooServices, 'json'),
            Response::HTTP_CREATED,
            ['location' => $this->urlGenerator->generate('app_api_services_show', ['id' => $zooServices->getId()])]
        );
    }


    //SHOW SERVICE
    #[Route('/{id}', name: 'show', methods: ['GET'])]
    #[isGranted ('ROLE_ADMIN')]
    #[OA\Get(
        path: '/api/services/{id}',
        summary: 'Get a service by its ID',
        tags: ['Services'],
        parameters: [
            new OA\Parameter(
                name: 'id',
                description: 'The ID of the service',
                in: 'path',
                required: true,
                schema: new OA\Schema(type: 'integer')
            )
        ],
        responses: [
            new OA\Response(
                response: '200',
                description: 'Service found',
                content: new OA\JsonContent(
                    properties: [
                        new OA\Property(property: 'id', type: 'integer', example: 1),
                        new OA\Property(property: 'serviceName', type: 'string', example: "Nom du service"),
                        new OA\Property(property: 'serviceDescription', type: 'string', example: "Description du service"),
                        new OA\Property(property: 'serviceImg', type: 'string', example: "Image du service")
                    ],
                    type: 'object'
                )
            ),
            new OA\Response(
                response: '404',
                description: 'Service not found'
            )
        ]
    )]
    public function show(int $id) : JsonResponse
    {
        $zooServices = $this->repository->findOneBy(['id' => $id]);

        if ($zooServices) {
            return new JsonResponse(
                $this->serializer->serialize($zooServices, 'json'),
                Response::HTTP_OK,
            );
        }

        return new JsonResponse(null, Response::HTTP_NOT_FOUND);
    }

    //UPDATE SERVICE
    #[Route('/{id}', name: 'update', methods: ['PUT'])]
    #[isGranted('ROLE_ADMIN')]
    #[OA\Put(
        path: '/api/services/{id}',
        summary: 'Update a service by its ID',
        requestBody: new OA\RequestBody(
            description: 'Service data',
            required: true,
            content: new OA\JsonContent(
                properties: [
                    new OA\Property(property: 'serviceName', type: 'string', example: "Nom du service"),
                    new OA\Property(property: 'serviceDescription', type: 'string', example: "Description du service"),
                    new OA\Property(property: 'serviceImg', type: 'string', example: "Image du service")
                ],
                type: 'object'
            )
        ),
        tags: ['Services'],
        parameters: [
            new OA\Parameter(
                name: 'id',
                description: 'The ID of the service',
                in: 'path',
                required: true,
                schema: new OA\Schema(type: 'integer')
            )
        ],
        responses: [
            new OA\Response(
                response: '204',
                description: 'Service updated successfully',
            ),
            new OA\Response(
                response: '404',
                description: 'Service not found'
            )
        ]
    )]
    public function update(int $id, Request $request) : JsonResponse
    {
        $zooServices = $this->repository->findOneBy(['id' => $id]);

        if ($zooServices) {
            $this->serializer->deserialize($request->getContent(), ZooServices::class, 'json', ['object_to_populate' => $zooServices]);

            $this->manager->flush();

            return new JsonResponse(
                $this->serializer->serialize($zooServices, 'json'),
                Response::HTTP_OK,
            );
        }

        return new JsonResponse(null, Response::HTTP_NOT_FOUND);
    }


    //DELETE SERVICE
    #[Route('/{id}', name: 'delete', methods: ['DELETE'])]
    #[isGranted('ROLE_ADMIN')]
    #[OA\Delete(
        path: '/api/services/{id}',
        summary: 'Delete a service by its ID',
        tags: ['Services'],
        parameters: [
            new OA\Parameter(
                name: 'id',
                description: 'The ID of the service',
                in: 'path',
                required: true,
                schema: new OA\Schema(type: 'integer')
            )
        ],
        responses: [
            new OA\Response(
                response: '204',
                description: 'Service deleted successfully',
            ),
            new OA\Response(
                response: '404',
                description: 'Service not found'
            )
        ]
    )]

    public function delete(int $id) : JsonResponse
    {
        $zooServices = $this->repository->findOneBy(['id' => $id]);

        if ($zooServices) {
            $this->manager->remove($zooServices);
            $this->manager->flush();

            return new JsonResponse(null, Response::HTTP_NO_CONTENT);
        }

        return new JsonResponse(null, Response::HTTP_NOT_FOUND);
    }


}
