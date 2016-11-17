<?php
namespace Home\Controller;
use Think\Controller;
class ForgetController extends CommonController {
    public function index()
    {
     	$this->display();
    }

	public function savePwd()
	{
		$name = session('name');
	    $user = M('Users');
	    $pwd = I('post.val');
	    $repwd = I('post.key');
	    //echo $pwd;
	    if($pwd == $repwd){
	    	$pass = password_hash($pwd, PASSWORD_DEFAULT);
	    	$res = $user->where("username = '$name'")->setField('pwd', $pass);
	    	if($res){
	    		echo 1;
	    		exit;
	   		 }else{
	    		echo 2;
	    		exit;
	   		 }
	    }
	}    

    public function provingCode()
    {
    	$code = I('post.val');
    	//echo $code;
    	$name = I('post.key');
    	//echo $name;
    	$user = M('Users');

    	$res = $user->where("username='$name'")->find();
    	//echo $user->_sql();
    	//dump($res);
    	$yzm = new \Think\Verify();
    		
    		if ($res && $yzm->check($code)) {
    			session('name', $name);
                echo 1;
                exit;
            }else{
            	echo 2;
            	exit;
            }
    }

    public function sendMail()
    {
    	$to = I('post.val');
    	$title = "【魅族商城】邮箱验证";
    	$rand = mt_rand(100000,999999);
		$content = "【魅族商城】您的验证码是$rand,打死都不要告诉别人(验证码15分钟有效)";
		// 2.必须保存生成的验证码
		$code = ['code'=>$rand,'time'=>time()];
		session('code',$code);
        $res = sendMail($to, $title, $content);
        echo json_encode($res);
        exit;
    }

    public function proving(){
    	$name = session('name');
    	//echo $name;
    	$email = I('post.key');
    	//echo $email;
    	$code = I('post.val');
    	//echo $code;
    	$user = M('Users');
    	$res = $user->where("email = '$email' and username = '$name'")->find();
    	//echo $user->_sql();
    	if($res){
			if (time() - session('code.time') < 900 && $code == session('code.code')){
    			session('code', null);
				echo 1;
				exit;
			}else{
				session('code', null);
				echo 2;
				exit;
			}
    	}else{
    		echo 3;
    		exit;
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
        $Verify->fontSize = 27;         //字体大小
        $Verify->length   = 4;          //验证码个数
        $Verify->useNoise = false;      //关闭杂点
        $Verify->imageH   = 50;
        $Verify->imageW   = 340;
        $Verify->entry();
    }
}