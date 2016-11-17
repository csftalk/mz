<?php
namespace Admin\Controller;
use Think\Controller;

class PicShowController extends CommonController
{	
	/**
	 * 显示产品展示图
	 */
	public function index()
	{	
		$gid = I('get.id');
		$m = M('PicShow');
		$map['gid'] = $gid;
		$data = $m->where($map)->order('sort')->select();
		$this->assign('gid', $gid);
		$this->assign('list', $data);
		$this->display();
		
	}

	//产品展示图添加
	public function add()
	{
		$gid = I('get.gid');
		if (IS_POST){
			
			if ($_FILES['file']['name'] == '') {
				$this->error('请选择展示图片', U('add', "gid=$gid"));
				die;
			}
			if (I('post.sort') == '') {
				$this->error('请输入图片排序', U('add', "gid=$gid"));
				die;
			}
			$config = array(
		   				'mimes'         =>  array(), //允许上传的文件MiMe类型
		   				'maxSize'       =>  0, //上传的文件大小限制 (0-不做限制)
		   				'exts'          =>  array('jpg', 'gif', 'png', 'jpeg'), //允许上传的文件后缀
		   				'autoSub'       =>  false, //自动子目录保存文件
		   				//'subName'       =>  array('date', 'Y-m-d'), //子目录创建方式，[0]-函数名，[1]-参数，多个参数使用数组
		   				'rootPath'      =>  './Public/Uploads/', //保存根路径
		   				'savePath'      =>  'Goods/Show/',//保存路径
		   			  
		   		);
			$up = new \Think\Upload($config);
			$info =  $up->uploadOne($_FILES['file']);
			
			if ($info){
				$m = M('PicShow');
				$data['gid'] = $gid;
				$data['pic_path'] = $info['savepath'].$info['savename'];
				$data['sort'] = I('post.sort');
				$res = $m->data($data)->add();
				
				if ($res) {
					$this->success('添加展示图片成功！！', U('index', "id=$gid"));
				} else{	
					@unlink('./Public/Uploads/'.$data['pic_path']);
					$this->error('添加展示图片失败！！', U('add', "gid=$gid"));
				}


			}else{
				$this->error($up->getError(), U('add', "gid=$gid"));
			}
		} else {
			$this->assign('gid', $gid);
			$this->display();
		}
	}


	/**
	 * 产品展示图删除
	 */
	public function del()
	{
		$id = I('get.id');
		$m = M('PicShow');
		$data = $m->where("id=$id")->find();
		$res = @unlink('./Public/Uploads/'.$data['pic_path']);
		if ($res) {
			$res = $m->delete($id);
			if ($res) {
				echo 1;//表示成功
				die;
			} else{
				echo 2;
				die;
			}
		} else {
			echo 2; //表示失败
			die;
		}
 	}

 	/**
 	 * 修改排序
 	 */
 	public function save()
 	{
 		$map['id'] = I('get.id');
 		$data['sort'] = I('get.sort');
 		$m = M('PicShow');
 		$res = $m->where($map)->save($data);
 		if ($res) {
 			echo 1;//修改成功
 			die;
 		} else {
 			echo 2;//修改失败
 			die;
 		}

 	}
}