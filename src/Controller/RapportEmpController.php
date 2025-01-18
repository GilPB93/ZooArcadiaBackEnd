<?php

namespace App\Controller;

use App\Entity\Animal;
use App\Entity\User;
use App\Repository\RapportEmpRepository;
use App\Entity\RapportEmp;
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

#[Route('/api/rapportEmp', name: 'app_api_rapportEmp_')]
class RapportEmpController extends AbstractController
{
    public function __construct(
        private EntityManagerInterface $manager,
        private SerializerInterface $serializer,
        private RapportEmpRepository $repository,
        private UrlGeneratorInterface $urlGenerator
    ){
    }

    //CREATE RAPPORTEMP - POST
    #[Route(name: 'new', methods: ['POST'])]
    #[IsGranted('ROLE_USER')]
    #[OA\Post(
        path: '/api/rapportEmp',
        summary: 'Create a new Rapport Employé',
        requestBody: new OA\RequestBody(
            description: 'The new Rapport Employé',
            required: true,
            content: new OA\JsonContent(
                properties: [
                    new OA\Property(property: 'alimentationDonnee', type: 'string', example: 'foin, paille, granulés, ...'),
                    new OA\Property(property: 'quantiteDonnee', type: 'string', example: '2kg'),
                    new OA\Property(property: 'animalId', type: 'integer', example: 3),
                ],
                type: 'object'
            )
        ),
        tags: ['Rapport Employé'],
        responses: [
            new OA\Response(
                response: 201,
                description: 'Rapport Employé created',
                content: new OA\JsonContent(
                    properties: [
                        new OA\Property(property: 'id', type: 'integer', example: 1),
                        new OA\Property(property: 'alimentationDonnee', type: 'string', example: 'foin, paille, granulés, ...'),
                        new OA\Property(property: 'quantiteDonnee', type: 'string', example: '2kg'),
                        new OA\Property(property: 'createdAt', type: 'string', format: 'date-time', example: '2021-10-01T12:00:00+02:00'),
                        new OA\Property(property: 'createdBy', ref: 'User2', type: 'object'),
                        new OA\Property(property: 'animal', type: 'object', ref: 'Animal')
                    ],
                    type: 'object'
                )
            )
        ]
    )]
    public function new(Request $request, #[CurrentUser] ?User $user): JsonResponse
    {
        if (!$user) {
            return $this->json(['error' => 'Unauthorized'], Response::HTTP_UNAUTHORIZED);
        }

        $data = json_decode($request->getContent(), true);
        if (empty($data['alimentationDonnee']) || empty($data['quantiteDonnee']) || empty($data['animalId'])) {
            return $this->json(['error' => 'Veuillez remplir tous les champs'], Response::HTTP_BAD_REQUEST);
        }

        $animal = $this->manager->getRepository(Animal::class)->find($data['animalId']);
        if (!$animal) {
            return $this->json(['error' => 'Animal not found'], Response::HTTP_NOT_FOUND);
        }

        $rapportEmp = (new RapportEmp())
            ->setAlimentationDonnee($data['alimentationDonnee'])
            ->setQuantiteDonnee($data['quantiteDonnee'])
            ->setCreatedAt(new \DateTimeImmutable())
            ->setCreatedBy($user)
            ->setAnimal($animal);

        $this->manager->persist($rapportEmp);
        $this->manager->flush();

        return $this->json(
            $rapportEmp,
            Response::HTTP_CREATED,
            ['location' => $this->urlGenerator->generate('app_api_rapportEmp_read', ['id' => $rapportEmp->getId()])],
        );
    }



    //READ RAPPORTEMP - GET
    #[Route('/{id}', name: 'read', methods: ['GET'])]
    #[isGranted('ROLE_ADMIN, ROLE_VETERINAIRE')]
    #[OA\Get(
        path: '/api/rapportEmp/{id}',
        summary: 'Get a Rapport Employé by its ID',
        tags: ['Rapport Employé'],
        parameters: [
            new OA\Parameter(
                name: 'id',
                description: 'ID of the Rapport Employé to get',
                in: 'path',
                required: true,
                schema: new OA\Schema(type: 'integer')
            )
        ],
        responses: [
            new OA\Response(
                response: 200,
                description: 'Rapport Employé found',
                content: new OA\JsonContent(
                    properties: [
                        new OA\Property(property: 'id', type: 'integer', example: 1),
                        new OA\Property(property: 'alimentationDonnee', type: 'string', example: 'foin, paille, granulés, ...'),
                        new OA\Property(property: 'quantiteDonnee', type: 'string', example: '2kg'),
                        new OA\Property(property: 'createdAt', type: 'string', format: 'date-time', example: '2021-10-01T12:00:00+02:00'),
                        new OA\Property(property: 'createdBy', ref: 'User2', type: 'object'),
                        new OA\Property(property: 'animal', type: 'object', ref: 'Animal')
                    ],
                    type: 'object'
                )
            ),
            new OA\Response(
                response: 404,
                description: 'Rapport Employé not found'
            )
        ]
    )]
    public function read(int $id): JsonResponse
    {
        $rapportEmp = $this->repository->findOneBy(['id' => $id]);

        if (!$rapportEmp) {
            return new JsonResponse(null, Response::HTTP_NOT_FOUND);
        }

        return new JsonResponse(
            $this->serializer->serialize($rapportEmp, 'json'),
            Response::HTTP_OK,
            ['location' => $this->urlGenerator->generate('app_api_rapportEmp_read', ['id' => $rapportEmp->getId()])]
        );
    }
}
