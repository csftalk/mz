<?php
namespace Home\Controller;
use Think\Controller;
class LoginController extends mainController {
    public function login(){
    	if(IS_POST){
    		$yzm = new \Think\Verify();
    		$code = I('yzm');
    		if (!$yzm->check($code)) {
                $this->error('验证码错误');
            }

            $map['username'] = I('username');
            $info = M('Users')->where($map)->find();
            $res = password_verify(I('pwd'), $info['pwd']);
            if($res && $info['status'] == 1){
                session('userInfo', $info);
                $this->success('登陆成功', U('index/index'));
            }else if($res && $info['status'] == 2){
                $this->error('由于您非法操作过多。账号已被禁用,请联系管理员');
            }else{
            	$this->error('账户不存在');
            }

    	}else{
    		$this->display();
    	}

    }

     public function check()
    {
        $code = $_GET['code'];
        $verify = new \Think\Verify();    
        //dump($verify->check($code));
    }

    /**
     * 验证码
     */
    public function yzm()
    {
        $Verify = new \Think\Verify();
        $Verify->fontSize = 20;         //字体大小
        $Verify->length   = 4;          //验证码个数
        $Verify->useNoise = false;      //关闭杂点
        $Verify->imageH   = 40;
        $Verify->imageW   = 200;
        $Verify->entry();
    }

    public function logout(){
    	session('userInfo', null);
    	$this->redirect('Login/login');
    }
}