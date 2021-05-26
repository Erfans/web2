<?php
/**
 * codekunst GmbH <www.codekunst.com>
 * @author e <hello@codekunst.com>
 */

namespace App\Menu;

use App\Entity\BookStore;
use Doctrine\ORM\EntityManagerInterface;
use Knp\Menu\FactoryInterface;
use Knp\Menu\ItemInterface;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerAwareTrait;
use Symfony\Component\Security\Core\Security;

class Builder
{

    private EntityManagerInterface $entityManager;
    private FactoryInterface $factory;
    private Security $security;

    public function __construct(
        FactoryInterface $factory,
        EntityManagerInterface $entityManager,
        Security $security
    )
    {
        $this->entityManager = $entityManager;
        $this->factory = $factory;
        $this->security = $security;
    }

    public function mainMenu(array $options): ItemInterface
    {
        $menu = $this->factory->createItem('root');
        $menu->setChildrenAttribute('class', 'nav-item');

        $menu->addChild('Home', ['route' => 'home']);

        $bookStoreMenu = $menu->addChild('Bookstore', ['route' => 'book_store_index']);
//        $bookStoreMenu->setAttribute('class', 'dropdown-menu');
//        $bookStoreMenu->setChildrenAttribute('class', 'dropdown-item');

        /** @var BookStore[] $bookStores */
        $bookStores = $this->entityManager->getRepository(BookStore::class)->findAll();

        foreach ($bookStores as $bookStore) {
            $bookStoreMenu->addChild($bookStore->getName(), [
                'route' => 'book_store_show',
                'routeParameters' => ['id' => $bookStore->getId()]
            ]);
        }

        if (!$this->security->isGranted("IS_AUTHENTICATED_FULLY")) {
            $menu->addChild('Login', ['route' => 'app_login']);
            $menu->addChild('Register', ['route' => 'app_register']);
        } else {
            $menu->addChild('Logout', ['route' => 'app_logout']);
        }

        return $menu;
    }
}