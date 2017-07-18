<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sonata\AdminBundle\Controller\CoreController;

class AdminController extends CoreController {

//	function __construct() { exit; }

	/**
	 * @Route("/dashboard", name="sonata_admin_dashboard")
	 */
	public function dashboardAction()
    {
    	exit;
    }

}