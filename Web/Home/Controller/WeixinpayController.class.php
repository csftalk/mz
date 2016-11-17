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
 * 微信扫码支付模块
 */
namespace Home\Controller;
use Think\Controller;
class WeixinpayController extends CommonController {
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
        $config=$config=C('ALIPAY_CONFIG');
        $notify=new \AlipayNotify($config);
        // 验证支付数据
        $status=$notify->verifyReturn();
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
    public function notify()
    {
        $where['d.oid'] = I('out_trade_no');
        //导入微信支付sdk
        Vendor('Weixinpay.Weixinpay');
        $wxpay=new \Weixinpay();
        $result=$wxpay->notify();
        if ($result) {
            // 验证成功 修改数据库的订单状态等 $result['out_trade_no']为订单id
            
             
        }
    }

    public function index()
    {

        $where['o.id'] = I('id');
        $res = M('Orders');
        $orders = $res->alias('o')->join('left join __ORDERSDATA__ as d on o.id=d.id')->where($where)->find();
        // dump($orders);die;
        
        $arr['body']            = $orders['g_name'].$orders['g_attr_str'];  //商品名称
        $arr['out_trade_no']    = $orders['oid'];                           //订单号
        //微信支付货币传值是以分为单位，奇葩企鹅
        $arr['total_fee']       = intval($orders['price'] * 100);           //订单金额
        $arr['product_id']      = intval($orders['g_id']);                  //产品id
        // 订单 必须包含支付所需要的参数 body(产品描述)、total_fee(订单金额)、out_trade_no(订单号)、product_id(产品id)
        // ob_clean();
        weixinpay($arr);
        // $this->display('Order/weinxinpay');
    }
    public function qrcode()
    {
        $this->assign('id', I('id'));
        $this->display('Order/weinxinpay');
    }

       
        // echo 21323;
        // $erweima = [];
        // echo 12312;
        // echo "<div style=\"margin:50px\">312321321".weixinpay($arr)."<\/div>";
        // if ($aa) {
        //     session('erweima', $aa);  
        // }

        
}



    // public function makeQRcode()
    // {
    //     $where['o.id'] = I('id');
    //     $res = M('Orders');
    //     $orders = $res->alias('o')->join('left join __ORDERSDATA__ as d on o.id=d.id')->where($where)->find();
    //     $arr['body']            = $orders['g_name'].$orders['g_attr_str'];  //商品名称
    //     $arr['out_trade_no']    = $orders['oid'];                           //订单号
    //     $arr['total_fee']       = intval($orders['price'] * 100);           //订单金额
    //     $arr['product_id']      = intval($orders['g_id']);  

    //     weixinpay($arr);         
    // }