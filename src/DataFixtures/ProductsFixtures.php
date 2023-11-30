<?php

namespace App\DataFixtures;

use App\Entity\Products;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\String\Slugger\SluggerInterface;
use Faker\Factory;
use Faker\Provider\Fakecar;

class ProductsFixtures extends Fixture
{
    private $counter = 1;
    public function __construct(private SluggerInterface $slugger)
    {
    }
    public function load(ObjectManager $manager): void
    {
        $faker = Factory::create('fr_FR');
        $faker->addProvider(new Fakecar($faker));

        $arrayProduct = [];
        for ($prod = 1; $prod <= 600; $prod++) {
            $products = new Products();
            $products->setProductOrder($this->counter);
            $products->setBrand($faker->vehicleBrand);
            $products->setModel($faker->vehicleModel);
            $products->setSlug($this->slugger->slug($products->getModel())->lower());
            $products->setDescription($faker->sentences(2, true));
            $products->setCity($faker->city);
            $products->setPrice($faker->numberBetween(1000, 150000));
            $products->setStock($faker->numberBetween(1, 15));

            $category = $this->getReference('category_' . $faker->numberBetween(1, 12));
            $products->setCategories($category);

            $arrayProduct[] = $products;
            $manager->persist($products);

            $this->addReference('product_' . $this->counter, $products);
            $this->counter++;
        }
        $manager->flush();
    }
}
