<?php

namespace App\DataFixtures;

use App\Entity\Image;
use App\Entity\Message;
use App\Entity\Trick;
use App\Entity\TrickGroup;
use App\Entity\User;
use DateTime;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Exception;
use Faker\Factory;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\String\Slugger\AsciiSlugger;

class AppFixtures extends Fixture
{
    private UserPasswordHasherInterface $passwordHasher;

    public function __construct(UserPasswordHasherInterface $passwordHasher)
    {
        $this->passwordHasher = $passwordHasher;
        $this->userArray = [];
        $this->trickArray = [];
    }

    public function loadUsers(ObjectManager $manager): void
    {
        $admin = new User();

        $admin->setFirstname('Jimmy');
        $admin->setLastname('Sweat');
        $admin->setUsername('JimmySweat');
        $admin->setEmail(
            'jimmy.sweat@snowtricks.fr'
        );

        $adminPassword = $this->passwordHasher->hashPassword(
            $admin,
            'adminPassword'
        );

        $admin->setPassword($adminPassword);
        $admin->setRoles(['ROLE_ADMIN', 'ROLE_USER']);
        $admin->setIsVerified(true);

        $manager->persist($admin);

        for ($i = 0; $i <= 19; ++$i) {
            $faker = Factory::create();
            $username = $faker->userName();
            $clearPassword = 'userPassword';

            $user = new User();

            $user->setFirstname($faker->firstName());
            $user->setLastname($faker->lastName());
            $user->setUsername($username);
            $user->setEmail(
                $username.'@'.$faker->domainName()
            );

            $hashedPassword = $this->passwordHasher->hashPassword(
                $user,
                $clearPassword
            );

            $user->setPassword($hashedPassword);
            $user->setRoles(['ROLE_USER']);
            $user->setIsVerified(true);

            $this->userArray[] = $user;

            $manager->persist($user);
        }

        $manager->flush();
    }

    public function loadTricks(ObjectManager $manager): void
    {
        $trickGroups = [
            'Regular' => null,
            'Goofy' => null,
            'Switch' => null,
            'Grabs' => [
                'Mute',
                'Indy',
                'Stalefish',
                'Tail Grab',
                'Japan Air',
            ],
            'Rotations' => [
                '180',
                '360',
                '720',
            ],
            'Rotations désaxées' => null,
            'Flips' => null,
            'Slides' => [
                'Nose Slide',
                'Tail Slide',
            ],
            'One Foot' => null,
            'Old School' => [
                'Back Side Air',
                'Method Air',
            ],
        ];

        foreach ($trickGroups as $trickGroup => $trickList) {
            $group = new TrickGroup($trickGroup);

            $manager->persist($group);

            if (null !== $trickList) {
                foreach ($trickList as $trick) {
                    $faker = Factory::create();
                    $slugger = new AsciiSlugger();

                    $coverImage = new Image(
                        'Cover Image',
                        'https://images.unsplash.com/photo-1478700485868-972b69dc3fc4?ixlib=rb-1.2.1&ixid=MnwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8&auto=format&fit=crop&w=1740&q=80',
                        'Cover Image'
                    );

                    $trick = new Trick(
                        $trick,
                        $faker->paragraph(3, 5),
                        $slugger->slug($trick),
                        $coverImage
                    );

                    $manager->persist($coverImage);
                    $manager->flush();

                    $trick->setTrickGroup($group);

                    $placeholderImage = new Image(
                        'Placeholder Image',
                        'https://images.unsplash.com/photo-1478700485868-972b69dc3fc4?ixlib=rb-1.2.1&ixid=MnwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8&auto=format&fit=crop&w=1740&q=80',
                        'Placeholder Image'
                    );

                    $manager->persist($placeholderImage);
                    $manager->persist($trick);

                    $coverImage->setTrick($trick);

                    $manager->flush();

                    $trick->addImage($placeholderImage);

                    $this->trickArray[] = $trick;
                }
            }
        }

        $manager->flush();
    }

    public function loadMessages(
        ObjectManager $manager
    ): void {
        for ($i = 0; $i <= 40; ++$i) {
            $faker = Factory::create();

            $designatedUser = rand(0, 19);
            $user = $this->userArray[$designatedUser];

            if (!$user instanceof User) {
                throw new Exception('Cannot make an user');
            }

            $designatedTrick = rand(0, 11);
            $trick = $this->trickArray[$designatedTrick];

            if (!$trick instanceof Trick) {
                throw new Exception('Cannot make a trick');
            }

            $createdAt = new DateTime();

            $message = new Message();

            $message->setWriter($user);
            $message->setTrick($trick);
            $message->setContent($faker->paragraph(1, 50));
            $message->setCreatedAt($createdAt);

            $manager->persist($message);
        }

        $manager->flush();
    }

    public function load(ObjectManager $manager): void
    {
        $this->loadUsers($manager);
        $this->loadTricks($manager);
        $this->loadMessages($manager);
    }
}
