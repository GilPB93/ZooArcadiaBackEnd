<?php

namespace App\Controller;

use App\Entity\AccountStatus;
use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use OpenApi\Attributes as OA;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Attribute\CurrentUser;
use Symfony\Component\Security\Http\Attribute\IsGranted;
use Symfony\Component\Serializer\SerializerInterface;

#[Route('/api', name: 'app_api_')]
class SecurityController extends AbstractController
{
    public function __construct(
        private EntityManagerInterface $manager,
        private SerializerInterface $serializer,
        private UserPasswordHasherInterface $passwordHasher,

    ) {
    }

    //CREATE/REGISTRATION USER - POST
    #[Route('/register', name: 'register', methods: ['POST'])]
    #[IsGranted('ROLE_ADMIN')]
    #[OA\Post(
        path: '/api/register',
        summary: 'Register a new user',
        requestBody: new OA\RequestBody(
            description: 'User data to register',
            required: true,
            content: new OA\JsonContent(
                properties: [
                    new OA\Property(property: 'prenomUser', type: 'string', example: 'Prenom'),
                    new OA\Property(property: 'nomUser', type: 'string', example: 'Nom'),
                    new OA\Property(property: 'email', type: 'string', example: 'exemple@email.com'),
                    new OA\Property(property: 'password', type: 'string', example: 'Test@123'),
                    new OA\Property(property: 'roles', type: 'array', items: new OA\Items(type: 'string', example: 'ROLE_EMPLOYE')),
                ],
                type: 'object'
            )
        ),
        tags: ['User'],
        responses: [
            new OA\Response(
                response: 201,
                description: 'User registered successfully',
                content: new OA\JsonContent(
                    properties: [
                        new OA\Property(property: 'id', type: 'integer', example: 1),
                        new OA\Property(property: 'email', type: 'string', example: 'exemple@email.com'),
                        new OA\Property(property: 'prenomUser', type: 'string', example: 'Prenom'),
                        new OA\Property(property: 'nomUser', type: 'string', example: 'Nom'),
                        new OA\Property(property: 'apiToken', type: 'string', example: '31a023e212f116124a36af14ea0c1c3806eb9378'),
                        new OA\Property(property: 'roles', type: 'array', items: new OA\Items(type: 'string', example: 'ROLE_EMPLOYE')),
                        new OA\Property(property: 'createdAt', type: 'string', format: 'date-time', example: '2021-09-30T14:00:00.000000Z'),
                    ],
                    type: 'object'
                )
            )
        ]
    )]
    public function register(Request $request): JsonResponse
    {
        $user = $this->serializer->deserialize($request->getContent(), User::class, 'json');
        $user->setPassword($this->passwordHasher->hashPassword($user, $user->getPassword()));
        $user->setCreatedAt(new \DateTimeImmutable());

        $this->manager->persist($user);
        $this->manager->flush();

        return new JsonResponse(
            ['user' => $user->getUserIdentifier(),
                'apiToken' => $user->getApiToken(),
                'roles' => $user->getRoles(),
            Response::HTTP_CREATED
            ]);
    }


    //LOGIN CONTROLLER
    #[Route('/login', name: 'login', methods: ['POST'])]
    #[OA\Post(
        path: '/api/login',
        summary: 'Login a user',
        requestBody: new OA\RequestBody(
            description: 'User data to login',
            required: true,
            content: new OA\JsonContent(
                properties: [
                    new OA\Property(property: 'email', type: 'string', example: 'exemple@email.com'),
                    new OA\Property(property: 'password', type: 'string', example: 'Test@123')
                ],
                type: 'object'
            )
        ),
        tags: ['User'],
        responses: [
            new OA\Response(
                response: 200,
                description: 'User logged in successfully',
                content: new OA\JsonContent(
                    properties: [
                        new OA\Property(property: 'email', type: 'string', example: 'exemple@email.com'),
                        new OA\Property(property: 'prenomUser', type: 'string', example: 'Prenom'),
                        new OA\Property(property: 'nomUser', type: 'string', example: 'Nom'),
                        new OA\Property(property: 'apiToken', type: 'string', example: '31a023e212f116124a36af14ea0c1c3806eb9378'),
                        new OA\Property(property: 'roles', type: 'array', items: new OA\Items(type: 'string', example: 'ROLE_EMPLOYE'))
                    ],
                    type: 'object'
                )
            ),
            new OA\Response(
                response: 401,
                description: 'Invalid credentials'
            )
        ]
    )]
    public function login(#[CurrentUser] ?User $user): JsonResponse
    {
        if (null === $user) {
            return new JsonResponse(['message' => 'Missing credentials'], Response::HTTP_UNAUTHORIZED);
        }

        return new JsonResponse(
            ['user' => $user->getUserIdentifier(), 'apiToken' => $user->getApiToken(), 'roles' => $user->getRoles()]
        );
    }
}

