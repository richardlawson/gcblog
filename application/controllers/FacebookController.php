<?php
require APPLICATION_PATH . '/../library/facebook/src/facebook.php';

class FacebookController extends Zend_Controller_Action
{
	
	protected $_em;
	protected $_facebook;
	
    public function init(){
        $registry = Zend_Registry::getInstance();
        $this->_em = $registry->em;
        $this->_facebook = new Facebook(array(
			'appId'  => $registry->facebookProperties['appId'],
			'secret' => $registry->facebookProperties['secret'],
			));
		$layout = $this->_helper->layout()->setLayout('facebook-layout');
    }

    public function indexAction(){
    	$this->addFacebookLoginUrlsToView();
    	try{
    		$gamer = $this->getGamer();
    	}catch(FacebookApiException $e) {
			error_log($e);
			$gamer = null;
		} 
		// if no gamer info get user to login 
    	if(!$gamer){
    		$this->render('login');
			return;
    	}else{
    		$this->addGamerToSession($gamer);
    		$this->view->gamer= $gamer;
    	}
    }
	
	protected function addFacebookLoginUrlsToView(){
		$this->view->logoutUrl = $this->_facebook->getLogoutUrl();
		$this->view->loginUrl = $this->_facebook->getLoginUrl(array('redirect_uri' => 'http://apps.facebook.com/tomcat-fighter/'));
	}
	
	protected function getGamer(){
		$gamer = null;
		if(isset($_SESSION['gamerId'])){
			$gamer = $this->_em->find('GC\Entity\Gamer', $_SESSION['gamerId']);
		}else{
			$gamer = $this->getGamerUsingFacebookInfo();
		}
		return $gamer;
	}
	
	protected function getGamerUsingFacebookInfo(){
		$gamer = null;
		$user = $this->_facebook->getUser();
		if($user){
			$gamer = $this->getGamerByFacebookProfile($this->_facebook->api('/me'));
		}
		return $gamer;
	}
	
	protected function getGamerByFacebookProfile($facebookProfile){
		$gamer = $this->_em->getRepository('GC\Entity\Gamer')->findOneBy(array('facebookId' => $facebookProfile['id']));
		// if facebook profile does not have an associated gamer entry in db then create a new one using facebook info
		if(!$gamer){
			$gamer = $this->createGamerUsingFacebookProfileAndSave($facebookProfile);
		}
		return $gamer;
	}

	protected function createGamerUsingFacebookProfileAndSave($facebookProfile){
		$gamer = new GC\Entity\Gamer(array('facebookId' => $facebookProfile['id'], 'name' => $facebookProfile['name']));
		$this->saveGamer($gamer);
		return $gamer;
	}
	
	protected function saveGamer(GC\Entity\Gamer $gamer){
		$this->_em->persist($gamer);
		$this->_em->flush();
	}
	
	public function addGamerToSession(GC\Entity\gamer $gamer){
		$_SESSION['gamerId'] = $gamer->id;
	}
	
	public function saveAction(){
		$this->_helper->viewRenderer->setNoRender();
      	$this->_helper->layout->disableLayout();
		if($this->getRequest()->isPost()){
			$saveStatus = 'SAVED';
			try{
				$gamer = $this->getGamerFromSession();
				$this->getScoreFromRequestFilterAndSave($gamer);
			}catch(Exception $e){
				$saveStatus = 'FAILED';
			}
			echo Zend_Json::encode($this->getSaveActionResponse($saveStatus, $gamer));
		}
    }
    
    protected function getGamerFromSession(){
    	return $this->_em->find('GC\Entity\Gamer', $_SESSION['gamerId']);
    }
    
    protected function getScoreFromRequestFilterAndSave(GC\Entity\Gamer $gamer){
    	$score = $this->getScoreFromRequest();
    	$this->filterScore($score);
    	$score->gamer = $gamer;
    	$this->saveScore($score);
    }
    
	protected function getScoreFromRequest(){
		$score = new GC\Entity\Score();
    	$score->handle = $this->_getParam('handle', '');
    	$score->points = $this->_getParam('points', 0);
    	return $score;
    }
    
    protected function filterScore(GC\Entity\Score $score){
    	$score->handle = htmlspecialchars($score->handle);
    	return $score;
    }
    
    protected function saveScore(GC\Entity\Score $score){
    	$this->_em->persist($score);
		$this->_em->flush();
    }
    
    protected function getSaveActionResponse($saveStatus, $gamer){
    	$response = array();
    	$response['saveStatus'] = $saveStatus;
    	$response['gamerHighScore'] = $gamer->highScore;
    	$response['highScores'] = $this->getJsonFriendlyHighScores();
    	return $response;
    }
    
    protected function getJsonFriendlyHighScores(){
    	$jsonFriendlyScores = array();
    	$scores = $this->getHighScores();
    	foreach($scores as $score){
    		$jsonFriendlyScores[] = $score->toArray();
    	}
    	return $jsonFriendlyScores;
    }
    
    protected function getHighScores(){
    	return $this->_em->getRepository('GC\Entity\Score')->getHighScores();
    }


}

