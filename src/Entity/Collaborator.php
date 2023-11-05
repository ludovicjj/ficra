<?php

namespace App\Entity;

use App\Repository\CollaboratorRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: CollaboratorRepository::class)]
class Collaborator extends User
{

}
