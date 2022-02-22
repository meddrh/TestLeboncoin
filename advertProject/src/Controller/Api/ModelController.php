<?php

namespace App\Controller\Api;;

use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ModelController extends AbstractController
{

    /**
     * @var \App\Repository\CategoryRepository
     */
    private $model;
    private $entityManager;


    public function __construct(
        \App\Repository\ModelRepository $model,
        EntityManagerInterface $entityManager
    )
    {
        $this->model = $model;
        $this->entityManager = $entityManager;
    }

}
