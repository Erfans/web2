<?php

namespace App\EventSubscriber;

use App\Entity\Statistic;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpKernel\Event\ControllerEvent;

class ControllerSubscriber implements EventSubscriberInterface
{
    private EntityManagerInterface $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }


    public function onKernelController(ControllerEvent $event)
    {
        $url = $event->getRequest()->getPathInfo();

        if (str_starts_with($url, "/_wdt")) {
            return;
        }

        $repository = $this->entityManager->getRepository(Statistic::class);

        /** @var Statistic $statistic */
        $statistic = $repository->findOneBy(['url' => $url]);

        if ($statistic == null) {
            $statistic = new Statistic();
            $statistic->setUrl($url);
            $statistic->setNumberOfViews(1);

            $this->entityManager->persist($statistic);
        } else {
            $statistic->incrementNumberOfViews(1);
        }

        $this->entityManager->flush();
    }

    public static function getSubscribedEvents()
    {
        return [
            'kernel.controller' => 'onKernelController',
        ];
    }
}
