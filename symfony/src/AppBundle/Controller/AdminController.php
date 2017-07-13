<?php

namespace AppBundle\Controller;

use \JavierEguiluz\Bundle\EasyAdminBundle\Controller\AdminController as BaseAdminBundle;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;

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

}
