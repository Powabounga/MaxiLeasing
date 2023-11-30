<?php

namespace App\DataFixtures;

use App\Entity\Images;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\Finder\Finder;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;


class ImagesFixtures extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $entityManager)
    {
        $finder = new Finder();
        $finder->files()->in(__DIR__ . '/../../public/assets/uploads/');

        foreach ($finder as $file) {
            $image = new Images();
            $image->setName($file->getRelativePathname());
            $image->setProducts($this->getReference('product_' . rand(1, 600)));
            $entityManager->persist($image);
        }

        $entityManager->flush();
    }

    public function getDependencies()
    {
        return [
            ProductsFixtures::class,
        ];
    }
}
