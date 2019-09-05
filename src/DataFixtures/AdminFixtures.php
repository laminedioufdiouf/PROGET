<?php

namespace App\DataFixtures;
use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class AdminFixtures extends Fixture
{
    private $encoder;
    public function __construct(UserPasswordEncoderInterface $encoder)
    {
        $this ->encoder = $encoder;
    }
    public function load(ObjectManager $manager)
    {
        
        //Entity user
        $user =new User();

        $user->setUsername('adminsup');
        $password =$this->encoder->encodePassword($user,'lamine');
        $user->setPassword($password);
        $user->setProfil('admingenerale');
        $user->setRoles(['ROLE_CAISSIER']);
        $user->setNom('lamine diouf');
        $user->setAdresse('ouakam');
        $user->setEmail('diouflamine7769@gmail.com');
        $user->setTelephone('776990795');

        
        $manager->persist($user);
        $manager->flush();
    }
}
