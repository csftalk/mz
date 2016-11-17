<?php
namespace Home\Controller;
use Think\Controller;
class PublicController extends mainController {
    public function maintenance()
    {	
    	$info = M('System')->where('id = 1')->find();
    	if ($info['result'] == 'on') {
    		$this->redirect('Index/index');
    		die;
    	}
    	$this->display();
    }

    public function err404()
    {
    	$this->display();
    }

}