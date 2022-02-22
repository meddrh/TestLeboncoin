<?php
namespace App\Service;
use App\Entity\Advert;
use Symfony\Component\HttpFoundation\Response;

class AdvertService
{

    /**
     * @var \Doctrine\ORM\EntityManagerInterface
     */
    private $entityManager;

    /**
     * @var \App\Repository\CategoryRepository
     */
    private $categoryRepository;

    /**
     * @var \App\Repository\CategoryRepository
     */
    private $model;


    public function __construct(
        \Doctrine\ORM\EntityManagerInterface $entityManager,
        \App\Repository\CategoryRepository $categoryRepository,
        \App\Repository\ModelRepository $model
     )
    {
        $this->entityManager = $entityManager;
        $this->categoryRepository = $categoryRepository;
        $this->model = $model;
     }

    public function getAdvert(Advert $advert): Response
    {
        $data = [
            'Title' => $advert->getTitle(),
            'Content' => $advert->getContent(),
            'Category' => $advert->getCategory()->getTitle(),
            'Model' => $advert->getModel() ? $advert->getModel()->getTitle(): null,
            'Brand' => $advert->getModel() ? $advert->getModel()->getBrand()->getTitle(): null,
        ];

        return new Response(json_encode($data)."\n", Response::HTTP_OK);
    }

    public function addAdvert(\Symfony\Component\HttpFoundation\Request $request): Response
    {
        $data = json_decode($request->getContent(), true);

        $category = $this->categoryRepository->findOneBy(['id' => $data['Category']]);
        $model = $this->model->findOneBy(['id' => array_key_exists("Model",$data) ? $data['Model'] : null]);

        if(!$model && $category->getTitle() === "Automobile"){
            return new Response("Votre modèle n'a pas été trouvé :(\n", Response::HTTP_NOT_FOUND);
        }

        $advert = new Advert();
        $advert->setTitle($data['Title']);
        $advert->setContent($data['Content']);
        $advert->setCategory($category);
        $advert->setModel($model);

        $this->entityManager->persist($advert);
        $this->entityManager->flush();

        return new Response("Votre annonce a été bien ajouté :)", Response::HTTP_CREATED);
    }

    public function updateAdvert(\Symfony\Component\HttpFoundation\Request $request, Advert $advert): Response
    {
        $data = json_decode($request->getContent(), true);
        $category = $this->categoryRepository->findOneBy(['id' => array_key_exists("Category",$data) ? $data['Category'] : $advert->getCategory()->getId()]);
        $model = $this->model->findOneBy(['id' => array_key_exists("Model",$data) ? (int)$data['Model'] : $advert->getModel()->getId()]);

        if(!$model && $category->getTitle() === "Automobile"){
            return new Response("Votre modèle n'a pas été trouvé :(\n", Response::HTTP_NOT_FOUND);
        }

        if ($advert) {

            $advert->setTitle(array_key_exists("Title",$data) ?  $data['Title'] : $advert->getTitle());
            $advert->setContent(array_key_exists("Content",$data) ? $data['Content'] : $advert->getContent());
            $advert->setCategory($category);
            $advert->setModel($model);

            $this->entityManager->persist($advert);
            $this->entityManager->flush();
        }

        return new Response("Votre annonce a été bien modifié :)", Response::HTTP_OK);
    }

    public function deleteAdvert(Advert $advert): Response
    {
        if ($advert) {
            $this->entityManager->remove($advert);
            $this->entityManager->flush();
        }

        return new Response("Votre annonce a été bien supprimé :)\n", Response::HTTP_NO_CONTENT);
    }

}