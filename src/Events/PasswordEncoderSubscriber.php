<?php 

namespace App\Events;

use ApiPlatform\Core\EventListener\EventPriorities;
use App\Entity\User;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Event\ViewEvent;
use Symfony\Component\HttpKernel\KernelEvents;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class PasswordEncoderSubscriber implements EventSubscriberInterface
{
  /**
   * @var UserPasswordHasherInterface
   */
  private $encoder;

  public function __construct(UserPasswordHasherInterface $encoder)
  {
    $this->encoder = $encoder;
  }


  public static function getSubscribedEvents()
  {
    // return the subscribed events, their methods and priorities
    return [
      KernelEvents::VIEW => [
        'encodePassword', EventPriorities::PRE_WRITE,
      ]
    ];
  }

  public function encodePassword(ViewEvent $event): void
  {
    $user = $event->getControllerResult();
    $method = $event->getRequest()->getMethod();
    
    if ($user instanceof User && Request::METHOD_POST === $method) {
      // Hashes a plain password
      $hash = $this->encoder->hashPassword($user,$user->getPassword());
      $user = $user->setPassword($hash);
    }
  }
}
