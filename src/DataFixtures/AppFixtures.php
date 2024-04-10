<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        // $product = new Product();
        // $manager->persist($product);

        $manager->flush();
    }
}
// src/DataFixtures/AppFixtures.php
namespace App\DataFixtures;

use App\Entity\Product;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        $default_content = "
  Lorem, ipsum dolor sit amet consectetur adipisicing elit. Suscipit corrupti enim, eveniet ex fugit sed, doloremque consequuntur magnam voluptas vel, reprehenderit totam! Iure earum modi ab alias quaerat, deserunt laboriosam."

        // create 20 products! Bam!
        for ($i = 0; $i < 20; $i++) {
            $post = new Post();
            name->setName('Article '.$i);
            $product->setContent($default_content));
            $manager->persist($product);
        }

        $manager->flush();
    }
}