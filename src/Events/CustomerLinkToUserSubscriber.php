<?php 

namespace App\Events;

use ApiPlatform\Core\EventListener\EventPriorities;
use App\Entity\Customer;
use App\Entity\User;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Event\ViewEvent;
use Symfony\Component\HttpKernel\KernelEvents;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Security\Core\Security;

class CustomerLinkToUserSubscriber implements EventSubscriberInterface
{
  private $security;

  public function __construct(Security $security)
  {
    $this->security = $security;
  }

  


  public static function getSubscribedEvents()
  {
    // return the subscribed events, their methods and priorities
    return [
      KernelEvents::VIEW => [
        'customerToUser', EventPriorities::PRE_VALIDATE,
      ]
    ];
  }
public function customerToUser(ViewEvent $event): void
{
  $customer = $event->getControllerResult();
  $method = $event->getRequest()->getMethod();

  if($customer instanceof Customer && Request::METHOD_POST === $method)
  {
    // Get user currently connect
    $user = $this->security->getUser();

    // Add user to customer created
    $customer = $customer->setUser($user);
  }
}
  
}
