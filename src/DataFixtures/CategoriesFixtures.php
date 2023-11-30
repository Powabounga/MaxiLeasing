<?php

namespace App\DataFixtures;

use App\Entity\Categories;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\String\Slugger\SluggerInterface;

class CategoriesFixtures extends Fixture
{

    private $counter = 1;

    public function __construct(private SluggerInterface $slugger)
    {
    }
    public function load(ObjectManager $manager): void
    {
        $parent = $this->createCategory('Voitures', null, $manager, 'Les voitures sont des véhicules terrestres à roues, motorisés, qui sont destinés au transport de personnes et de marchandises.');

        $this->createCategory('Citadines', $parent, $manager, 'Les citadines sont des voitures de petite taille, destinées à la circulation en ville.');
        $this->createCategory('Break/Familiale', $parent, $manager, 'Les breaks sont des voitures de taille moyenne, destinées au transport de personnes et de marchandises.');
        $this->createCategory('Sportive', $parent, $manager, 'Les voitures sportives sont des voitures de taille moyenne, destinées à la conduite sportive.');

        $parent = $this->createCategory('Motos', null, $manager, 'Les motos sont des véhicules terrestres à deux roues, motorisés, qui sont destinés au transport de personnes et de marchandises.');

        $this->createCategory('Sportive', $parent, $manager, 'Les motos sportives sont des motos de petite taille, destinées à la conduite sportive.');
        $this->createCategory('Tout-terrain', $parent, $manager, 'Les motos tout-terrain sont des motos de taille moyenne, destinées à la conduite sur des terrains accidentés.');
        $this->createCategory('Collection', $parent, $manager, 'Les motos de collection sont des motos rares, destinées à la collection ou exposition.');

        $parent = $this->createCategory('Véhicules spéciaux', null, $manager, 'Les véhicules spéciaux sont des véhicules terrestres à roues, motorisés, qui sont destinés à des usages spécifiques.');

        $this->createCategory('Camionnette/Fourgon', $parent, $manager, 'Les camionnettes sont des véhicules de taille moyenne, destinées au transport de marchandises.');
        $this->createCategory('Engin de chantier', $parent, $manager, 'Les engins de chantier sont des véhicules de taille moyenne, destinées à des usages spécifiques sur les chantiers.');
        $this->createCategory('Supercar/Hypercar', $parent, $manager, 'Les supercars et hypercars sont des voitures de taille moyenne, destinées à la conduite sportive sur circuit ou lieu encadré.');

        $manager->flush();
    }

    public function createCategory(string $name, Categories $parent = null, ObjectManager $manager, string $description)
    {
        $category = new Categories();
        $category->setName($name);
        $category->setCategoryOrder($this->counter);
        $category->setSlug($this->slugger->slug($category->getName())->lower());
        $category->setParent($parent);
        $category->setDescription($description);
        $manager->persist($category);

        $this->addReference('category_' . $this->counter, $category);
        $this->counter++;
        return $category;
    }
}
