<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

use App\Entity\User;
use App\Entity\Product;
use App\Entity\Review;

class AppFixtures extends Fixture
{
    public function __construct(private UserPasswordHasherInterface $UserPasswordHasherInterface) {}
    public function load(ObjectManager $manager): void
    {
        $user = new User();
        $user->setUsername('admin');
        $user->setRoles(['ROLE_ADMIN']);

        // Hash the password
        $plainPassword = '123123123';
        $hashedPassword = $this->UserPasswordHasherInterface->hashPassword($user, $plainPassword);
        $user->setPassword($hashedPassword);

        // Persist the user
        $manager->persist($user);

        // random users
        $users = [];
        for ($i = 0; $i < 10; $i++) {
            $user = new User();
            $user->setUsername('user'.$i);
            // $user->setRoles(['user']);

            // Hash the password
            $plainPassword = '123123123';
            $hashedPassword = $this->UserPasswordHasherInterface->hashPassword($user, $plainPassword);
            $user->setPassword($hashedPassword);

            // Persist the user
            $manager->persist($user);
            $users[] = $user;
        }

        // random products
        for ($i = 0; $i < 20; $i++) {
            $product = new Product();
            $product->setName('Product '.$i);
            $product->setDescription('Lorem ipsum dolor sit amet, consectetur adipiscing elit. Etiam purus tellus, euismod et elit a, mollis commodo est. Nullam felis mauris, euismod sed ligula ut, semper sodales massa. In facilisis in est non scelerisque. Duis efficitur et risus id gravida. Donec ut bibendum velit. Duis finibus, eros quis bibendum malesuada, neque eros tristique eros, sed tempor arcu mauris quis felis. Morbi venenatis varius efficitur. Morbi nec volutpat leo. Curabitur turpis nisl, rhoncus at arcu ut, varius imperdiet libero. Pellentesque tristique, diam sit amet vulputate volutpat, massa nulla luctus magna, nec mattis ex sapien in risus. Fusce ullamcorper iaculis scelerisque. Pellentesque congue metus at ante luctus pulvinar. Praesent efficitur eu metus id suscipit. ');
            $product->setDate(new \DateTime());
            $manager->persist($product);

            // random reviews for product
            $n = rand(1, 6);
            for ($j = 0; $j < $n; $j++) {
                $review = new Review();
                $review->setContent('Vivamus ut arcu facilisis, tempor enim quis, vestibulum purus. Aenean iaculis ligula porttitor tortor pharetra imperdiet a vitae velit. Phasellus ante nunc, tincidunt a ante a, tincidunt viverra dolor. Aenean viverra pretium enim et condimentum. Sed euismod quam ex, at sagittis odio semper a. Vestibulum quam ipsum, hendrerit ac aliquam id, feugiat ut tellus. Sed nec justo turpis. Mauris ac nunc mollis arcu volutpat tristique. ');

                $review->setProduct($product);
                // select random user
                $review->setOwner($users[array_rand($users)]);

                $manager->persist($review);
            }
        }
            // $product->setOwner($user);

        $manager->flush();
    }
}