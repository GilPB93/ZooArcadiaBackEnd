<?php

namespace App\Controller;

use App\Entity\ZooContact;
use Doctrine\ORM\EntityManagerInterface;
use OpenApi\Attributes as OA;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Mailer\Exception\TransportExceptionInterface;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Email;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/api/contact', name: 'app_api_contact')]
class ZooContactController extends AbstractController
{
    /**
     * @throws TransportExceptionInterface
     */
    #[Route('/send', name: 'app_api_contact_send', methods: ['POST'])]
    #[OA\Post(
        path: '/api/contact/send',
        summary: 'Send contact information to the zoo.',
        requestBody: new OA\RequestBody(
            description: 'Contact information to send to the zoo.',
            required: true,
            content: new OA\JsonContent(
                properties: [
                    new OA\Property(property: 'contactName', type: 'string', description: 'The name of the contact'),
                    new OA\Property(property: 'contactEmail', type: 'string', description: 'The email of the contact'),
                    new OA\Property(property: 'contactTitle', type: 'string', description: 'The title of the message'),
                    new OA\Property(property: 'contactMessage', type: 'string', description: 'The message content'),
                ],
                type: 'object'
            )
        ),
        tags: ['Contact'],
        responses: [
            new OA\Response(
                response: 200,
                description: 'Contact information sent successfully.',
                content: new OA\JsonContent(
                    properties: [
                        new OA\Property(property: 'message', type: 'string', example: 'Contact information sent successfully.')
                    ],
                    type: 'object'
                )
            ),
            new OA\Response(
                response: 400,
                description: 'Invalid input data.',
                content: new OA\JsonContent(
                    properties: [
                        new OA\Property(property: 'error', type: 'string', example: 'Invalid contact data.')
                    ],
                    type: 'object'
                )
            )
        ]
    )]
    public function send(Request $request, MailerInterface $mailer, EntityManagerInterface $manager): JsonResponse
    {
        $data = json_decode($request->getContent(), true);

        // Validate required fields
        if (empty($data['contactName']) || empty($data['contactEmail']) || empty($data['contactTitle']) || empty($data['contactMessage'])) {
            return new JsonResponse(['error' => 'All fields are required.'], Response::HTTP_BAD_REQUEST);
        }

        // Create and save contact entity
        $contact = new ZooContact();
        $contact->setContactName($data['contactName'])
            ->setContactEmail($data['contactEmail'])
            ->setContactTitle($data['contactTitle'])
            ->setContactMessage($data['contactMessage'])
            ->setCreatedAt(new \DateTimeImmutable()); // Added setCreatedAt

        $manager->persist($contact);
        $manager->flush();

        // Send email
        $email = (new Email())
            ->from($contact->getContactEmail())
            ->to('gilpb.tech@hotmail.com')
            ->subject($contact->getContactTitle())
            ->text($contact->getContactMessage());

        $mailer->send($email);

        return new JsonResponse(['message' => 'Contact information sent successfully.'], Response::HTTP_OK);
    }
}
