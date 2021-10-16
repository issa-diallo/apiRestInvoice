<?php
/**
 * https://api-platform.com/docs/v2.5/core/extensions/
 */
namespace App\Doctrine;

use ApiPlatform\Core\Bridge\Doctrine\Orm\Extension\QueryCollectionExtensionInterface;
use ApiPlatform\Core\Bridge\Doctrine\Orm\Extension\QueryItemExtensionInterface;
use ApiPlatform\Core\Bridge\Doctrine\Orm\Util\QueryNameGeneratorInterface;
use App\Entity\Customer;
use App\Entity\Invoice;
use App\Entity\User;
use Doctrine\ORM\QueryBuilder;
use Symfony\Component\Security\Core\Authorization\AuthorizationCheckerInterface;
use Symfony\Component\Security\Core\Security;

/**
 * Intervene on doctrine so that each request is filtered only for the connected user
 */
final class CurrentUserExtension implements QueryCollectionExtensionInterface, QueryItemExtensionInterface
{
  /**
   * @var Security
   */
  private $security;

  /**
   * @var AuthorizationCheckerInterface
   */
  private $checker;

  public function __construct(Security $security,AuthorizationCheckerInterface $checker)
  {
      $this->security = $security;
      $this->checker = $checker;
  }

  public function applyToCollection(QueryBuilder $queryBuilder, QueryNameGeneratorInterface $queryNameGenerator, string $resourceClass, string $operationName = null): void
  {
      $this->addWhere($queryBuilder, $resourceClass);
  }

  public function applyToItem(QueryBuilder $queryBuilder, QueryNameGeneratorInterface $queryNameGenerator, string $resourceClass, array $identifiers, string $operationName = null, array $context = []): void
  {
      $this->addWhere($queryBuilder, $resourceClass);
  }

  private function addWhere(QueryBuilder $queryBuilder, string $resourceClass): void
  {
    /**
     * Get user connected
     * @var User
     */
    $user = $this->security->getUser();

      /**
       * filtered only for the connected user
       */
      if ((Customer::class === $resourceClass || Invoice::class === $resourceClass) && !$this->checker->isGranted('ROLE_ADMIN') ) {
        $rootAlias = $queryBuilder->getRootAliases()[0];

        if (Customer::class === $resourceClass) {
          $queryBuilder->andWhere(sprintf('%s.user = :user', $rootAlias));
          
        } elseif (Invoice::class === $resourceClass) {
          $queryBuilder->join(sprintf('%s.customer',$rootAlias),'c')
                        ->andWhere('c.user = :user');
        } 
        $queryBuilder->setParameter('user', $user);
      }

  }
}