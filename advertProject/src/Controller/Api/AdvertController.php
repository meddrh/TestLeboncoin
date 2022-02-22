<?php

namespace App\Controller\Api;

use App\Entity\Advert;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use OpenApi\Annotations as OA;

/**
 * @Route("/api")
 */
class AdvertController
{
    /**
     * @var \App\Repository\CategoryRepository
     */
    private $model;

    /**
     * @var \App\Service\AdvertService
     */
    private $advertService;

    public function __construct(\App\Repository\ModelRepository $model, \App\Service\AdvertService $advertService)
    {
        $this->model = $model;
        $this->advertService = $advertService;
    }

    /**
     * @Route("/advert/{id}", name="getOneAdvert", methods={"GET"})
     * @OA\Response(
     *     response=200,
     *     description="Returns the rewards of an model",
     * )
     */
    public function getOneAdvert(Advert $advert): Response
    {
        return $this->advertService->getAdvert($advert);
    }

    /**
     * @Route("/advert/{id}", methods={"Put", "PATCH"}, name="putAdvert")
     */
    public function putAdvert(\Symfony\Component\HttpFoundation\Request $request, Advert $advert): Response
    {
       return $this->advertService->updateAdvert($request,$advert);
    }

    /**
     * @Route("/advert", methods={"POST"}, name="postAdvert")
     */
    public function addAdvert(\Symfony\Component\HttpFoundation\Request $request): Response
    {
        return $this->advertService->addAdvert($request);
    }

    /**
     * @Route("/advert/{id}", methods={"DELETE"}, name="deleteAdvert")
     */
    public function deleteAdvert(Advert $advert): Response
    {
        return $this->advertService->deleteAdvert($advert);
    }

    /**
     * @Route("/advert/model/{name}", methods={"GET"}, name="model_search")
     */
    public function getModel(string $name): Response
    {
        $matchingModel  = $this->model->findMatchModel($name) ;

        return new Response($matchingModel[0]->getTitle(), Response::HTTP_OK);
    }
}