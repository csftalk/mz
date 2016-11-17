<?php
namespace Home\Controller;
use Think\Controller;
class UserinfoController extends CommonController {
    public function index(){
    	$data = session('userInfo');
    	$id = $data['id'];
    	$userInfo = M('Userinfo');
    	$list = $userInfo->alias('z')->join('__USERS__ as u on u.id = z.uid')->where("z.uid = $id")->find();
    	//var_dump($data);
    	$this->assign('list', $list);
    	$this->display();
    }

    public function Save(){
    	
    		$data = session('userInfo');
    		$id = $data['id'];
    		$map = I('post.val');
    		$res = M('Userinfo')->where("uid = $id")->setField('name', $map);
    			if($res){
    				echo 1;
    				exit;
    			}else{
    				echo 2;
    				exit;
    			}
    }

    public function SavePwd(){
    	$pwd = I('post.pass');
    	$repwd = I('post.repass');
    	$data = session('userInfo');
    	$id = $data['id'];
    	if($pwd == $repwd){
    		$pwd = password_hash($pwd, PASSWORD_DEFAULT);
    		$res = M('Users')->where("id = $id")->setField('pwd', $pwd);
    			if($res){
    				echo 1;
    				exit;
    			}else{
    				echo 2;
    				exit;
    			}
    		exit;
    	}	
    }

	public function SaveEmail(){
		$newEmail = I('post.val');
		$code = I('post.key');
		$data = session('userInfo');
    	$id = $data['id'];
		if(time() - session('NewCode.time') < 900 && $code == session('NewCode.code')){
			$Email = M('Users')->where("id = $id")->setField('email', $newEmail);
			$users = M('Users')->where("id = $id")->find();
			session('userInfo', $users);
			echo 1;
			exit;
		}else if(time() - session('NewCode.time') > 900 || $code != session('NewCode.code')){
			echo 2;
			exit;
		}
		exit;
	}

    public function proveEmail()
    {
    	$proveEmail = I('post.val');

    	if (time() - session('code.time') < 900 && $proveEmail == session('code.code')){
    			session('code', null);
				echo 1;
				exit;
			}else if($proveEmail != session('code.code') || time() - session('code.time') > 900){
				session('code', null);
				echo 2;
				exit;
			}
			exit;
    }

