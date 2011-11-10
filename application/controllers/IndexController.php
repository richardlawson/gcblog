<?php

class IndexController extends Zend_Controller_Action
{
	protected $_em;
	
    public function init()
    {
       $registry = Zend_Registry::getInstance();
       $this->_em = $registry->em;
       $this->view->menuItem = $registry->properties->menuitem->home->id;
    }

    public function indexAction()
    {
        $this->view->blogEntries = $this->_em->getRepository('GC\Entity\BlogEntry')->getRecentBlogEntries(0, 3);
    	$this->view->totalBlogs = $this->_em->getRepository('GC\Entity\BlogEntry')->total();
    }


}

