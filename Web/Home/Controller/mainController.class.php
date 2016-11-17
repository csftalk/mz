<?php
namespace Home\Controller;
use Think\Controller;
class mainController extends Controller {
    public function _initialize()
    {	
      	$info = M('System')->where('id = 1')->find();
    	if ($info['result'] == 'off') {
    		$this->redirect('Public/maintenance');
    		exit;
    	}
    }

}