    public function sendMail()
    {
    	$to = session('userInfo.email');
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

     public function sendNewMail()
    {
    	$to = I('post.val');
    	$title = "【魅族商城】邮箱验证";
    	$rand = mt_rand(100000,999999);
		$content = "【魅族商城】您的验证码是$rand,打死都不要告诉别人(验证码15分钟有效)";
		// 2.必须保存生成的验证码
		$code = ['code'=>$rand,'time'=>time()];
		session('NewCode',$code);
        $res = sendMail($to, $title, $content);
        echo json_encode($res);
        exit;
    }

    public function upload()
    {
    	$id = session("userInfo.id");
    	if(IS_POST){
    		
    		//var_dump($id);
    		//exit;
    		$config = array(
		   			'mimes'         =>  array(), //允许上传的文件MiMe类型
		   			'maxSize'       =>  0, //上传的文件大小限制 (0-不做限制)
		   			'exts'          =>  array('jpg', 'gif', 'png', 'jpeg'), //允许上传的文件后缀
		   			'autoSub'       =>  false, //自动子目录保存文件
		   			//'subName'       =>  array('date', 'Y-m-d'), //子目录创建方式，[0]-函数名，[1]-参数，多个参数使用数组
		   			'rootPath'      =>  './Public/Uploads/', //保存根路径
		   			'savePath'      =>  'User/PicHead/',//保存路径
		   	);
		   		$up = new \Think\Upload($config);
		   		$user  = M('Userinfo');
		   		$info = $up->upload();
		   		if($info){ 
		   			$res = $user->where("uid = $id")->field('pic_head')->find();
		   			//var_dump($res);die;
		   			if($res){
						@unlink('./Public/Uploads/Users/head/'.$res['pic_head']);	
		   			}
		   			$path= $info['file']['savepath'].$info['file']['savename'];
		   			
		   			$row = $user->where("uid = $id")->setField('pic_head', $path);
		   			if ($row) { 
		   				$this->redirect('Userinfo/index');
		   			} else { 
		   				$this->error('图片修改失败');
		   			}
		   		} 		
			}else{
				$user  = M('Userinfo');
				$list = $user->where("uid=$id")->find();
		   		//var_dump($list);
		   		//exit;
		   		$this->assign('list', $list);
    			$this->display();
    		}
		}

		public function binding()
		{
			$repwd = I('post.val');
			$pwd = session('userInfo.pwd');
			$res = password_verify($repwd, $pwd);
			if($res){
				echo 1;
				exit;
			}else{
				echo 2;
				exit;
			}
			exit;
		}

			public function savePhone(){
				// ***********************必须先将extension=php_curl扩展打开
				// 接收电话号并且执行发送短信的功能
				// 1.接收电话号码
				$phone = I('post.val');
				//echo $phone;
				// mt_rand()
				$rand = mt_rand(100000,999999);
				$content = "本次短信纯属做项目试验! 您的验证码是$rand,验证码在15分钟内有效，本次短信免费，回复无效！祝你生活愉快";

				// 2.必须保存生成的验证码
				$code = ['code'=>$rand,'time'=>time()];
				session('savePhone',$code);

				// 3.执行发送
				$sms = new \Org\Sms\SmsBao('373185427','373185427');
				$data = $sms->sendSms($phone, $content);
				if($data){
					echo 1;
					exit;
				}else{
					echo 2;
					exit;
				}
				exit;
				// 4.返回数据
				//$this->ajaxReturn($data);
			
		}

		public function identifyingCode(){
			$uid = session('userInfo.id');
			$identifyingCode = I('post.val');
			$phone = I('post.key');
			$user = M('Userinfo');
			if(time() - session('savePhone.time') < 900 && $identifyingCode == session('savePhone.code')){
					$user->where("uid = $uid")->setField('phone', $phone);
					echo 1;
					exit;
				}else {
					echo 2;
					exit;
				}
		}

		public function provingCode()
		{
			$identifyingCode = I('post.val');
			if(time() - session('savePhone.time') < 900 && $identifyingCode == session('savePhone.code')){
					echo 1;
					exit;
				}else {
					echo 2;
					exit;
				}
		}

		public function provingNewCode()
		{

			$uid = session('userInfo.id');
			$phone = I('post.key');
			//echo $phone;
			$identifyingCode = I('post.val');
			$user = M('Userinfo');
			if(time() - session('savePhone.time') < 900 && $identifyingCode == session('savePhone.code')){
					$user->where("uid = $uid")->setField('phone', $phone);
					session('newPhone',null);
					echo 1;
					exit;
				}else {
					echo 2;
					exit;
				}
		}
		
		/*public function savePhoneCode(){
				// ***********************必须先将extension=php_curl扩展打开
				// 接收电话号并且执行发送短信的功能
				// 1.接收电话号码
				$phone = I('post.val');
				//echo $phone;
				// mt_rand()
				$rand = mt_rand(100000,999999);
				$content = "本次短信纯属做项目试验! 您的验证码是$rand,验证码在15分钟内有效，本次短信免费，回复无效！祝你生活愉快";

				// 2.必须保存生成的验证码
				$code = ['code'=>$rand,'time'=>time()];
				session('newPhone',$code);

				// 3.执行发送
				$sms = new \Org\Sms\SmsBao('37318427','373185427');
				$data = $sms->sendSms($phone, $content);
				if($data){
					echo 1;
					exit;
				}else{
					echo 2;
					exit;
				}
				exit;
				// 4.返回数据
				//$this->ajaxReturn($data);
			
		}*/
}