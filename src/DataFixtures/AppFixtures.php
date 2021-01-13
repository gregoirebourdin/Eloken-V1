<?php

namespace App\DataFixtures;

use App\Entity\Category;
use App\Entity\Product;
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
            ->setRoles(['ROLE_ADMIN']);

        $manager->persist($admin);

        //  Creation of 5 users
        for ($u = 0; $u < 5; $u++)
        {
            $user = new User();

            //  Setting up the encoder for the created users
            $hash = $this->encoder->encodePassword($user, "password");

            $user->setEmail("user$u@gmail.com")
                 ->setFullName($faker->name())
                 ->setPassword($hash);

            $manager->persist($user);
        }

        //  Creation of 3 categories
        for ($c = 0; $c < 3; $c++)
        {
            $category = new Category;
            $category->setName($faker->department)
                     ->setSlug(strtolower($this->slugger->slug($category->getName())));

            $manager->persist($category);

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

                $manager->persist($product);
            }
        }

        $manager->flush();
    }
}
