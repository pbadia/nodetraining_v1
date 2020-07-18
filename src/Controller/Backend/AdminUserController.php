<?php


namespace App\Controller\Backend;


use App\Entity\User;
use App\Form\UserType;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class AdminUserController
 * @package App\Controller\Backend
 * @IsGranted("ROLE_ADMIN")
 */
class AdminUserController extends AbstractController
{
    /**
     * @var UserRepository
     */
    private $repository;
    /**
     * @var EntityManagerInterface
     */
    private $em;

    /**
     * AdminUserController constructor.
     * @param UserRepository $repository
     * @param EntityManagerInterface $em
     */
    public function __construct(UserRepository $repository, EntityManagerInterface $em)
    {
        $this->repository = $repository;
        $this->em = $em;
    }

    /**
     * @Route("admin/user", name="admin.user.index")
     * @return Response
     */
    public function index() : Response
    {
        $users = $this->repository->findAll();
        return $this->render('admin/user/index.html.twig', compact('users'));
    }

    /**
     * @Route("admin/user/new", name="admin.user.new")
     * @param Request $request
     * @return Response
     */
    public function new(Request $request) : Response
    {
        $user = new User();

        $form = $this->createForm(UserType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->em->persist($user);
            $this->em->flush();
            $this->addFlash('success', 'Utilisateur ajouté avec succès');
            return $this->redirectToRoute('admin.user.index');
        }

        return $this->render('admin/user/new.html.twig', [
            'user' => $user,
            'form' => $form->createView()
        ]);
    }

    /**
     * @Route("admin/user/{id}", name="admin.user.edit", methods="GET|POST")
     * @param User $user
     * @param Request $request
     * @return Response
     */
    public function edit(User $user, Request $request) : Response
    {
        $form = $this->createForm(UserType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->em->persist($user);
            $this->em->flush();
            $this->addFlash('success', 'Utilisateur ajouté avec succès');
            return $this->redirectToRoute('admin.user.index');
        }

        return $this->render('admin/user/new.html.twig', [
            'user' => $user,
            'form' => $form->createView()
        ]);
    }

    /**
     * @Route("admin/user/{id}", name="admin.user.delete", methods="DELETE")
     * @param User $user
     * @param Request $request
     * @return Response
     */
    public function delete(User $user, Request $request) : Response
    {
        if ($this->isCsrfTokenValid('delete' . $user->getId(), $request->get('_token'))) {
            $this->em->remove($user);
            $this->em->flush();
            $this->addFlash('success', 'Utilisateur supprimé avec succès');
            return $this->redirectToRoute('admin.user.index');
        }
    }
}