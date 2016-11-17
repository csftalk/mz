<?php
namespace Admin\Controller;
use Think\Controller;

class PriceStoreController extends Controller
{
	/**
	 * 显示价格和库存
	 */
	public function index()
	{
		$id = I('get.id'); //产品id //查询商品属性表
		
		$m = M();
		$aidArr = [];
		$data = [];
		$ch = [];
		
		$aidData = $m->query("select aid,count(id) as co from mz_goods_att where gid = {$id} group by aid having co > 1");
		
		if (empty($aidData)){
			$this->assign('list',$data);
			$this->assign('gid', $id);
			$this->display('index1');
			die;

		} else {
			foreach ($aidData as $key => $value) {
				$aidArr[] = $value['aid'];
			}
			foreach ($aidArr as  $value) {
				$ci = $m->query("select `key` from mz_type_att where id = {$value}");
				$ch[] = $ci[0]['key']; 

				$data[] = $m->query("select id,aid,value from mz_goods_att where aid = {$value} and gid = {$id}");
			}
			// $m->query("select id,aid,value where aid");
			$this->assign('keyList', $ch);
			$this->assign('list',$data);
			$this->assign('gid', $id);
			$this->display();
		}
		
		
		
		
	}


	/**
	 * ajax添加价格、库存
	 */
	public function add()
	{
		$data= I('post.');
		if ($data['gid'] =='') {
			echo 'gid不存在';
			exit;
		}
		
		$where['gid'] = $data['gid'];
		$where['att_id'] = $data['att_id'];
		$m = D('PriceStore');
		$flag = $m->where($where)->select();
		if ($flag) {
			$res[] = 2; //表示失败
			$res[] = '此属性产品已存在，请选择其他属性！！';//失败信息
			echo  json_encode($res);
			die;

		}
		$data['att_id'] = explode(',' ,$data['att_id']);
		sort($data['att_id']);
		$data['att_id'] = join(',', $data['att_id']);
		$flag = $m->create($data);
		$res = [];
		if (!$flag) {
			$res[] = 2; //表示失败
			$res[] = $m->getError();//失败信息
			echo  json_encode($res);
			die;
		}
		if ($m->add()) {
			$res[] = 1;//表示成功
			echo  json_encode($res);
			die;
		} else {
			$res[] = 2; //表示失败
			$res[] = '添加失败';
 			echo  json_encode($res);
			die;
		}

	}

	/**
	 * ajax查看产品现有属性的价格、库存
	 */
	public function select(){
		$map['gid'] = I('get.gid');
		$m = M('PriceStore');
		$data = $m->where($map)->select();
		if ($data[0]['att_id'] == '默认') {
		    $data[0]['att_id'] = '默认';
		    $this->assign('list', $data);
		    $content = $this->fetch();
		    echo $content;
		    die;
		}
		$data1 = $data;
		$arrId = [];
		foreach ($data as $key => $value) {
			$arr = explode(',', $value['att_id']);
			foreach ($arr as  $v) {
				$arrId[] = $v;
			}

		}
		$arrId = array_unique($arrId);
		
		$where['id'] = ['in',$arrId];
		$data = M('GoodsAtt')->where($where)->select();
		$arrAtt = [];
		foreach ($data as $k=> $v) {
			$arrAtt[$v['id']] = $v['value'];
		}

		foreach ($data1 as $key => $value) {
			$arr = explode(',', $value['att_id']);
			foreach ($arr as  $v) {
				$data1[$key]['att'] .=$arrAtt[$v].',';
			}

		}
		foreach ($data1 as $key => $value) {
			$data1[$key]['att'] = rtrim($value['att'],',');
		}
		
		$this->assign('list', $data1);
		$content = $this->fetch();
		echo $content;
		die;

		
	}



	   //ajax删除
    public function del(){
        
        $id = I('get.id');
        
        $map['id']  = $id;
        $m = M('PriceStore');
        $res = $m->where($map)->delete();
        $where['pid'] = $id ;
        $res = M('PicDesc')->where($where)->select();
        foreach ($res as $key => $value) {
	@unlink('./Public/Uploads/'.$value['pic_path']);
	}
         $res = M('PicDesc')->where($where)->delete();
        
        if ($res) {
            echo 1; //表示成功
            die;
        } else {
            echo 2; // 表示失败
            die;
        }      
    }



/**
 * ajax修改price
 */
public function price()
{
	$data = I('get.');
	$id = $data['id'];
	$price = $data['price'];
	$res = M('PriceStore')->where("id = $id")->setField('price', $price);
	if ($res) {
		echo 1; exit;
	} else {
		echo 2; exit;
	}
}


/**
 * ajax修改price
 */
public function store()
{
	$data = I('get.');
	$id = $data['id'];
	$price = $data['store'];
	$res = M('PriceStore')->where("id = $id")->setField('store', $price);
	if ($res) {
		echo 1; exit;
	} else {
		echo 2; exit;
	}
}



}