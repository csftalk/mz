<?php
namespace Admin\Controller;
use Think\Controller;
use Think\Page;

class AdminUsersController extends CommonController {
    public function index()
    {
    	if (IS_POST){ 
			
			$search = I('post.search');
			//$search = (!empty(I('get.search')))?I('get.search') : '';

			if (empty($search)) { 
				unset($search);
			}
			$map['username'] = ['like', "%$search%"];
			$model = M('Adminusers');
			$count = $model->where($map)->count();
			$list = $model->where($map)->select();
			$this->assign('list', $list);
			$content[] = $this->fetch('Adminusers:select');
			$content[] = $count;

			echo json_encode($content);
		} else { 
			
			$this->display();
		}
    }
    public function add()
    {
        if (IS_POST) {
            $users = D('Adminusers');
            $data = $users->create();
            
        if ($data) {
                $res = $users->add($data);
                if ($res) {
                    $this->success('添加成功', U('Adminusers/index'));
                } else {
                    $this->error('添加失败');
                }
            } else {
                $this->error($users->getError());
                // echo $users->getError();
            }
        } else {
            $this->display();
        }    
    }
    public function del(){
        
        $arrId = I('get.data');
        foreach($arrId as $k =>$v) {
            if ($v=='') {
                unset($arrId[$k]);
            }
        }
        $map['id']  = array('in',$arrId);
        $m = M('Adminusers');
        $res = $m->where($map)->delete();
        if ($res) {
            echo 1; //表示成功
        } else {
            echo 2; // 表示失败
        }
}

    public function update()
    {
        $this->display();
    }

    public function assignRole()
    {
    	if (IS_POST){ 
			
			$search = I('post.search');
			//$search = (!empty(I('get.search')))?I('get.search') : '';

			if (empty($search)) { 
				unset($search);
			}
			$map['username'] = ['like', "%$search%"];
			$users = M('UsersRole');
    		$res = $users->alias('z')->join('__ADMINUSERS__ as u on u.id=z.uid')->join('__ROLE__ as r on r.id=z.rid')->select();
    		//var_dump($res);
    		//$Model->join('__WORK__ ON __ARTIST__.id = __WORK__.artist_id')->join('__CARD__ ON __ARTIST__.card_id = __CARD__.id')->select();
    		$this->assign('list', $res);
			$count = $users->count();
			$content[] = $this->fetch('Adminusers:selectrole');
			$content[] = $count;

			echo json_encode($content);
		} else { 
			
    		//var_dump($res);
			$this->display();
		}
    	
    }

    public function assignAdd(){
    	if(IS_POST){
			$data['uid'] = $_POST['uid'];
	    	$data['rid'] = $_POST['rid'];
	    	if (M('users_role')->add($data)) {
                    $this->success('添加成功', U('Adminusers/assignRole'));
                }else{
                	$this->error('修改失败');
                }
    	}else{
    		$user = M('Adminusers')->select();
	    	$role = M('Role')->select();
	    	$this->assign('list', $user);
	    	$this->assign('arr', $role);
			$this->display();
    	}
    	
    	
    }

    public function assignDel($id){
    	if(M('users_role')->where(['uid'=>$id])->delete()){
    		$this->success('删除成功', U('Adminusers/assignRole'));
    	}else{
    		$this->error('删除失败');
    	}
    }

    public function assignSave($id)
    {
    	if(IS_POST){
    		//var_dump($_POST);
    		M('users_role')->where(['uid'=>$id])->delete();

    		foreach (I('post.role') as $v) {
                $data['uid'] = $id;
                $data['rid'] = $v;
                if (!M('users_role')->add($data)) {
                    $this->error('修改失败');
                }
            }
            $this->success('修改成功', U('Adminusers/assignRole'));
				
            
    	}else{
			$role = M('Role');
	    	$res = $role->select();
	    	$roleId = M('users_role')->where(['uid'=>$id])->getField('rid', true);
	    	$this->assign('roleId', $roleId);
	    	$this->assign('id', $id);
	    	$this->assign('list', $res);
	    	$this->display();
    	}
    	
    }

    public function permission()
    {
    	if (IS_POST){ 
			
			$search = I('post.search');
			//$search = (!empty(I('get.search')))?I('get.search') : '';

			if (empty($search)) { 
				unset($search);
			}
			$map['desc'] = ['like', "%$search%"];
			$model = M('Node');
			$count = $model->where($map)->count();
			$list = $model->where($map)->select();
			$this->assign('list', $list);
			$content[] = $this->fetch('Adminusers:selectnode');
			$content[] = $count;

			echo json_encode($content);
		} else { 
			
			$this->display();
		}
    	
    }

    public function permissionAdd(){
    	if(IS_POST){
    		$data['name'] = $_POST['name'];
    		$data['desc'] = $_POST['desc'];
    		$permission = M('Node')->add($data);
    		if($permission){
    			$this->success('添加成功', U('Adminusers/permission'));
    		}else{
    			$this->error('添加失败');
    		}
    	}else{
			$this->display();
    	}  
    	
    }

    public function permissionDel($id){
    	$permission = M('Node')->delete($id);
    	if ($permission) {
    		$this->success('删除成功', U('Adminusers/permission'));
    	}else{
    		$this->error('删除失败');
    	}
    }

    public function distriBute(){
    	if (IS_POST){ 
			
			$search = I('post.search');
			//$search = (!empty(I('get.search')))?I('get.search') : '';

			if (empty($search)) { 
				unset($search);
			}
			$map['name'] = ['like', "%$search%"];
			$model = M('Role');
			$count = $model->where($map)->count();
			$list = $model->where($map)->select();
			$this->assign('list', $list);
			$content[] = $this->fetch('Adminusers:selectBute');
			$content[] = $count;

			echo json_encode($content);
		} else { 
			
			$this->display();
		}
    }

    public function distriSave($id){
    	if(IS_POST){
            M('role_node')->where(['rid'=>$id])->delete();

    		foreach (I('post.role') as $v) {
                $data['rid'] = $id;
                $data['nid'] = $v;
                if (!M('role_node')->add($data)) {
                    $this->error('修改失败');
                }
            }
            $this->success('修改成功', U('Adminusers/distriBute'));
    	}else{
			$role = M('Node');
	    	$res = $role->select();
	    	$roleId = M('role_node')->where(['rid'=>$id])->getField('nid',true);
	    	$this->assign('roleId', $roleId);
	    	$this->assign('id', $id);
	    	$this->assign('list', $res);
	    	$this->display();
    	}
    }

    public function distriAdd(){
    	if(IS_POST){
    		$data = $_POST;
    		$res = M('Role')->add($data);
    		if($res){
    			$this->success('添加成功', U('Adminusers/distriBute'));
    		}else{
    			$this->error('添加失败');
    		}
    	}else{
    		$this->display();
    	}
    }

    public function distriDel($id){
    	$res = M('Role')->delete($id);
    	if($res){
    		$this->success('删除成功', U('Adminusers/distriBute'));
    	}else{
    		$this->error('删除失败');
    	}
    }
    public function saveStop(){
    	$stopId = I('data');
    	$users = M('Adminusers');
    	$res = $users->where("id = $stopId")->setField('state', 2);
    	if($res){
    		echo 1;
    		exit;
    	}else{
    		echo 2;
    		exit;
    	}
    	exit;
    }

    public function saveStart(){
    	$stopId = I('data');
    	$users = M('Adminusers');
    	$res = $users->where("id = $stopId")->setField('state', 1);
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