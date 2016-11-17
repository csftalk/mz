<?php
namespace Admin\Controller;
use Think\Controller;

class CommonController extends Controller {
	public function _initialize()
	{
		if(!session('?adminInfo')){
			$this->redirect('Login/login');
		}
		
		$name = CONTROLLER_NAME.'/'.ACTION_NAME;
		$nodeList = session('nodeList');
		//$nodeList = M('Node')->select();


        $user = session('adminInfo');
        
         //判断权限
        if (!in_array_case($name, $nodeList) && $user['username'] != 'admin') {
            $this->error('无权访问', U('Index/welcome'));
        }
	}




	public function _empty(){       
		$this->display('Public:error');
	}
}