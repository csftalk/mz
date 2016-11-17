<?php
namespace Admin\Controller;
use Think\Controller;

class RollBackController extends CommonController {
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
        $map['rollback'] = 2;
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
        $sql = $m->_sql();
        
        $res = json_encode($content);
        echo $res;die;
      
        
    }



    public function rollBack()
    {
       
        $id = I('get.id');
        $res = M('Goods')->where("id = $id")->setField('rollback', 1);
        if ($res) {
            echo 1;
            die;
        } else {
            echo 2;
            die;
        }
    }
    
    
    //ajax删除
    public function del(){
        
        $arrId = I('get.data');
        foreach($arrId as $k =>$v) {
            if ($v=='') {
                unset($arrId[$k]);
            }
        }
       $strId = join(',', $arrId);
       $m = M();
       $pic = $m->query("select pic_path from mz_pic_desc where gid in ($strId) union select pic_path from mz_pic_show where gid in ($strId)");
       foreach ($pic as $key => $value) {
          @unlink('./Public/Uploads/'.$value['pic_path']);
       }
       $res = $m->execute("delete from mz_pic_desc where gid in ($strId)");
       $res = $m->execute("delete from mz_pic_show where gid in ($strId)");
       $res = $m->execute("delete from mz_price_store where gid in ($strId)");
       $res = $m->execute("delete from mz_goods_att where gid in ($strId)");
       $res = $m->execute("delete from mz_goods where id in ($strId)");

        // $res = $m->where($map)->save($data);
        if ($res) {
            echo 1; //表示成功
            die;
        } else {
            echo 2; // 表示失败
            die;
        }
       
        
    }
    

}