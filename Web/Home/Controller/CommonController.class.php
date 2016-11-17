<?php
namespace Home\Controller;
use Think\Controller;
class CommonController extends mainController {
    public function _initialize()
    {	
    	parent::_initialize();
      	if(!session('?userInfo')){
      		$this->redirect('Login/login');
    	}
    }
    
    
    public function _empty()
    {
        $this->display('Public:error');
    }

}