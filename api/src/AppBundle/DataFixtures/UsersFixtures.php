<?php

namespace AppBundle\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;

class UsersFixtures extends Fixture implements ContainerAwareInterface
{
    /**
     * @var ContainerInterface
     */
    private $container;

    /**
     * {@inheritdoc}
     */
    public function setContainer(ContainerInterface $container = null)
    {
        $this->container = $container;
    }

    public function load(ObjectManager $manager)
    {
        $factory = $this->container->get('security.encoder_factory');

        /**
         * @var \FOS\UserBundle\Doctrine\UserManager $manager
         */
        $manager = $this->container->get('fos_user.user_manager');

        /**
         * @var \AppBundle\Entity\User
         */
        $user = $manager->createUser();

        $user
            ->setUsername('root')
            ->setEmail('noreply@mail.com')
            ->setRoles(array('ROLE_SUPER_ADMIN'))
            ->setEnabled(true)
        ;

        $encoder = $factory->getEncoder($user);
        $password = $encoder->encodePassword('root', $user->getSalt());

        $user
            ->setPassword($password)
        ;

        $manager->updateUser($user);
        unset($user);

    }
}