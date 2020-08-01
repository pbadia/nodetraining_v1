<?php

namespace App\Security\Voter;

use App\Entity\Quiz;
use App\Entity\User;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Authorization\Voter\Voter;
use Symfony\Component\Security\Core\Security;
use Symfony\Component\Security\Core\User\UserInterface;

class QuizVoter extends Voter
{
    /**
     * @var Security
     */
    private $security;

    public function __construct(Security $security)
    {
        $this->security = $security;
    }

    protected function supports($attribute, $subject)
    {
        return in_array($attribute, ['QUIZ_VIEW'])
            && $subject instanceof Quiz;
    }

    protected function voteOnAttribute($attribute, $subject, TokenInterface $token)
    {
        $user = $token->getUser();
        // if the user is anonymous, do not grant access
        if (!$user instanceof UserInterface) {
            return false;
        }

        $quiz = $subject;

        switch ($attribute) {
            // A user can access a quiz
            case 'QUIZ_VIEW':
                // If he is the owner
                if ($this->canView($quiz, $user)){
                    return true;
                }
                // Or if he has the admin role
            if ($this->security->isGranted('ROLE_ADMIN')){
                return true;
            }

            // Otherwise, the user can't access the quiz
            return false;
        }

        return false;
    }

    private function canView(Quiz $quiz, User $user)
    {
        return $user === $quiz->getUser();
    }
}
