<?php
namespace Admin\Controller;
use Think\Controller;


class GoodsAttController extends CommonController
{

    /**
     * 查询产品属性
     */
    public function selectDoodsAtt(){
        $map['gid'] = I('get.id');
        //echo $map['gid'];
        $m = D('GoodsAtt');
        $data  = $m->where($map)->relation(true)->select();
        $list = $m->doData($data);
        
        $this->assign('list', $list);
        $this->display();

    }


}