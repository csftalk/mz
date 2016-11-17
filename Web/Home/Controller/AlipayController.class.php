<?php
/**
 * 魅族商城
 * =========================================================================
 * 版权所有:“年年19”开发小组
 * 网站地址: http://mz.7hyd.com
 * -------------------------------------------------------------------------
 * Author: 游安明
 * Date: 2016-11-2
 * =========================================================================
 */
/**
 * 支付宝支付模块
 */
namespace Home\Controller;
use Think\Controller;
class AlipayController extends CommonController {
    public function alipayReturn()
    {
    	//接收支付宝返回的信息
        // dump($_GET);die;
        //查询订单ID的条件
        $where['d.oid'] = I('out_trade_no');

        //写入pay表的数据
        $data['order_id'] = I('out_trade_no');
        $data['buyer_name'] = I('buyer_email');
        $data['buyer_id'] = I('buyer_id');
        $data['notify_time'] = I('notify_time');
        $data['is_success'] = I('is_success');
        $data['total_fee'] = I('total_fee');

        //引入支付宝
        vendor('Alipay.AlipayNotify','','.class.php');
        $config = $config=C('ALIPAY_CONFIG');
        $notify = new \AlipayNotify($config);
        // 验证支付数据
        $status = $notify->verifyReturn();
        if($status){
            //查询订单的ID
            $ordersModel = M('Orders');
            $orders = $ordersModel->alias('o')->field('o.id,d.g_id,d.g_number')->join('left join __ORDERSDATA__ as d on o.id=d.id')->where($where)->find();

            //改变支付状态
            $map['id'] =  $orders['id'];
            $ordersModel->where($map)->setField('pay_status',1);

            //减库存
            $whereGid['gid'] = $orders['g_id'];
            $priceStoreModel = M('priceStore');
            $priceStore = $priceStoreModel->where($whereGid)->find();
            $priceStoreModel->where('id='.$priceStore['id'])->setDec('store', $orders['g_number']);

            //把支付宝返回信息存入数据库
            $payModel = M('Pay');
            $pay = M('Pay')->add($data);

            // 下面写验证通过的逻辑 比如说更改订单状态等等 $_GET['out_trade_no'] 为订单号；
            $this->success('支付成功',U('Home/Order/index'));
        }else{
            $this->success('支付失败',U('Home/Order/index'));
        }
    }

    /**
     * notify_url接收页面
     */
    public function alipayNotify(){
        file_put_contents('./notify.txt', json_encode($_POST));
        // 引入支付宝
        vendor('Alipay.AlipayNotify','','.class.php');
        $config = C('ALIPAY_CONFIG');
        $alipayNotify = new \AlipayNotify($config);
        // 验证支付数据
        $verify_result = $alipayNotify->verifyNotify();
        if($verify_result) {
            echo "支付成功！";
            // 下面写验证通过的逻辑 比如说更改订单状态等等 $_POST['out_trade_no'] 为订单号；
            //查询订单的ID
            $ordersModel = M('Orders');
            $orders = $ordersModel->alias('o')->field('o.id')->join('left join __ORDERSDATA__ as d on o.id=d.id')->where($where)->find();
            $map['id'] =  $orders['id'];
            $ordersModel->where($map)->setField('pay_status',1);
            $payModel = M('Pay');
            $pay = M('Pay')->add($data);
                         
        }else {
            echo "支付失败！";
        }
    }

    public function index()
    {
        // dump($_POST);die;
        $where['o.id'] = I('pay');
        $res = M('Orders');
        $orders = $res->alias('o')->join('left join __ORDERSDATA__ as d on o.id=d.id')->where($where)->find();

    	$arr['out_trade_no'] = $orders['oid']; //订单号
    	$arr['price'] = $orders['price'];      //商品价格
    	$arr['subject'] = $orders['g_name'].$orders['g_attr_str'];  //商品名称
        $arr['gid'] = $orders['g_id'];    //商品id
        // dump($arr);die;
        // $arr['out_trade_no'] = 112121212;
        // $arr['price'] = 0.1;
        // $arr['subject'] ='魅蓝 Max';
    	alipay($arr);
    }
   
}