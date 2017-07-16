<?php

namespace AppBundle\Controller;

use \JavierEguiluz\Bundle\EasyAdminBundle\Controller\AdminController as BaseAdminBundle;
use JavierEguiluz\Bundle\EasyAdminBundle\Event\EasyAdminEvents;
use Symfony\Component\HttpFoundation\Request;

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

	public function editUserAction()
	{
		$this->dispatch(EasyAdminEvents::PRE_EDIT);
		$id = $this->request->query->get('id');
		$easyadmin = $this->request->attributes->get('easyadmin');
		$entity = $easyadmin['item'];

		if ($this->request->isXmlHttpRequest() && $property = $this->request->query->get('property'))
		{
			$newValue = 'true' === strtolower($this->request->query->get('newValue'));
			$fieldsMetadata = $this->entity['list']['fields'];
			if (!isset($fieldsMetadata[$property]) || 'toggle' !== $fieldsMetadata[$property]['dataType'])
			{
				throw new \RuntimeException(sprintf('The type of the "%s" property is not "toggle".', $property));
			}
//			$this->updateEntityProperty($entity, $property, $newValue);
			//my
			// @todo Test
			$entity->{$property} = $newValue;
			$this->preUpdateEntity($entity);

			return new Response((string)$newValue);
		}
		$fields = $this->entity['edit']['fields'];
		$editForm = $this->createEditForm($entity, $fields);
		if (!$this->isGranted('ROLE_SUPER_ADMIN'))
		{
			$editForm->remove('enabled');
			$editForm->remove('roles');
		}
		$deleteForm = $this->createDeleteForm($this->entity['name'], $id);
		$editForm->handleRequest($this->request);
		if ($editForm->isValid())
		{
			$this->preUpdateUserEntity($entity);
			$this->em->flush();
			$refererUrl = $this->request->query->get('referer', '');

			return !empty($refererUrl)
				? $this->redirect(urldecode($refererUrl))
				: $this->redirect($this->generateUrl('easyadmin', ['action' => 'show', 'entity' => $this->entity['name'], 'id' => $id]));
		}

		return $this->render($this->entity['templates']['edit'], [
			'form'          => $editForm->createView(),
			'entity_fields' => $fields,
			'entity'        => $entity,
			'delete_form'   => $deleteForm->createView(),
		]);
	}

}
