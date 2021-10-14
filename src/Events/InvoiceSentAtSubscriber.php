<?php

namespace App\Events;

use ApiPlatform\Core\EventListener\EventPriorities;
use App\Entity\Invoice;
use DateTime;
use PhpParser\Node\Expr\Empty_;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Event\ViewEvent;
use Symfony\Component\HttpKernel\KernelEvents;

class InvoiceSentAtSubscriber implements EventSubscriberInterface
{
  public static function getSubscribedEvents()
  {
    return [
      KernelEvents::VIEW => ['setSentAtInvoice', EventPriorities::PRE_VALIDATE]
    ];
  }

  public function setSentAtInvoice(ViewEvent $event): void
  {
    $invoice = $event->getControllerResult();
    $method = $event->getRequest()->getMethod();

    if ($invoice instanceof Invoice || Request::METHOD_POST === $method)
    {
      if(empty($invoice->getSentAt()))
      {
        $invoice->setSentAt(new DateTime());
      }
    }
  }

}
