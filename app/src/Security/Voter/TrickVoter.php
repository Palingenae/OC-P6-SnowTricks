<?php

namespace App\Security\Voter;

use App\Entity\Trick;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Authorization\Voter\Voter;
use Symfony\Component\Security\Core\User\UserInterface;

class TrickVoter extends Voter
{
    const UPDATE = 'update';
    const DELETION = 'delete';

    protected function supports(string $attribute, $subject): bool
    {
        return in_array($attribute, [self::UPDATE, self::DELETION])
            && $subject instanceof Trick;
    }

    protected function voteOnAttribute(string $attribute, $subject, TokenInterface $token): bool
    {
        /** @var Trick $subject */
        $user = $token->getUser();
        if (!$user instanceof UserInterface) {
            return false;
        }

        switch ($attribute) {
            case self::UPDATE:
                // logic to determine if the user can EDIT
                // return true or false
                break;
            case self::DELETION:
                if($subject->getAuthor() == $user) {
                    return true;
                }
                break;
        }

        return false;
    }
}
