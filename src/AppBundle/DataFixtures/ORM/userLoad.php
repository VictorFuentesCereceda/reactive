<?php
/**
 * Created by PhpStorm.
 * User: desarrollador1
 * Date: 16-09-15
 * Time: 12:44
 */

namespace Edcorp\UserBundle;

use AppBundle\Entity\Role;
use AppBundle\Entity\User;
use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Edcorp\UserBundle\Entity\Commune;
use Edcorp\UserBundle\Entity\Gender;
use Edcorp\UserBundle\Entity\Region;
use Edcorp\UserBundle\Entity\SystemAccessPriviledge;
use Edcorp\UserBundle\Entity\Users;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\Security\Core\Encoder\MessageDigestPasswordEncoder;

use Symfony\Component\Validator\Constraints\DateTime;


class loadIniData  extends AbstractFixture implements FixtureInterface, ContainerAwareInterface, OrderedFixtureInterface
{
    private $container;

    public function setContainer(ContainerInterface $container = null)
    {
        $this->container = $container;
    }

    public function getOrder()
    {
        return 3;
    }


    /**
     * {@inheritDoc}
     */
    public function load(ObjectManager $manager)
    {

        $roles = [
            ["Administrador", "ROLE_ADMINISTRATOR"],
            ["Usuario","ROLE_USER"]
        ];

        $users = [
            ["Administrador", "admin@reactive.cl", "administrador", "ROLE_ADMINISTRATOR"],
            ["Usuario","usuario@reactive.cl","usuario","ROLE_USER"]
        ];

        foreach ($roles as $role) {
            $newRole= new Role();
            $newRole->setName($role[0]);
            $newRole->setRole($role[1]);
            $manager->persist($newRole);
            $manager->flush();
        }

        $encoder = $this->container->get('security.password_encoder');
        foreach ($users as $user) {
            $u = new User();
            $u->setName($user[0]);
            $u->setUsername($user[1]);
            $password = $user[2];
            $encoded = $encoder->encodePassword($u, $password);
            $u->setPassword($encoded);
            $role = $manager->getRepository("AppBundle:Role")->findOneByRole($user[3]);
            $u->setRole($role);

            $manager->persist($u);
            $manager->flush();
        }
    }


}