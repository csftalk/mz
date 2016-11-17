<?php
/**
 * 魅族商城
 * =========================================================================
 * 版权所有:“年年19”开发小组
 * 网站地址: http://mz.7hyd.com
 * -------------------------------------------------------------------------
 * Author: 陈盛富
 * Date: 2016-10-17
 * =========================================================================
 */
namespace Admin\Controller;
use Think\Controller;

class TypeAttController extends CommonController {

    /**
     * 显示某个类型的属性
     */
    public function index()
    {
       
            
         //  $_GET['id'] = 1;
            $tModel = M('type');
            $tMap['id'] = I('get.id');
            $typeName = $tModel->where($tMap)->field('id,name')->find();
           
    	$model = M('type_att');
    	$map['tid'] = I('get.id');
    	$res = $model->where($map)->select();
            
            $this->assign('typename', $typeName['name']);
            $this->assign('typeid', $typeName['id']);
       	$this->assign('list', $res);
       	$this->display();
    }

    /**
     * 添加某个类型的属性
     */
    public function add()
    {

            $tModel = M('Type');
            $tMap['id'] = I('get.id');
            $typeName = $tModel->where($tMap)->field('id,name')->find();
            $model = M('type_att');
            $map['tid'] = I('get.id');
            $res = $model->where($map)->select();
           if (IS_POST) {
              $model = D('type_att');
             $data = $model->create($_POST, 1);
            if (!$data) {
                $this->error($model->getError());
                exit;
            }
            if ($model->is_only == '1') {
                unset($model->value);
            }
            
            $res  = $model->add();
            // dump($res);die;
            if ($res) {
                $this->success('添加属性成功', U('index', ['id' => I('get.id')]));
            } else {
                $this->error('添加属性失败'.$model->getError());
            }
           
        } else {
        
            $tModel = M('type');
            $tMap['id'] = I('get.id');
            

            $typeName = $tModel->where($tMap)->field('id,name')->find();
            
            $this->assign('typename', $typeName['name']);
            $this->assign('typeid', $typeName['id']);
           $this->display();
        }
    }


    /**
     * 修改某个类型的属性（考虑）
     */
    public function save()
     {
       
       if (IS_POST) {
            $data['key'] = I('post.key');
            $data['is_only'] = I('post.is_only');
            $data['value'] = I('post.value');
            $data['id'] = I('get.id');
            
            $model = M('type_att');
            $data = $model->create($data);
            $res = $model->save();
            if ($res) {
                $this->success('修改成功！', U('TypeAtt/index'));
            } else {
                $this->error('修改属性失败！');
            }
           
       } else {
           $model = D('type_att');
           // $data = $model->create($_POST, 2);
           $map['id'] = I('get.id');
           $data = $model->where($map)->relation(true)->find();
           //dump($data);
           $this->assign('data', $data);
           $this->display() ;
       }
       
    }


    /**
     * 删除某个类型的属性
     */
    public function del()
    {   
        $id = I('get.id');
        $model = M('type_att');
        $res = $model->delete($id);
        if ($res) {
            echo 1;
        } else {
            echo 2;
        }
        
    }

}