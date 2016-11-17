<?php
namespace Admin\Controller;
use Think\Controller;

class PicDescController extends CommonController
{
	//显示产品图片
	public function index()
	{
		// $id = I('get.id');
		$gid=I('get.gid');

		
		$pid = I('get.id');
		$m = M('PicDesc');
		
		$map['pid'] = $pid;
		$list = $m->where($map)->select();
		$this->assign('gid', $gid);
		$this->assign('pid', $pid);
		$this->assign('list', $list);
		$this->display();
	}


	//添加属性产品图片
	public function add()
	{	
		
		if (IS_POST) {
			
			$pid  = I('get.pid');
			$gid = I('get.gid');
			
			foreach ($_FILES as $key => $value) {
				if ($value['name'] == '') {
					$this->error('必须选择4张图片！！！', U('add', "pid=$pid&gid=$gid"));
				die;	
				}
			}
			
			$config = array(
		   				'mimes'         =>  array(), //允许上传的文件MiMe类型
		   				'maxSize'       =>  0, //上传的文件大小限制 (0-不做限制)
		   				'exts'          =>  array('jpg', 'gif', 'png', 'jpeg'), //允许上传的文件后缀
		   				'autoSub'       =>  false, //自动子目录保存文件
		   				//'subName'       =>  array('date', 'Y-m-d'), //子目录创建方式，[0]-函数名，[1]-参数，多个参数使用数组
		   				'rootPath'      =>  './Public/Uploads/', //保存根路径
		   				'savePath'      =>  'Goods/Desc/',//保存路径
		   			  
		   		);
			$up = new \Think\Upload($config);
			$m  = M('PicDesc');
			$data['pid'] = $pid;
			$data['gid'] = $gid;
			$info   =   $up->upload();
			$i = 1;
			if ($info) {
				$res = $m->where($data)->select();
				foreach ($res as $key => $value) {
					@unlink('./Public/Uploads/'.$value['pic_path']);
				}
				$res = $m->where($data)->delete();

				foreach ($info as $key => $value) {
					$data['pic_path'] = $value['savepath'].$value['savename'];
					$data['sort'] = $i;
					$res = $m->data($data)->add();
					
					if (!$res) {
						$this->error($m->getError());
						die;
					}
					$i++;

				}
				$this->success('新增/修改成功', U('index', "gid=$gid&id=$pid"));
			} else {
				$this->error($up->getError());
			}
			
		} else {
			$pid = I('get.pid');
			$gid = I('get.gid');
			
		 	$this->assign('pid', $pid);
		 	$this->assign('gid', $gid);

			$this->display();
		}
	}
}
