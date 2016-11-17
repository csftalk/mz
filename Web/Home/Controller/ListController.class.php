<?php
namespace Home\Controller;
use Think\Controller;
class ListController extends mainController {

/**
 * 显示商品列表
 */
public function index()
{
	$pid = I('get.pid'); 
	$selectId = $pid;
	$tModel = M('Type');
	$childs = $tModel->where("pid = $pid")->select();
	$m = M();
	if (!$childs) {
		$parent = $m->query("select * from mz_type where id = (select pid from mz_type where id = '$pid') ") ;
		$parent = $parent[0];
		$pid = $parent['id'];
		$childs = $tModel->where("pid = $pid")->select();
	} else {
		$parent = $tModel->where("id = $pid")->find();
	}
	$lever = $parent['name'];
	$parent['name'] = '全部';
	if ($pid != 0) {
		array_unshift($childs, $parent);
	} 
	$cate = $tModel->select();
	$arrId = getChilds($cate, $selectId);
	if ($arrId) {
		$map['tid'] = ['in', $arrId];
		$map['status'] = 2;
		$map['rollback'] = 1;
		$data = M('Goods')->where($map)->join('mz_pic_desc on mz_goods.id = mz_pic_desc.gid')->join('mz_price_store on mz_goods.id = mz_price_store.gid')->group('mz_goods.id')->field('mz_goods.id,mz_goods.name,mz_pic_desc.pic_path,mz_price_store.price')->select();
	} else {
		$data = M('Goods')->where("tid = $selectId and status = 2 and rollback = 1")->join('mz_pic_desc on mz_goods.id = mz_pic_desc.gid')->join('mz_price_store on mz_goods.id = mz_price_store.gid')->group('mz_goods.id')->field('mz_goods.id,mz_goods.name,mz_pic_desc.pic_path,mz_price_store.price')->select();
	}
	
	$this->assign('lever', $lever);//
	$this->assign('category', $childs);
	$this->assign('list', $data);//商品数据
	$this->display();

}



}