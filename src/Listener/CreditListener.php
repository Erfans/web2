<?php
/**
 * codekunst GmbH <www.codekunst.com>
 * @author e <hello@codekunst.com>
 */

namespace App\Listener;

use App\Entity\Order;
use App\Model\SalableInterface;
use Doctrine\Persistence\Event\LifecycleEventArgs;


class CreditListener
{
    public function postPersist(LifecycleEventArgs $args): void
    {
        $entity = $args->getObject();

        if (!$entity instanceof Order) {
            return;
        }

        $user = $entity->getUser();
        $credit = $user->getCredit();

        $product = $entity->getProduct();
        $priceWithTax = $product->getPriceWithTax();

        $user->setCredit($credit - $priceWithTax);

        $entityManager = $args->getObjectManager();
        $entityManager->flush();
    }

}