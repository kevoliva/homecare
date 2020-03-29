<?php

namespace App\Security\Voter;

use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Authorization\Voter\Voter;
use Symfony\Component\Security\Core\User\UserInterface;
use App\Repository\ProfessionnelRepository;
use App\Entity\Professionnel;

class BienVoter extends Voter
{
  protected function supports($attribute, $subject)
  {
    // replace with your own logic
    // https://symfony.com/doc/current/security/voters.html
    return in_array($attribute, ['VIEW', 'VIEW_PRO'])
    && $subject instanceof \App\Entity\Bien;
  }

  protected function voteOnAttribute($attribute, $subject, TokenInterface $token)
  {
    $user = $token->getUser();
    // if the user is anonymous, do not grant access
    if (!$user instanceof UserInterface) {
      return false;
    }

    // ... (check conditions and return true to grant permission) ...
    switch ($attribute) {

      case 'VIEW':
      return $subject->getProprietaire()->getUsername() == $user->getUsername();
      break;

      case 'VIEW_PRO':
      $autorisations = $subject->getAutorisations();
      foreach ($autorisations->toArray() as $autorisation) {
        if($user->getUsername() == $autorisation->getProfessionnel()->getUsername()){
          // Si une autorisation est trouvée dans la collection
          return true;
        }
      }
      // Si aucune autorisation n'est trouvée
      return false;
      break;
    }

    return false;
  }
}
