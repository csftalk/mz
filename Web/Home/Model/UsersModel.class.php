<?php
namespace Home\Model;
use Think\Model;

class UsersModel extends Model
{ 
    protected $_validate = [
        ['username', 'require', '用户名不能为空',1],
        ['username','','用户名已经存在！',0,'unique',1],
        ['pwd', 'require', '密码不能为空',],
        //['pwd','repwd','两次密码不一致',0,'confirm'],
        ['email', 'email', '邮箱格式犯法了'],
    ];
	//自动完成
    protected $_auto = [
        ['pwd', 'password_hash', 3, 'callback'],
    ];

    protected function password_hash()
    {
    	$pwd = I('pwd');
    	if($pwd){
    		return password_hash($pwd, PASSWORD_DEFAULT);
    	}
    }
	public function getData()
	{
		$arr = $this->select();
		return $arr;
	}
}