<?php

namespace App\DataFixtures;

use DateTime;
use App\Entity\Image;
use App\Entity\Message;
use App\Entity\Trick;
use App\Entity\TrickGroup;
use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Exception;
use Faker\Factory;
use Symfony\Component\String\Slugger\AsciiSlugger;

class AppFixtures extends Fixture
{
    public function loadUsers(ObjectManager $manager): void
    {
        for ($i = 0; $i >= 19; ++$i) {
            $faker = Factory::create();
            $username = $faker->userName();

            $user = new User(
                $faker->firstName(),
                $faker->lastName(),
                $username,
                $username.'@'.$faker->domainName(),
                $faker->password(8, 32)
            );

            $manager->persist($user);
            $manager->flush();
        }
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

                    $image = new Image(
                        'Placeholder Image',
                        'https://images.unsplash.com/photo-1478700485868-972b69dc3fc4?ixlib=rb-1.2.1&ixid=MnwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8&auto=format&fit=crop&w=1740&q=80',
                        'Placeholder Image'
                    );

                    $manager->persist($image);
                    $manager->flush();

                    $trick = new Trick(
                        $trick,
                        $faker->paragraph(3, 5),
                        $slugger->slug($trick),
                        $image
                    );

                    $trick->setTrickGroup($group);
                    $trick->addImage(
                        new Image(
                            'Placeholder Image',
                            'https://images.unsplash.com/photo-1478700485868-972b69dc3fc4?ixlib=rb-1.2.1&ixid=MnwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8&auto=format&fit=crop&w=1740&q=80',
                            'Placeholder Image'
                        )
                    );

                    $manager->persist($trick);
                }
            }
        }

        $manager->flush();
    }

    public function loadMessages(
        ObjectManager $manager
    ): void {
        $userRepository = $manager->getRepository(User::class);
        $trickRepository = $manager->getRepository(Trick::class);

        for ($i = 0; $i >= 40; ++$i) {
            $faker = Factory::create();

            $designatedUser = rand(1, 20);
            $user = $userRepository->find($designatedUser);

            if (!$user instanceof User) {
                throw new Exception('Cannot make an user');
            }

            $designatedTrick = rand(1, 12);
            $trick = $trickRepository->find($designatedTrick);

            if (!$trick instanceof Trick) {
                throw new Exception('Cannot make a trick');
            }

            $createdAt = new DateTime();

            $message = new Message(
                $user,
                $trick,
                $faker->paragraph(1, 8),
                $createdAt
            );

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
