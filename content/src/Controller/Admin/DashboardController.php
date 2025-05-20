<?php

namespace App\Controller\Admin;

use EasyCorp\Bundle\EasyAdminBundle\Attribute\AdminDashboard;
use EasyCorp\Bundle\EasyAdminBundle\Config\Dashboard;
use EasyCorp\Bundle\EasyAdminBundle\Config\MenuItem;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractDashboardController;
use EasyCorp\Bundle\EasyAdminBundle\Router\AdminUrlGenerator;

use Symfony\Component\HttpFoundation\Response;

use App\Entity\User;
use App\Entity\Product;
use App\Entity\Review;

#[AdminDashboard(routePath: '/admin', routeName: 'admin')]
class DashboardController extends AbstractDashboardController
{
    public function index(): Response
    {
        // return parent::index();

        $routeBuilder = $this->container->get(AdminUrlGenerator::class);
        $url = $routeBuilder->setController(ProductCrudController::class)->generateUrl();

        return $this->redirect($url);
    }

    public function configureDashboard(): Dashboard
    {
        return Dashboard::new()
            ->setTitle('Админ-панель');
    }

    public function configureMenuItems(): iterable
    {
        yield MenuItem::linktoRoute('Вернуться на главную', 'fas fa-home', 'home');
        yield MenuItem::linkToCrud('Пользователи', 'fas fa-user', User::class);
        yield MenuItem::linkToCrud('Товары', 'fas fa-shopping-cart', Product::class);
        yield MenuItem::linkToCrud('Обзоры', 'fas fa-comments', Review::class);
    }
}
