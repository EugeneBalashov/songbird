<?php

namespace AppBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;

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