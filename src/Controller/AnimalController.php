<?php

namespace App\Controller;

use App\Entity\Animal;
use App\Entity\Habitat;
use App\Entity\RaceAnimal;
use App\Repository\AnimalRepository;
use App\Security\Roles;
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
    #[IsGranted(Roles::ROLE_ADMIN)]
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
                    new OA\Property(property: 'raceAnimal', type: 'array',
                        items: new OA\Items(
                            properties: [
                                new OA\Property(property: 'raceLabel', type: 'string', example: "Race Test")
                            ],
                            type: 'object'
                        )
                    ),
                    new OA\Property(property: 'habitat', properties: [
                        new OA\Property(property: 'habitatName', type: 'string', example: "Nom de l'habitat test")
                    ],
                        type: 'object'
                    )
                ],
                type: 'object'
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
                        new OA\Property(property: 'raceAnimal', type: 'array',
                            items: new OA\Items(
                                properties: [
                                    new OA\Property(property: 'id', type: 'integer', example: 1),
                                    new OA\Property(property: 'raceLabel', type: 'string', example: "Race Test")
                                ],
                                type: 'object'
                            )
                        ),
                        new OA\Property(property: 'habitat', properties: [
                            new OA\Property(property: 'id', type: 'integer', example: 1),
                            new OA\Property(property: 'habitatName', type: 'string', example: "Nom de l'habitat test")
                        ],
                            type: 'object'
                        )
                    ],
                    type: 'object'
                )
            )
        ]
    )]
    public function new(Request $request): JsonResponse
    {
        $data = json_decode($request->getContent(), true);

        // Vérification de la raceAnimal
        if (isset($data['raceAnimal']) && is_array($data['raceAnimal'])) {
            foreach ($data['raceAnimal'] as $race) {
                if (!isset($race['raceLabel'])) {
                    return new JsonResponse(['error' => 'raceLabel manquant dans raceAnimal'], 400);
                }

                // Recherche de la race par raceLabel (vous pouvez ajuster selon vos besoins)
                $existingRace = $this->manager->getRepository(RaceAnimal::class)->findOneBy(['raceLabel' => $race['raceLabel']]);
                if (!$existingRace) {
                    return new JsonResponse(['error' => 'Race non trouvée'], 400);
                }
            }
        }

        // Vérification de l'habitat
        if (isset($data['habitat']) && is_array($data['habitat']) && count($data['habitat']) === 1) {
            $habitatData = $data['habitat'];  // On prend le premier habitat
            if (!isset($habitatData['habitatName'])) {
                return new JsonResponse(['error' => 'habitatName manquant dans habitat'], 400);
            }

            // Recherche de l'habitat par habitatName
            $existingHabitat = $this->manager->getRepository(Habitat::class)->findOneBy(['habitatName' => $habitatData['habitatName']]);
            if (!$existingHabitat) {
                return new JsonResponse(['error' => 'Habitat non trouvé'], 400);
            }
        } else {
            return new JsonResponse(['error' => 'Données habitat invalides'], 400);
        }

        // Créer un nouvel animal
        $animal = new Animal();
        $this->serializer->deserialize($request->getContent(), Animal::class, 'json', ['object_to_populate' => $animal]);

        // Associer la race et l'habitat à l'animal
        if (isset($data['raceAnimal']) && is_array($data['raceAnimal']) && count($data['raceAnimal']) > 0) {
            $race = $this->manager->getRepository(RaceAnimal::class)->findOneBy(['raceLabel' => $data['raceAnimal'][0]['raceLabel']]);
            if (!$race) {
                return new JsonResponse(['error' => 'Race non trouvée'], 400);
            }
            $animal->setRaceAnimal($race);
        }

        // Association de l'habitat à l'animal
        if (isset($existingHabitat)) {
            $animal->setHabitat($existingHabitat);
        }

        // Persist et flush l'entité animal
        $this->manager->persist($animal);
        $this->manager->flush();

        return new JsonResponse($this->serializer->serialize($animal, 'json', ['groups' => ['animal:read']]), Response::HTTP_CREATED, [], true);
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
                        new OA\Property(property: 'raceAnimal', type: 'array', items: new OA\Items(type: 'object', example: ["id" => 1, "raceLabel" => "Race animal Test"])),
                        new OA\Property(property: 'habitat', type: 'array', items: new OA\Items(type: 'object', example: ["id" => 1, "habitatName" => "Savanna"]))
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
