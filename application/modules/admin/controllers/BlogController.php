<?php

class Admin_BlogController extends Zend_Controller_Action
{
	protected $_em;
    
	public function preDispatch(){
		if(!$this->_helper->auth->isAuthorized()){
			$this->_helper->redirector->gotoRoute(array(), 'login');
		}
	}
	
	public function init()
    {
       $registry = Zend_Registry::getInstance();
       $this->_em = $registry->em;
    }

    public function indexAction(){
    	$this->view->selectedMenuItem = 3;
 		$this->view->categories = $this->_em->getRepository('GC\Entity\Category')->findAllOrderedByPosition();
    }
    
    public function fetchflexigridblogsAction(){
    	$this->_helper->viewRenderer->setNoRender();
      	$this->_helper->layout->disableLayout();
      	$categoryId = $this->_getParam('categoryId', 0);
    	$page = $this->_getParam('page', 1);
    	$rp = $this->_getParam('rp', 10);
    	$sortname = $this->_getParam('sortname', 'postDate');
    	$sortorder = $this->_getParam('sortorder', 'desc');
    	$qtype = $this->_getParam('qtype');
    	$query = $this->_getParam('query');
    	$blogs = $this->getPagedBlogs($categoryId, $page, $rp, $sortname, $sortorder);
		$totalNoBlogs = $this->getTotalBlogs($categoryId);
    	$data = $this->buildFlexigridDataArray($page, $totalNoBlogs, $blogs);
    	echo Zend_Json::encode($data);
    }
    
	protected function getPagedBlogs($categoryId, $page, $rp, $sortname, $sortorder){
  		$blogs = array();
    	if($categoryId == 0){
    		$blogs = $this->_em->getRepository('GC\Entity\BlogEntry')->getPagedBlogEntries($page, $rp, $sortname, $sortorder);
    	}else{
    		$blogs = $this->_em->getRepository('GC\Entity\BlogEntry')->getPagedBlogEntriesForCategory($categoryId, $page, $rp, $sortname, $sortorder);
    	}
    	return $blogs;
    }
    
    protected function getTotalBlogs($categoryId = 0){
    	$totalNoBlogs = 0;
    	if($categoryId == 0){
    		$totalNoBlogs = $this->_em->getRepository('GC\Entity\BlogEntry')->total();
    	}else{
    		$totalNoBlogs = $this->_em->getRepository('GC\Entity\BlogEntry')->totalForCategory($categoryId);
    	}
    	return $totalNoBlogs;
    }
    
    protected function buildFlexigridDataArray($page, $noBlogs, $blogs){
    	$data = array();
    	$data['page'] = $page;
		$data['total'] = $noBlogs;
    	foreach($blogs as $blogEntry){
			$data['rows'][] = array('id' => $blogEntry->id,
				'cell' => array($blogEntry->title, $blogEntry->postDateAsString, $blogEntry->category->name, $blogEntry->image)
			);
		}
		return $data;
    }
    
	public function deleteAction(){
      	try{
			$ids = $this->_getParam('ids', '');
			$ids = explode(',', $ids);
			foreach($ids as $id){
				$selectedBlog = $this->_em->find('GC\Entity\BlogEntry',(int) $id);
				$this->_em->remove($selectedBlog);
				$this->_em->flush();
			}
		}catch(Exception $e){
			// look into sending error message
		}
		$this->fetchflexigridblogsAction();
	}
    
    public function addAction(){
    	$this->view->selectedMenuItem = 4;
    	$form = $this->getForm();
		if($this->getRequest()->isPost()){
			try{
				$useExistingImage = $this->_getParam('useExisting');
				$this->validateAndSave($form, $useExistingImage);	
				return $this->_helper->redirector->gotoRoute(array(), 'blog-list');
			}catch(Exception $e){
        	}
		}else{
			$this->loadForm($form);
		}
    	$this->view->form = $form;
    }
    
	private function getForm(){
		$id = (int) $this->_getParam('id', 0);
		$categories = $this->_em->getRepository('GC\Entity\Category')->findAll();
		if($id != 0){
			return new Admin_Form_BlogEntryEdit(array('categories' => $categories));
		}
		return new Admin_Form_BlogEntry(array('categories' => $categories));
	}
    
	private function validateAndSave(Zend_Form $form, $useExistingImage){
    	$this->validateForm($form);
       	$this->save($form, $useExistingImage);
    }
    
	private function validateForm(Zend_Form $form){
		if(!$form->isValid($this->_request->getPost())){
			throw new Exception('Form Data Invalid'); 
		}
    }
    
	private function save(Zend_Form $form, $useExistingImage){
		$id = (int) $form->getValue('id');
		$blogEntry = new GC\Entity\BlogEntry(array('id' => $id));
		if($id != 0){
			$blogEntry = $this->_em->find('GC\Entity\BlogEntry', $id);
		}
		$this->populateBlogEntry($blogEntry, $form);
		$this->_em->getRepository('GC\Entity\BlogEntry')->save($blogEntry);
		if(!$useExistingImage){
			$this->saveImagesToFilesystemAndCreateThumbnails(APPLICATION_PATH . "/../public/images/blog-images/{$blogEntry->id}/");
		}
	}
	
	private function populateBlogEntry($blogEntry, $form){
		$blogEntry->populate($form->getValues());
		if($form->getValue('useExisting')){
			$blogEntry->image = $form->getValue('existingImage');
		}
		$blogEntry->category = $this->getCategoryFromForm($form);
		return $blogEntry;
	}
	
	private function getCategoryFromForm(Zend_Form $form){
		$category = $this->_em->find('GC\Entity\Category', (int) $form->getValue('categoryId'));
		return $category;
	}
	
	private function saveImagesToFilesystemAndCreateThumbnails($savePath){
		if(!file_exists($savePath)){
	    	mkdir($savePath);
    	}
    	$upload = new Zend_File_Transfer();
    	$this->saveImagesToFilesystem($upload, $savePath);
    	$this->createThumbnails($savePath, $upload->getFileInfo());		
	}
	
	private function saveImagesToFilesystem(Zend_File_Transfer $upload, $savePath){
		$upload->setDestination($savePath); 
    	$upload->receive();
	}
	
	private function createThumbnails($savePath, $files){
		foreach($files as $file => $info){
			$imageResizer = new GC\Entity\ImageResizer(array('path' => $savePath, 'file' => $info['name']));
			$imageResizer->createThumbnail(168);
		}
	}
    
	private function loadForm(Zend_Form $form){
		$id = (int) $this->_getParam('id', 0);
		$blogEntry = $this->loadBlogEntry($id);
		$form->populate($blogEntry->toArray());
		$form->populate(array('existingImage' => $blogEntry->image));
		return $form;	
	}
	
	private function loadBlogEntry($id = 0){
		$id = (int) $id;
		$blogEntry = new GC\Entity\BlogEntry(array('id' => $id, 'category' => new GC\Entity\Category(array('id' => 0))));
		if($id != 0){
			$blogEntry = $this->_em->find('GC\Entity\BlogEntry', $id);
		}
		return $blogEntry;
	}
}

