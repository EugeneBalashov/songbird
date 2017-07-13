<?php

namespace AppBundle\Controller;

use \JavierEguiluz\Bundle\EasyAdminBundle\Controller\AdminController as BaseAdminBundle;
use JavierEguiluz\Bundle\EasyAdminBundle\Event\EasyAdminEvents;

class AdminController extends BaseAdminBundle
{

	public function createNewUserEntity()
	{
		return $this->get('fos_user.user_manager')->createUser();
	}

	public function prePersistUserEntity($user)
	{
		return $this->get('fos_user.user_manager')->updateUser($user, false);
	}

	public function preUpdateUserEntity($user)
	{
		return $this->get('fos_user.user_manager')->updateUser($user, false);
	}

	public function showUserAction()
	{
		$this->dispatch(EasyAdminEvents::PRE_SHOW);
		$id = $this->request->query->get('id');
		$easyadmin = $this->request->attributes->get('easyadmin');
		$entity = $easyadmin['item'];

		$fields = $this->entity['show']['fields'];

		if (!$this->isGranted('ROLE_SUPER_ADMIN'))
		{
			unset($fields['created']);
		}

		$deleteForm = $this->createDeleteForm($this->entity['name'], $id);

		return $this->render($this->entity['templates']['show'], [
			'entity' => $entity,
			'fields' => $fields,
			'delete_form' => $deleteForm->createView(),
		]);
	}

}
