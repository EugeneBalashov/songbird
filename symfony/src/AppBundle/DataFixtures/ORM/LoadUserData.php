<?php

namespace AppBundle\DataFixtures\ORM;

use AppBundle\Entity\User;
use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;
use FOS\UserBundle\Doctrine\UserManager;

class LoadUserData extends AbstractFixture implements OrderedFixtureInterface, ContainerAwareInterface
{

	/**
	 * @var ContainerInterface
	 */
	private $container;

	/**
	 * {@inheritdoc}
	 */
	public function load(ObjectManager $manager)
	{
		var_dump(111);
		return;

		/** @var UserManager $userManager */
		$userManager = $this->container->get('fos_user.user_manager');

		// add admin user
		/** @var User $admin */
		$admin = $userManager->createUser();
		$admin
			->setUsername('admin')
			->setEmail('admin@songbird.app')
			->setPlainPassword('admin');
		$userManager->updatePassword($admin);
		$admin
			->setEnabled(1)
			->setFirstname('Admin Firstname')
			->setLastname('Admin Lastname')
			->setRoles(['ROLE_SUPER_ADMIN']);
		$userManager->updateUser($admin);

		// add test users
		$users = ['test1' => 1, 'test2' => 1, 'test3' => 0];

		foreach ($users as $name => $enabled)
		{
			/** @var User $user */
			$user = $userManager->createUser();
			$user
				->setUsername($name)
				->setEmail("$name@songbird.app")
				->setPlainPassword($name);
			$userManager->updatePassword($user);
			$user
				->setEnabled($enabled)
				->setFirstname("$name Firstname")
				->setLastname("$name Lastname");
			$userManager->updateUser($user);
		}

		$this->addReference('admin_user', $admin);
	}

	/**
	 * {@inheritdoc}
	 */
	public function getOrder()
	{
		return 1;
	}

	/**
	 * {@inheritdoc}
	 */
	public function setContainer(ContainerInterface $container = null)
	{
		$this->container = $container;
	}
}