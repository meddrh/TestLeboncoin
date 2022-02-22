<?php

namespace App\DataFixtures;

use App\Entity\Advert;
use App\Entity\Brand;
use App\Entity\Category;
use App\Entity\Model;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        // create Categories
        $auto = new Category();
        $auto->setTitle('Automobile');
        $manager->persist($auto);

        $immo = new Category();
        $immo->setTitle('Immobilier');
        $manager->persist($immo);

        $emp = new Category();
        $emp->setTitle('Emploi');
        $manager->persist($emp);
        $manager->flush();

        // create brands
        $bmwBrand = new Brand();
        $bmwBrand->setTitle('BMW');
        $manager->persist($bmwBrand);

        $audiBrand = new Brand();
        $audiBrand->setTitle('AUDI');
        $manager->persist($audiBrand);

        $citroenBrand = new Brand();
        $citroenBrand->setTitle('CITROEN');
        $manager->persist($citroenBrand);

        $manager->flush();

        // create models! Bam!
        $audiModels = 'Cabriolet,Q2,Q3,Q5,Q7,Q8,R8,Rs3,Rs4,Rs5,Rs7,S3,S4,S4 Avant,S4 Cabriolet,S5,S7,S8,SQ5,SQ7,Tt,Tts,V8';
        $bmwModels = 'M3,M4,M5,M535,M6,M635,Serie 1,Serie 2,Serie 3,Serie 4,Serie 5,Serie 6,Serie 7,Serie 8';
        $citroenModels = 'C1,C15,C2,C25,C25D,C25E,C25TD,C3,C3 Aircross,C3 Picasso,C4,C4 Picasso,C5,C6,C8,Ds3,Ds4,Ds5';

        $audiModelsArray = explode(",",$audiModels);
        $bmwModelsArray = explode(",",$bmwModels);
        $citroenModelsArray = explode(",",$citroenModels);

        // create models! Bam!
        for ($i = 0; $i < count($audiModelsArray); $i++) {
            $audi = new Model();
            $audi->setTitle($audiModelsArray[$i]);
            $audi->setBrand($audiBrand);
            $manager->persist($audi);
        }

        for ($i = 0; $i < count($bmwModelsArray); $i++) {
            $bmw = new Model();
            $bmw->setTitle($bmwModelsArray[$i]);
            $bmw->setBrand($bmwBrand);
            $manager->persist($bmw);
        }

        for ($i = 0; $i < count($citroenModelsArray); $i++) {
            $citroen = new Model();
            $citroen->setTitle($citroenModelsArray[$i]);
            $citroen->setBrand($citroenBrand);
            $manager->persist($citroen);
        }

        $advert = new Advert();
        $advert->setTitle('Audi a vendre');
        $advert->setContent(' laoreet mauris vulputate sed. Quisque luctus posuere pellentesque. Ut in sem congue, venenatis eros non, feugiat nisi.');
        $advert->setCategory($auto);
        $advert->setModel($citroen);

        $manager->persist($advert);
        $manager->flush();
    }
}
