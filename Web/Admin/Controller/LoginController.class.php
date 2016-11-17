<?php
namespace Admin\Controller;
use Think\Controller;
use Think\Page;
class LoginController extends Controller {
    public function login()
    {
        if(IS_POST){
            $map['username'] = I('username');
            
            $info = M('Adminusers')->where($map)->find();
            $res = password_verify(I('pwd'), $info['pwd']);
            if($res && $info['state'] == 1){
                session('adminInfo', $info);
                $roleId = join(',', M('UsersRole')->where('uid='.$info['id'])->getField('rid', true));

                //2、根据查出来的角色ID，获取该用户所能拥有的节点ID
                $nodeId = join(',', M('RoleNode')->where('rid in ('.$roleId.')')->getField('nid', true));

                //3、根据nodeId查询出所有的节点名
                $res = M('Node')->where('id in('.$nodeId.')')->getField('name', true);
                
                //4、将查出来的节点名，放入session中
                
                $res[] = 'Index/index';
                session('nodeList', $res);



                $this->success('登陆成功', U('index/index'));
            }else if($info['state'] != 1){
                $this->error('您无权限进入后台,请联系超级管理员');
            }else{
            	$this->error('账号或密码错误');
            }
        }else{
            $this->display();
        }
        
    }
    public function logout()
    {
        session('adminInfo', null);
        $this->redirect('login');
    }
}
