<?php
namespace Admin\Controller;
use Think\Controller;
use Think\Page;
class UsersController extends CommonController {
    public function index()
    {
    		if (IS_POST){ 
			
			$search = I('post.search');
			//$search = (!empty(I('get.search')))?I('get.search') : '';

			if (empty($search)) { 
				unset($search);
			}
			$map['username'] = ['like', "%$search%"];
			$model = M('Users');
			$count = $model->where($map)->count();
			$list = $model->where($map)->select();
			$this->assign('list', $list);
			$content[] = $this->fetch('Users:select');
			$content[] = $count;

			echo json_encode($content);
		} else { 
			
			$this->display();
		}
    }
    public function add()
    {
        if (IS_POST) {
            $users = D('Users');
            $data = $users->create();

        if ($data) {
                $res = $users->add($data);
                if ($res) {
                    $this->success('添加成功', U('index'));
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
    public function del($id){
    	$userInfo = M('Userinfo');
    	$row = $userInfo->where("uid = $id")->delete();
    	//var_dump($row);
        $user = M('Users');
        $res = $user->delete($id);
        if($res || $row){
        	$this->success('删除成功', U('Users/index'));
        }else{
        	$this->error('删除失败');
        }
	}
	public function save($id){
		if(IS_POST){
			$model = M('Users')->where("id = $id")->find();
			$data['uid'] = $id;
			$data['name'] = I('post.name');
			$data['phone'] = I('post.phone');
			$data['sex'] = I('post.sex');
			$data['qq'] = I('post.qq');
			$map['email'] = I('post.email');
			$map['username'] = $model['username'];
			$map['pwd'] = $model['pwd'];
			$user = M('Userinfo');
			$res = $user->where("uid = $id")->save($data);
			$row = M('Users')->where("id = $id")->save($map);
			//var_dump($map);
			if($res || $row){
				//echo $user->_sql();
				$this->success('修改成功');
			}else{
				$this->error('修改失败');
				//echo $user->_sql();
			}
		}else{
			$users = M('Users');
			//$arr = $users->where("id=$id")->find();
			//var_dump($arr);
			$res = $users->alias('u')->join('__USERINFO__ as i on i.uid = u.id')->where("uid=$id")->find();
			//var_dump($res);
			$this->assign('list', $res);
			$this->display();
		}
		
	}

	public function check($id){
		$users = D('Users');
		$res = $users->alias('u')->join('__USERINFO__ as i on i.uid = u.id')->where("uid=$id")->select();
		//var_dump($res);
		$res = $users->dispose($res);
		$this->assign('list', $res);
		$this->display();
	}
	public function saveStatus(){
		$saveId = I('data');
		$users = M('Users');
		$arr = $users->where("id = $saveId")->setField('status',2);
		if($arr){
			echo 1;
			exit;
		}else{
			echo 2;
			exit;
		}
		exit;
	}

	public function saveStart(){
		$startId = I('data');
		$users = M('Users');
		$arr = $users->where("id = $startId")->setField('status',1);
		
		if($arr){
			echo 1;
			exit;
		}else{
			echo 2;
			exit;
		}
		exit;
	}
	
}