<?php


namespace App\Controller;

use App\Service\QuizService;
use mysql_xdevapi\Exception;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Mailer\Exception\TransportExceptionInterface;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Email;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;

class ContactController extends AbstractController
{
    /**
     * @Route("/contact", name="contact")
     * @param Request $request
     * @param QuizService $quizService
     * @param MailerInterface $mailer
     * @return Response
     * @throws TransportExceptionInterface
     */
    public function contact(Request $request, QuizService $quizService, MailerInterface $mailer){

        $defaultData = ['message' => ''];
        $form = $this->createFormBuilder($defaultData)
            ->add('name', TextType::class)
            ->add('subject', TextType::class)
            ->add('email', EmailType::class)
            ->add('message', TextareaType::class)
            ->getForm();

        $form->handleRequest($request);

        // The form is submitted and valid
        if ($form->isSubmitted() && $form->isValid()) {
            $data = $form->getData();

            // Create the email
            $email = (new Email())
                ->from($data['email'])
                ->to('admin@nodeinfo.fr')
                ->priority(Email::PRIORITY_HIGH)
                ->subject($data['subject'])
                ->text($data['name'] . " : " . $data['message']);

            // Send the email
            $mailer->send($email);

            // Redirect to homepage
            $this->addFlash('success', 'Message envoyé avec succès');
            return $this->redirectToRoute('home');
        }

        return $this->render('contact/contact.html.twig', [
            'quizId' => $quizService->getQuizId(),
            'form' => $form->createView()
        ]);
    }
}