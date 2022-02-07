<?php

namespace App\Http\Admin\Controller;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class DashboardController extends BaseController
{
    #[Route('/', name: 'dashboard')]
    public function getDashboard(): Response
    {
        return $this->render('admin/index.html.twig');
    }
}
