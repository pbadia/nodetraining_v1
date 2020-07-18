<?php


namespace App\Controller\Backend;


use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class AdminController
 * @package App\Controller\Backend
 * @IsGranted("ROLE_ADMIN")
 */
class AdminController extends AbstractController
{

    /**
     * @Route("/admin", name="admin.index")
     * @return Response
     */
    public function index() : Response
    {
        return $this->render('admin/index.html.twig');
    }

}