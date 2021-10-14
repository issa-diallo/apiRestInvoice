<?php

namespace App\Events;

use ApiPlatform\Core\EventListener\EventPriorities;
use App\Entity\Invoice;
use App\Repository\InvoiceRepository;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Event\ViewEvent;
use Symfony\Component\HttpKernel\KernelEvents;
use Symfony\Component\Security\Core\Security;

class InvoiceChronoSubscriber implements EventSubscriberInterface
{
  /**
   * @var Security
   */
  private $security;
  /**
   * @var InvoiceRepository
   */
  private $repository;

  public function __construct(Security $security,InvoiceRepository $repository)
  {
    $this->security = $security;
    $this->repository = $repository;
  }


  public static function getSubscribedEvents()
  {
    return [
      KernelEvents::VIEW => ['setNextChrono', EventPriorities::PRE_VALIDATE],
    ];
  }

  public function setNextChrono(ViewEvent $event): void
  {
    $invoice = $event->getControllerResult();
    $method = $event->getRequest()->getMethod();
    
    if ($invoice instanceof Invoice || Request::METHOD_POST === $method) {
      // Get user
      $user = $this->security->getUser();
    
      // Get repository invoices
      $repositoryInvoice = $this->repository;

      // Get the last chrono then add + 1
      $chrono = $repositoryInvoice->findNextChrono($user);

      // Add chrono
      $invoice->setChrono($chrono);
    }
  }
}