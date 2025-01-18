<?php

namespace App\Controller;


use App\Entity\User;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use OpenApi\Attributes as OA;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;
use Symfony\Component\Serializer\Normalizer\AbstractNormalizer;
use Symfony\Component\Serializer\SerializerInterface;


#[Route('/api/user', name: 'app_api_user_')]
class UserController extends AbstractController
{
    public function __construct(
        private EntityManagerInterface $manager,
        private SerializerInterface $serializer,
        private UserRepository $repository,
    ) {
    }

    //READ USER - GET
    #[Route('/{id}', name: 'show', methods: ['GET'])]
    #[isGranted('ROLE_ADMIN')]
    #[OA\Get(
        path: '/api/user/{id}',
        summary: 'Get a user by id',
        tags: ['User'],
        parameters: [
            new OA\Parameter(
                name: 'id',
                description: 'The id of the user',
                in: 'path',
                required: true,
                schema: new OA\Schema(type: 'integer')
            )
        ],
        responses: [
            new OA\Response(
                response: 200,
                description: 'User found',
                content: new OA\JsonContent(
                    properties: [
                        new OA\Property(property: 'id', type: 'integer', example: 1),
                        new OA\Property(property: 'email', type: 'string', example: 'exemple@email.com'),
                        new OA\Property(property: 'roles', type: 'array', items: new OA\Items(type: 'string', example: 'ROLE_USER'))
                    ],
                    type: 'object'
                )
            ),
            new OA\Response(
                response: 404,
                description: 'User not found'
            )
        ]
    )]

    public function show(int $id): JsonResponse
    {
        $user = $this->repository->findOneBy(['id' => $id]);
        if ($user) {
            return new JsonResponse(
                $this->serializer->serialize($user, 'json', [AbstractNormalizer::IGNORED_ATTRIBUTES => ['password']]),
                Response::HTTP_OK
            );
        }

        return new JsonResponse(
            null,
            Response::HTTP_NOT_FOUND
        );

    }


    //UPDATE USER - PUT
    #[Route('/{id}', name: 'edit', methods: ['PUT'])]
    #[isGranted('ROLE_ADMIN')]
    #[OA\Put(
        path: '/api/user/{id}',
        summary: 'Update a user by id',
        requestBody: new OA\RequestBody(
            description: 'User data to update',
            required: true,
            content: new OA\JsonContent(
                properties: [
                    new OA\Property(property: 'email', type: 'string', example: 'exemple@email.com'),
                    new OA\Property(property: 'password', type: 'string', example: 'Test@123'),
                    new OA\Property(property: 'prenomUser', type: 'string', example: 'Prenom'),
                    new OA\Property(property: 'nomUser', type: 'string', example: 'Nom'),
                    new OA\Property(property: 'roles', type: 'array', items: new OA\Items(type: 'string', example: 'ROLE_USER'))
                ],
                type: 'object'
            )
        ),
        tags: ['User'],
        parameters: [
            new OA\Parameter(
                name: 'id',
                description: 'The id of the user',
                in: 'path',
                required: true,
                schema: new OA\Schema(type: 'integer')
            )
        ],
        responses: [
            new OA\Response(
                response: 204,
                description: 'User updated successfully'
            ),
            new OA\Response(
                response: 404,
                description: 'User not found'
            )
        ]
    )]
    public function edit(Request $request, int $id): JsonResponse
    {
        $user = $this->repository->findOneBy(['id' => $id]);
        if ($user) {
            $this->serializer->deserialize(
                $request->getContent(),
                User::class,
                'json',
                [AbstractNormalizer::OBJECT_TO_POPULATE => $user]);


            $this->manager->flush();

            return new JsonResponse(null, Response::HTTP_NO_CONTENT);
        }

        return new JsonResponse(null, Response::HTTP_NOT_FOUND);
    }


    //DELETE USER - DELETE
    #[Route('/{id}', name: 'delete', methods: ['DELETE'])]
    #[isGranted('ROLE_ADMIN')]
    #[OA\Delete(
        path: '/api/user/{id}',
        summary: 'Delete a user by id',
        tags: ['User'],
        parameters: [
            new OA\Parameter(
                name: 'id',
                description: 'The id of the user',
                in: 'path',
                required: true,
                schema: new OA\Schema(type: 'integer')
            )
        ],
        responses: [
            new OA\Response(
                response: 204,
                description: 'User deleted successfully'
            ),
            new OA\Response(
                response: 404,
                description: 'User not found'
            )
        ]
    )]
    public function delete(int $id): JsonResponse
    {
        $user = $this->repository->findOneBy(['id' => $id]);
        if ($user) {
            $this->manager->remove($user);
            $this->manager->flush();

            return new JsonResponse(null, Response::HTTP_NO_CONTENT);
        }

        return new JsonResponse(null, Response::HTTP_NOT_FOUND);
    }

}