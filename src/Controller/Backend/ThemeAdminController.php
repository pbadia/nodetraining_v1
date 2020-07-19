<?php


namespace App\Controller\Backend;


use App\Entity\Theme;
use App\Form\ThemeType;
use App\Repository\ThemeRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ThemeAdminController extends AbstractController
{
    /**
     * @var ThemeRepository
     */
    private $repository;
    /**
     * @var EntityManagerInterface
     */
    private $em;

    /**
     * ThemeAdminController constructor.
     * @param ThemeRepository $repository
     * @param EntityManagerInterface $em
     */
    public function __construct(ThemeRepository $repository, EntityManagerInterface $em)
    {
        $this->repository = $repository;
        $this->em = $em;
    }

    /**
     * @Route("/admin/theme", name="admin.theme.index")
     * @return Response
     */
    public function index() : Response
    {
        $themes = $this->repository->findAll();
        return $this->render('admin/theme/index.html.twig', compact('themes'));
    }

    /**
     * @Route("/admin/theme/new", name="admin.theme.new")
     * @param Request $request
     * @return Response
     */
    public function new(Request $request) : Response
    {
        $theme = new Theme();

        $form = $this->createForm(ThemeType::class, $theme);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid())
        {
            $this->em->persist($theme);
            $this->em->flush();
            $this->addFlash('success', 'Thème ajouté avec succès');
            return $this->redirectToRoute('admin.theme.index');
        }

        return $this->render('admin/theme/new.html.twig', [
            'theme' => $theme,
            'form' => $form->createView()
        ]);
    }

    /**
     * @Route("/admin/theme/{id}", name="admin.theme.edit", methods="GET|POST")
     * @param Theme $theme
     * @param Request $request
     * @return Response
     */
    public function edit(Theme $theme, Request $request) : Response
    {
        $form = $this->createForm(ThemeType::class, $theme);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid())
        {
            $this->em->persist($theme);
            $this->em->flush();
            $this->addFlash('success', 'Thème modifié avec succès');
            return $this->redirectToRoute('admin.theme.index');
        }

        return $this->render('admin/theme/edit.html.twig', [
            'theme' => $theme,
            'form' => $form->createView()
        ]);
    }

    /**
     * @Route("admin/theme/{id}", name="admin.theme.delete", methods="DELETE")
     * @param Theme $theme
     * @param Request $request
     * @return Response
     */
    public function delete(Theme $theme, Request $request) : Response
    {
        if ($this->isCsrfTokenValid('delete' . $theme->getId(), $request->get('_token'))) {
            $this->em->remove($theme);
            $this->em->flush();
            $this->addFlash('success', 'Thème supprimé avec succès');
            return $this->redirectToRoute('admin.theme.index');
        }
    }
}