<?php
namespace Admin\Controller;
use Think\Controller;


class GoodsController extends CommonController
{
    //显示商品列表   
    public function index()
    {
        //
         //载入添加分类页面
        //获取所有分类
        $res = D('Type')->getTree();

        $this->assign('list', $res);

        $this->display(); // 输出模板
    }
    
    
    
    //ajax显示商品列表
    public function select(){

        $map['status'] = (!empty(I('get.status')))?I('get.status') : 0;
        $map['tid'] = (!empty(I('get.tid')))?I('get.tid') : 0;
        $search = (!empty(I('get.search')))?I('get.search') : '';

        if (!$map['status']) {
            unset($map['status']);
        }
        if (!$map['tid']) {
            unset($map['tid']);
        }
        if (!$search) {
            unset($search);
        }
        $map['name'] = ['like', "%$search%"];
        $map['rollback'] = 1;
        $m = D('Goods');
        $count = $m->where($map)->count();
        $list = $m->where($map)->relation(true)->select();
        $pModel = M('PicDesc');
        foreach ($list as $key => $value) {
                $where['gid'] = $value['id'];
                $data = $pModel->where($where)->find();
                $list[$key]['pic'] = $data['pic_path'];

        }
        $this->assign('list',$list);
        
        $content[]= $this->fetch('select');
        $content[] = $count;
        $res = json_encode($content);
        echo $res;die;
      
        
    }




    //ajax删除(回收站)
    public function del(){
        $arrId = I('get.data');
        foreach($arrId as $k =>$v) {
            if ($v=='') {
                unset($arrId[$k]);
            }
        }
        $map['id']  = array('in',$arrId);
        $data['rollback'] = 2;
        $m = M('Goods');
        $res = $m->where($map)->save($data);
        if ($res) {
            echo 1; //表示成功
            die;
        } else {
            echo 2; // 表示失败
           die;
        }
       
        
    }
    
    //显示添加商品页面
    public function add(){
        
       //载入添加分类页面
        //获取所有分类
        $res = D('Type')->getTree();

        $this->assign('list', $res);

        $this->display(); // 输出模板
    }
    

    //ajax加载商品属性
    public function selectAtt(){
         $map['tid'] = I('get.typeid');
        //$map['tid'] = 1;
        $list =  M('TypeAtt')->where($map)->select();

        //$this->assign('list', $list);
        foreach ($list as $k=>$v) {
            if ($v['is_only'] == 2) {
                $list[$k]['value'] = explode(',', $v['value']);
            }
        }
       
        $this->assign('list', $list);
        $content = $this->fetch();
        
        echo json_encode($content);
        die;
    }



    //添加商品和属性
    public function doAdd()
    {
        
        
        $gModel = D('Goods');
        $gModel->startTrans(); //开启Goods事务
        $data = $gModel->create();
        $gId = $gModel->add($data);
        if (!$gId) {
            $this->success($gModel->getError());
            die;
        }
        $pData = I('post.');    
        $goodsAttModel = D('GoodsAtt');
        $Adata = $goodsAttModel->getAtt($pData);
         $goodsAttModel->startTrans();
        $flag = flase;
        foreach ($Adata as $key => $value) {
            $value['gid'] =$gId; 

            $flag = $goodsAttModel->add($value);
        }
        if ($flag) {

            $gModel->commit(); 
            $goodsAttModel->commit(); 
            $this->success('添加商品成功！！', U('Goods/index'));
        } else {

            $gModel->rollback();
            $goodsAttModel->rollback();
             $this->success($gModel->getError());
        }
        
    }


    
    /**
     * 修改产品状态
     */
    public function modify()
    {
        
        $map['id']  = I('get.id');
        $data['status'] = I('get.status');
        $m = M('Goods');
        $res = $m->where($map)->save($data);
        if ($res) {
            echo 1; //表示成功
            die;
        } else {
            echo 2; // 表示失败
            die;
        }
    }

}