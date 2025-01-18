<?php

namespace App\Controller;

use App\Entity\ZooAvis;
use App\Repository\ZooAvisRepository;
use Doctrine\ORM\EntityManagerInterface;
use OpenApi\Attributes as OA;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;
use Symfony\Component\Serializer\SerializerInterface;



#[Route('/api/avis', name: 'app_api_avis_')]
class ZooAvisController extends AbstractController
{
    public function __construct(
        private EntityManagerInterface $manager,
        private SerializerInterface $serializer,
        private ZooAvisRepository $repository,
    ){
    }

    //CREATE AVIS
    #[Route(name: 'new', methods: ['POST'])]
    #[OA\Post(
        path: '/api/avis',
        summary: 'Create a new avis',
        requestBody: new OA\RequestBody(
            description: 'Avis data to create',
            required: true,
            content: new OA\JsonContent(
                properties: [
                    new OA\Property(property: 'avisName', type: 'string', example: 'Nom de l\'auteur'),
                    new OA\Property(property: 'avisEmail', type: 'string', example: 'exemple@email.com'),
                    new OA\Property(property: 'avisTitre', type: 'string', example: 'Titre exemple'),
                    new OA\Property(property: 'avisMessage', type: 'text', example: 'Contenu de l\'avis'),
                ],
                type: 'object'
            )
        ),
        tags: ['Avis'],
        responses: [
            new OA\Response(
                response: 201,
                description: 'Avis created successfully',
                content: new OA\JsonContent(
                    properties: [
                        new OA\Property(property: 'id', type: 'integer', example: 1),
                        new OA\Property(property: 'avisName', type: 'string', example: 'Nom de l\'auteur'),
                        new OA\Property(property: 'avisEmail', type: 'string', example: 'exemple@email.com'),
                        new OA\Property(property: 'avisTitre', type: 'string', example: 'Titre exemple'),
                        new OA\Property(property: 'avisMessage', type: 'text', example: 'Contenu de l\'avis'),
                        new OA\Property(property: 'createdAt', type: 'string', example: '2021-10-01T00:00:00+00:00'),
                    ],
                    type: 'object'
                )
            )
        ]
    )]
    public function new(Request $request): JsonResponse
    {
        $avis = $this->serializer->deserialize($request->getContent(), ZooAvis::class, 'json');
        $avis->setcreatedAt(new \DateTimeImmutable());

        $this->manager->persist($avis);
        $this->manager->flush();

        return $this->json($avis, Response::HTTP_CREATED);
    }

    //READ AVIS
    #[Route('/{id}', name: 'show', methods: ['GET'])]
    #[isGranted('ROLE_USER')]
    #[OA\Get(
        path: '/api/avis/{id}',
        summary: 'Get a specific avis',
        tags: ['Avis'],
        responses: [
            new OA\Response(
                response: 200,
                description: 'Avis found',
                content: new OA\JsonContent(
                    properties: [
                        new OA\Property(property: 'id', type: 'integer', example: 1),
                        new OA\Property(property: 'avisName', type: 'string', example: 'Nom de l\'auteur'),
                        new OA\Property(property: 'avisEmail', type: 'string', example: 'exemple@email.com'),
                        new OA\Property(property: 'avisTitre', type: 'string', example: 'Titre exemple'),
                        new OA\Property(property: 'avisMessage', type: 'text', example: 'Contenu de l\'avis'),
                        new OA\Property(property: 'createdAt', type: 'string', example: '2021-10-01T00:00:00+00:00'),
                    ],
                    type: 'object'
                )
            ),
            new OA\Response(
                response: 404,
                description: 'Avis not found'
            )]
    )]
    public function show(int $id): JsonResponse
    {
        $avis = $this->repository->findOneBy(['id' => $id]);
        if ($avis) {
            return new JsonResponse(
                $this->serializer->serialize($avis, 'json'),
                Response::HTTP_OK,
                [],
                true
            );
        }
        return new JsonResponse(null, Response::HTTP_NOT_FOUND);
    }

    //VALIDATE AVIS
    #[Route('/{id}/validate', name: 'validate', methods: ['PATCH'])]
    #[isGranted('ROLE_USER')]
    #[OA\Patch(
        path: '/api/avis/{id}/validate',
        summary: 'Validate a specific avis',
        tags: ['Avis'],
        responses: [
            new OA\Response(
                response: 200,
                description: 'Avis validated successfully',
                content: new OA\JsonContent(
                    properties: [
                        new OA\Property(property: 'id', type: 'integer', example: 1),
                        new OA\Property(property: 'avisName', type: 'string', example: 'Nom de l\'auteur'),
                        new OA\Property(property: 'avisEmail', type: 'string', example: 'exemple@email.com'),
                        new OA\Property(property: 'avisTitre', type: 'string', example: 'Titre exemple'),
                        new OA\Property(property: 'avisMessage', type: 'text', example: 'Contenu de l\'avis'),
                        new OA\Property(property: 'createdAt', type: 'string', example: '2021-10-01T00:00:00+00:00'),
                        new OA\Property(property: 'validated', type: 'boolean', example: true),
                    ],
                    type: 'object'
                )
            ),
            new OA\Response(
                response: 404,
                description: 'Avis not found'
            )]
    )]
    public function validate(int $id): JsonResponse
    {
        $avis = $this->repository->findOneBy(['id' => $id]);
        if ($avis) {
            $avis->setValidated(true);
            $this->manager->flush();
            return new JsonResponse(
                $this->serializer->serialize($avis, 'json'),
                Response::HTTP_OK,
                [],
                true
            );
        }
        return new JsonResponse(null, Response::HTTP_NOT_FOUND);
    }

    //INVALIDATE AVIS
    #[Route('/{id}/invalidate', name: 'invalidate', methods: ['PATCH'])]
    #[isGranted('ROLE_USER')]
    #[OA\Patch(
        path: '/api/avis/{id}/invalidate',
        summary: 'Invalidate a specific avis',
        tags: ['Avis'],
        responses: [
            new OA\Response(
                response: 200,
                description: 'Avis invalidated successfully',
                content: new OA\JsonContent(
                    properties: [
                        new OA\Property(property: 'id', type: 'integer', example: 1),
                        new OA\Property(property: 'avisName', type: 'string', example: 'Nom de l\'auteur'),
                        new OA\Property(property: 'avisEmail', type: 'string', example: 'exemple@email.com'),
                        new OA\Property(property: 'avisTitre', type: 'string', example: 'Titre exemple'),
                        new OA\Property(property: 'avisMessage', type: 'text', example: 'Contenu de l\'avis'),
                        new OA\Property(property: 'createdAt', type: 'string', example: '2021-10-01T00:00:00+00:00'),
                        new OA\Property(property: 'validated', type: 'boolean', example: false),
                    ],
                    type: 'object'
                )
            ),
            new OA\Response(
                response: 404,
                description: 'Avis not found'
            )]
    )]
    public function invalidate(int $id): JsonResponse
    {
        $avis = $this->repository->findOneBy(['id' => $id]);
        if ($avis) {
            $avis->setValidated(false);
            $this->manager->flush();
            return new JsonResponse(
                $this->serializer->serialize($avis, 'json'),
                Response::HTTP_OK,
                [],
                true
            );
        }
        return new JsonResponse(null, Response::HTTP_NOT_FOUND);
    }

}