<?php

namespace App\DataFixtures;

use App\Entity\Category;
use App\Entity\Product;
use App\Entity\Purchase;
use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\String\Slugger\SluggerInterface;

class AppFixtures extends Fixture
{
    protected $slugger;
    protected $encoder;

    //  Creation of a constructor to have access to the SluggerInterface in the String component
    public function __construct(SluggerInterface $slugger, UserPasswordEncoderInterface $encoder)
    {
        $this->slugger = $slugger;
        $this->encoder = $encoder;
    }

    public function load(ObjectManager $manager)
    {
        //  Addition of Faker and three provider (bundles) for more realism
        $faker = Factory::create('fr_FR');
        $faker->addProvider(new \Liior\Faker\Prices($faker));
        $faker->addProvider(new \Bezhanov\Faker\Provider\Commerce($faker));
        $faker->addProvider(new \Bluemmb\Faker\PicsumPhotosProvider($faker));

        //  Creation of 1 Admin user
        $admin = new User();

        //  Setting up the encoder for the created users
        $hash = $this->encoder->encodePassword($admin, "password");

        $admin->setEmail("admin@gmail.com")
            ->setFullName($faker->name())
            ->setPassword($hash)
            ->setPicture($faker->imageUrl(640, 480))
            ->setRoles(['ROLE_ADMIN']);

        $manager->persist($admin);

        $users = [];

        //  Creation of 5 users
        for ($u = 0; $u < 5; $u++)
        {
            $user = new User();

            //  Setting up the encoder for the created users
            $hash = $this->encoder->encodePassword($user, "password");

            $user->setEmail("user$u@gmail.com")
                 ->setFullName($faker->name())
                 ->setPassword($hash)
                 ->setPicture($faker->imageUrl(640,480));

            $users[] = $user;

            $manager->persist($user);
        }

        //  Creation of 3 categories
        for ($c = 0; $c < 3; $c++)
        {
            $category = new Category;
            $category->setName($faker->department)
                     ->setSlug(strtolower($this->slugger->slug($category->getName())));

            $manager->persist($category);

            $products = [];

            //  Creation of 15 to 20 products per category
            for ($p = 0; $p < mt_rand(15, 20); $p++)
            {
                $product = new Product;
                $product->setName($faker->productName)
                        ->setPrice(mt_rand(4000,20000))
                        ->setSlug(strtolower($this->slugger->slug($product->getName())))
                        ->setCategory($category)
                        ->setShortDescription($faker->paragraph())
                        ->setMainPicture($faker->imageUrl(720, 400, true));

                $products[] = $product;
                $manager->persist($product);
            }
        }

        for ($p = 0; $p < mt_rand(20, 40); $p++) {

            $purchase = new Purchase();

            $purchase->setFullName($faker->name)
                ->setAddress($faker->streetAddress)
                ->setPostalCode($faker->postcode)
                ->setCity($faker->city)
                ->setUser($faker->randomElement($users))
                ->setTotal(mt_rand(2000, 30000))
                ->setPurchasedAt($faker->dateTimeBetween('-6 months'));

            $selectedProducts = $faker->randomElements($products, mt_rand(3,5));

            foreach ($selectedProducts as $product) {
                $purchase->addProduct($product);
            }

            if($faker->boolean(90)) {
                $purchase->setStatus(Purchase::STATUS_PAID);
            }
            $manager->persist($purchase);
        }

        $manager->flush();
    }
}
