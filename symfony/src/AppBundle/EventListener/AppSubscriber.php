<?php

namespace AppBundle\EventListener;


use JavierEguiluz\Bundle\EasyAdminBundle\Event\EasyAdminEvents;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\EventDispatcher\GenericEvent;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;

class AppSubscriber implements EventSubscriberInterface
{

	protected $container;

	public function __construct(ContainerInterface $container)
	{
		$this->container = $container;
	}

	/**
	 * @inheritdoc
	 */
	public static function getSubscribedEvents()
	{
		return [
			EasyAdminEvents::PRE_LIST   => 'checkUserRights',
			EasyAdminEvents::PRE_EDIT   => 'checkUserRights',
			EasyAdminEvents::PRE_SHOW   => 'checkUserRights',
			EasyAdminEvents::PRE_NEW    => 'checkUserRights',
			EasyAdminEvents::PRE_DELETE => 'checkUserRights',
		];
	}

	public function checkUserRights(GenericEvent $event)
	{
		if ($this->container->get('security.authorization_checker')->isGranted('ROLE_SUPER_ADMIN')) {
			return;
		}

		$entity = $this->container->get('request_stack')->getCurrentRequest()->query->get('entity');
		$action = $this->container->get('request_stack')->getCurrentRequest()->query->get('action');
		$user_id = $this->container->get('request_stack')->getCurrentRequest()->query->get('id');

		if ($entity == 'User')
		{
			if ($action == 'edit' || $action == 'show')
			{
				if ($user_id == $this->container->get('security.token_storage')->getToken()->getUser()->getId())
				{
					return;
				}
			}
		}

		throw new AccessDeniedException();
	}

}