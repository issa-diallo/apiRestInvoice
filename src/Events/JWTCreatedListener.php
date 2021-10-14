<?php
/**
 * https://github.com/lexik/LexikJWTAuthenticationBundle/blob/master/Resources/doc/2-data-customization.md#eventsjwt_created---adding-custom-data-or-headers-to-the-jwt
 * https://jwt.io/
 */
namespace App\Events;

use App\Entity\User;
use Lexik\Bundle\JWTAuthenticationBundle\Event\JWTCreatedEvent;

class JWTCreatedListener
{
  /**
   * @param JWTCreatedEvent $event
   *
   * @return void
   */
  public function onJWTCreated(JWTCreatedEvent $event)
  {
    // Get user
    /**
     * @var User
     */
    $user = $event->getUser();

    // Adding the data
    $data = $event->getData();

    $data["firstname"] = $user->getFirstname();
    $data["lastname"] = $user->getLastname();

    $event->setData($data);
  }
}