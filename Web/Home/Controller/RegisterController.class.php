<?php
namespace Home\Controller;
use Think\Controller;
class RegisterController extends mainController {
    public function register(){
		$this->display();
    }

    public function add(){
    	if(IS_POST){
    		if(time() - session('code.time') > 900){
				$this->error('验证码过期');
			}else if(I('post.yzm') != session('code.code')){
				$this->error('验证码输入错误');
			}

    		$data['username'] = I('post.username');
    		$data['pwd'] = I('post.pwd');
    		$data['email'] = I('post.email');
            $users = D('Users');
            $data = $users->create();
        		if ($data) {
                	$res = $users->add($data);
                	$rand = mt_rand(100000,999999);
                	$name = '用户'.$rand;
            		$userInfo = M('Userinfo');
            		$map['uid'] = $res;
            		$map['name'] = $name;
            		$map['addtime'] = time();
            		$res = $userInfo->add($map);
                    $this->success('注册成功', U('Login/login'));
                    session('code', null);
                } else {
                    $this->error($users->getError());
                }
       	}   
	}

	 public function sendMail()
    {
    	$to = I('post.key');
    	$title = "欢迎加入魅族";
    	$rand = mt_rand(100000,999999);
		$content = "本次短信纯属做项目试验! 您的验证码是$rand,验证码在15分钟内有效，回复无效！祝你生活愉快";
		// 2.必须保存生成的验证码
		$code = ['code'=>$rand,'time'=>time()];
		session('code',$code);
        $res = sendMail($to, $title, $content);
        echo json_encode($res);
    }
}