<?php

namespace App\DataFixtures;

use App\Model\File\Entity\File\File;
use App\Model\File\Entity\File\Info;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        $file1 = $this->createFile('test.mp3', '2020/08/06', 2456);
        $file2 = $this->createFile('test2.mp3', '2020/08/07', 2456);
        $file3 = $this->createFile('test3.mp3', '2020/08/07', 2456);

        $manager->persist($file1);
        $manager->persist($file2);
        $manager->persist($file3);

        $manager->flush();
    }

    private function createFile($name, $path, $size)
    {
        $info = new Info($path, $name, $size);
        return new File(new \DateTimeImmutable(), $info);
    }
}

