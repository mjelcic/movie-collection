<?php

namespace App\EventListener;

use App\Entity\Movie;
use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\Event\LifecycleEventArgs;
use Symfony\Component\Mailer\Exception\TransportExceptionInterface;
use Symfony\Component\Mailer\Mailer;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Email;

class MovieAddedListener
{
    private $entityManager;
    private $mailer;
    /**
     * MovieAddedListener constructor.
     * @param EntityManagerInterface $entityManager
     * @param MailerInterface $mailer
     */
    public function __construct(EntityManagerInterface $entityManager, MailerInterface $mailer)
    {
        $this->entityManager = $entityManager;
        $this->mailer = $mailer;
    }

    public function postUpdate(Movie $movie, LifecycleEventArgs $event): void
    {
        /** @var User $user */
        $user = $this->entityManager->getRepository(User::class)->find($movie->getCreatedBy());

        $email = (new Email())
            ->from('tester.testerovic333@gmail.com')
            ->to($user->getEmail())
            ->subject('New movie added')
            ->text('Movie: ' . $movie->getName() . " added to database.");

        try {
            $this->mailer->send($email);
        } catch (TransportExceptionInterface $e) {
        }
    }
}