<?php
namespace Home\Controller;
use Think\Controller;
class IndexController extends mainController {
    public function index()
    {
      $data = S('data');
      $sData = S('sData');
      if (!$data || !$sData) {
      	
      	      $tModel = M('Type');
	      $data =   $tModel->where('pid = 0')->field('id,name')->select();
	      $cate =   $tModel->select();
	     // var_dump($data);
	      $arr = [];
	      foreach ($data as $k=>$v) {
	        $arr[] = getChilds($cate, $v['id']);//获取所有子分类id
	      }
	     // var_dump($arr);
	     $gModel = M('Goods');

	     foreach ($arr as $k=>$v) {
	      $map['mz_goods.tid'] =['in', $v]; 
	      $map['mz_goods.status'] =2; 
	      $map['mz_goods.rollback'] =1; 
	      $data1 = $gModel->where($map)->join('mz_pic_desc on mz_goods.id = mz_pic_desc.gid')->group('mz_goods.id')->limit(10)->field('mz_goods.id,mz_goods.name,mz_pic_desc.pic_path')->select();
	      $data1 =array_chunk($data1, 5);
	      $data[$k]['data1'] = $data1[0];
	      $data[$k]['data2'] = $data1[1];
	     }
	     
	     $sData = M('System')->where('id in (2,3,4,5,6)')->order('course')->select();
	     foreach ($sData as $key => $value) {
	        if (in_array('', $value)) {
	          unset($sData[$key]);
	        }
	     }
	     S('sData',$sData,array('type'=>'file','expire'=>300));
	     S('data',$data,array('type'=>'file','expire'=>300));





      }

      

     $this->assign('sData', $sData);
     $this->assign('list', $data);
      $this->display();
    }


    public function test()
    {
      dump($_POST);
    }
}