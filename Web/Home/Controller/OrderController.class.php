<?php
/**
 * 魅族商城
 * =========================================================================
 * 版权所有:“年年19”开发小组
 * 网站地址: http://mz.7hyd.com
 * -------------------------------------------------------------------------
 * Author: 游安明
 * Date: 2016-10-25
 * =========================================================================
 */
namespace Home\Controller;
use Think\Controller;
class OrderController extends CommonController {

    //显示用户订单信息
    public function index()
    {
        if (session('?userInfo')) {
            $id = $_SESSION['userInfo']['id'];

            //查询带搜索
            $oid = I('oid') ? I('oid') : '';
            $post_id = I('post_id') ? I('post_id') : '';
            
            $map['oid'] = array('like', "%$oid%");
            $map['post_id'] = array('like',"%$post_id%");
            $map['o.uid'] = $id;
            $map['_logic'] = 'AND';

            $res = D('Admin/Orders');

            $total = $res->alias('o')->field('d.oid, o.post_id')->where($map)->join('left join __ORDERSDATA__ as d on o.id=d.id')->count();

            //实例化自定义分页类
            $page = new \Org\Yam\Page($total, C('PAGE_NUM'));
            $orders = $res->alias('o')->order('addtime desc')->join('left join __ORDERSDATA__ as d on o.id=d.id')->where($map)->limit($page->firstRow.','.$page->listRows)->ordersStr();
            $btn = $page->show();

            // dump($orders);die;

            $this->assign('orders', $orders);
            $this->assign('btn', $btn);
            $this->display();

        } else {
            $this->redirect('Login/login');
        }   
    }

    public function details()
    {
        if (session('?userInfo')) {
            $where['o.id'] = I('id');
            $res = D('Admin/Orders');
            $orders = $res->alias('o')->join('left join __ORDERSDATA__ as d on o.id=d.id')->where($where)->ordersStr();
            $this->assign('orders', $orders);
            $this->display();
        } else {
            $this->redirect('Login/login');
        }
    }

    //地址管理
    public function address()
    {
        if (session('?userInfo')) {
            $where['uid'] = $_SESSION['userInfo']['id'];
            $res = D('Admin/Address');
            $address = $res->where($where)->getData();

            $this->assign('address', $address);
            $this->display();
        } else {
            $this->redirect('Login/login');
        }

    }

    //ajax查询支付状态：待付款
    public function paycheck()
    {
        $where['pay_status'] = 0;
        $where['post_status'] = 0;
        $where['o.uid'] = $_SESSION['userInfo']['id'];
        $where['_logic'] = 'AND';
        $res = D('Admin/Orders');
        $total = $res->alias('o')->field('d.oid, o.post_id')->where($where)->join('left join __ORDERSDATA__ as d on o.id=d.id')->count();

        $page = new \Org\Yam\Page($total, C('PAGE_NUM'));
        $orders = $res->alias('o')->order('addtime desc')->join('left join __ORDERSDATA__ as d on o.id=d.id')->where($where)->limit($page->firstRow.','.$page->listRows)->ordersStr();
        $btn = $page->show();

        $this->assign('orders', $orders);
        $this->assign('btn', $btn);
        
        if ($orders == null) {
            $empty[] = $this->fetch('empty');
            echo json_encode($empty);die;
        } else {
            $content[] = $this->fetch('table');
            $content[] = $orders;
            echo json_encode($content);die;     
        }
    }

    //ajax查询发货状态：待发货
    public function postno()
    {
        $where['pay_status']  = 1;
        $where['post_status'] = 0;
        $where['o.uid'] = $_SESSION['userInfo']['id'];
        $where['_logic'] = 'AND';

        $res = D('Admin/Orders');
        $total = $res->alias('o')->field('d.oid, o.post_id')->where($where)->join('left join __ORDERSDATA__ as d on o.id=d.id')->count();

        $page = new \Org\Yam\Page($total, C('PAGE_NUM'));
        $orders = $res->alias('o')->order('addtime desc')->join('left join __ORDERSDATA__ as d on o.id=d.id')->where($where)->limit($page->firstRow.','.$page->listRows)->ordersStr();
        $btn = $page->show();

        $this->assign('orders', $orders);
        $this->assign('btn', $btn);

        if ($orders == null) {
            $empty[] = $this->fetch('empty');
            echo json_encode($empty);die;
        } else {
            $content[] = $this->fetch('table');
            $content[] = $orders;
            echo json_encode($content);die;     
        }
    }

    //ajax查询发货状态：已发货
    public function postyes()
    {
        $where['pay_status']  = 1;
        $where['post_status'] = 1;
        $where['o.uid'] = $_SESSION['userInfo']['id'];
        $where['_logic'] = 'AND';

        $res = D('Admin/Orders');
        $total = $res->alias('o')->field('d.oid, o.post_id')->where($where)->join('left join __ORDERSDATA__ as d on o.id=d.id')->count();

        $page = new \Org\Yam\Page($total, C('PAGE_NUM'));
        $orders = $res->alias('o')->order('addtime desc')->join('left join __ORDERSDATA__ as d on o.id=d.id')->where($where)->limit($page->firstRow.','.$page->listRows)->ordersStr();
        $btn = $page->show();

        $this->assign('orders', $orders);
        $this->assign('btn', $btn);

        if ($orders == null) {
            $empty[] = $this->fetch('empty');
            echo json_encode($empty);die;
        } else {
            $content[] = $this->fetch('table');
            $content[] = $orders;
            echo json_encode($content);die;     
        }
    }

    //ajax查询所有订单
    public function allorders()
    {
        $where['o.uid'] = $_SESSION['userInfo']['id'];
        $res = D('Admin/Orders');
        $total = $res->alias('o')->field('d.oid, o.post_id')->where('uid=')->join('left join __ORDERSDATA__ as d on o.id=d.id')->count();

        $page = new \Org\Yam\Page($total, C('PAGE_NUM'));
        $orders = $res->alias('o')->order('addtime desc')->join('left join __ORDERSDATA__ as d on o.id=d.id')->where($where)->limit($page->firstRow.','.$page->listRows)->ordersStr();
        $btn = $page->show();

        // dump($orders);  die;
        foreach ($content as $k => $v) {
            
        }
        $this->assign('orders', $orders);
        $this->assign('btn', $btn);
        if ($orders == null) {
            $empty[] = $this->fetch('empty');
            echo json_encode($empty);die;
        } else {
            $content[] = $this->fetch('table');
            $content[] = $orders;
            echo json_encode($content);die;     
        }
    }


    //添加商品/确认购买信息
    public function order()
    {    
        if (session('?userInfo')) {
            $id = $_SESSION['userInfo']['id'];
            $address = D('Admin/Address');
            $arr = $address->where("uid=".$id)->getData();

            $g_id = I('gid');                           
            $g_att = I('att');  
            $g_amount = I('amount');
            // var_dump($_GET);

            if ($g_id && $g_att && $g_amount) {
                if ($g_att) {
                    //把属性ID升序排列，因为后台存储属性是升序，为了能去查库存量
                    sort($g_att);
                    $g_att = implode(',', $g_att);  
                } else{
                     $g_att = '默认';
                }
                // echo $g_att;die;

                //查库存
                $where = array('gid'=>$g_id, 'att_id'=>$g_att);
                $price_store = M('price_store');
                $stock = $price_store->where($where)->find();
                // dump($stock);
                
                if ($stock['store'] == false) $stock['store'] = 0;
                if ($stock['store'] < $g_amount || $stock['store'] == false) {
                    $this->error("亲，您下手慢了，库存数量仅为".$stock['store'], U('Detail/index', ['id' => $g_id ]));
                } else {

                    //获取名称
                    $goods = M('Goods');
                    $glist = $goods->where('id='.$g_id)->find();
                    // dump($glist);
                    
                    //获取商品属性字串
                    $gatt = D('Admin/Orders');
                    $goodsAtt = $gatt->convertGattIdToGattStr($g_att); 
                     // dump($goodsAtt);    

                    //获取图片
                    $pgoods = M('pic_desc');
                    $pic = $pgoods->where('gid='.$g_id)->find();
                     // dump($pic);

                    //获取价格
                    $ps = M('price_store');
                    $pslist = $ps->where('gid='.$g_id)->find();
                     // dump($pslist);

                    //要用的数据转成JSON
                    $data['gid']        = $glist['id'];
                    $data['uid']        = $id;
                    $data['gname']      = $glist['name'];
                    $data['att']        = $g_att;
                    $data['att_str']    = $goodsAtt;
                    $data['amount']     = $_POST['amount'];
                    $data['price']      = $pslist['price'];
                    $data['pic']        = $pic['pic_path'];
                    $getData = json_encode($data);
                    
                    $this->assign('uid', $id); 
                    $this->assign('glist', $glist);
                    $this->assign('goodsAtt', $goodsAtt);
                    $this->assign('pic', $pic);
                    $this->assign('pslist', $pslist);
                    $this->assign('gamount', $g_amount);
                    $this->assign('list', $arr);
                    $this->assign('getData', $getData);

                    $this->display();

                }
            } else { 
                $this->error("你走错了！，原路返回。");
            }  
        } else {
            $this->redirect('Login/login');
        }
    }


    //提交订单
    public function suborder()
    {
        //接收滑块验证信息
        $data1 = I('post.geetest_challenge');
        $data2 = I('post.geetest_validate');
        $data3 = I('post.geetest_seccode');
        
        //如果有值就执行提交订单，否则返回滑块验证失败
        if ($data1 && $data2 && $data3) {
            //处理用户所选择的收货信息
            $address = M('Address');
            $useradd = $address->where('id='.$_POST['id'])->find();
            if ($useradd == false) {
                $this->error('请收货人信息！');
            }

            //接收订单页面传过来的JSON
            $getdata       = json_decode($_POST['getdata']);

            //把JSON转为数组
            $arr        = (array)$getdata;
           
            // province city district detailed
            $orders['uid']        = $arr['uid'];
            $orders['aid']        = I('id') ? I('id') : '';
            $orders['addtime']    = time();
            $orders['getman']     = $useradd['getman'];
            $orders['province']   = $useradd['province'];
            $orders['city']       = $useradd['city'];
            $orders['district']   = $useradd['district'];
            $orders['detailed']   = $useradd['detailed'];
            $orders['phone']      = $useradd['phone'];
            $orders['price']      = $arr['price'] * $arr['amount'];
            $orders['message']    = I('message') ? I('message') :'';
            // dump($orders);

            $ordersMoled = M('Orders');
            $ordersMoled->create($orders);
            $resO = $ordersMoled->add($orders);
     
            if ($resO) {
                //生成订单编号：年月日时分秒+会员ID+0-99999随机数字，随机数字不够5位，用0填补
                $ordersdata['oid']          = date('Ymdhis').$arr['uid'].str_pad(rand(0,99999),5,"0");
                $ordersdata ['uid']         = $arr['uid'];
                $ordersdata ['g_id']        = $arr['gid'];
                $ordersdata ['g_name']      = $arr['gname'];
                $ordersdata ['g_attr_id']   = $arr['att'];
                $ordersdata ['g_attr_str']  = $arr['att_str'];
                $ordersdata ['g_price']     = $arr['price'];
                $ordersdata ['g_number']    = $arr['amount'];
                $ordersdata ['pic_path']    = $arr['pic'];
                // dump($ordersdata);die;

                $ordersdataMoled = M('Ordersdata');
                $ordersdataMoled->create($ordersdata);
                $resD = $ordersdataMoled->add($ordersdata);
                // dump($resO);die;

                if ($resD) {
                    $this->success('订单提交成功！订单编号为：'.$ordersdata['oid'], U("Order/pay", ['id'=>$resO])); 
                } else {
                    // 删除订单表添加的数据数据
                    $ordersMoled->where('id='.$resO)->delete(); 
                    $this->error('订单提交失败！');
                }
                
            } else {
                $this->error('订单提交失败！');
            }
            
        } else {
            $this->error('滑块验证失败！');
        }
    }


    //添加地址
    public function addAddres()
    {
        if(IS_POST){
            $data['uid'] = I('uid');
            $data['getman'] = I('getman');
            $data['phone'] = I('phone');
            $data['province'] = I('province');
            $data['city'] = I('city');
            $data['district'] = I('district');
            $data['detailed'] = I('detailed');


            $address = D('Admin/Address');
            if ($address->create($data)) {
                $res = $address->add($data);
                if ($res) {
                $this->assign('jumpUrl', "javascript:window.opener=null;window.open(','_self');window.close();");
                    $this->success('添加成功！');    
                } else {
                    $this->error('添加失败！');
                }
            } else {
                //验证失败
                $this->error($address->getError());
            }    

        }else{

            //三级联动数据
            if($_GET['areaId']){
                $where['parentid']=$_GET['areaId'];
                $area = D('Area')->where($where)->select();
                $this->ajaxReturn($area);
            }

            $id = $_SESSION['userInfo']['id'];
            $userModel = M('Users');
            $user = $userModel->where("id={$id}")->find(); 
            $this->assign('user', $user); 
            $this->display();
        }
    }

    //编辑地址
     public function editaddres(){
        $id = I('id');
        if(IS_POST){
            $data['getman'] = I('getman');
            $data['phone'] = I('phone');
            $data['province'] = I('province');
            $data['city'] = I('city');
            $data['district'] = I('district');
            $data['detailed'] = I('detailed');
            $data['id'] = I('id');
            // dump($data);

            $address = D('Address');
            if ($address->create($data)) {
                //验证通过
                if ($address->where('id='.$data['id'])->save()) {
                    $this->success('修改地址成功！');
                } else {
                    // echo $address->_sql();die();
                    $this->error('修改地址信息失败！');
                }
            } else {
                $this->error($address->getError());
            }
            return;

        }else{
            
            //三级联动数据
            if($_GET['areaId']){
                $data['parentid']=$_GET['areaId'];
                $area = D('Area')->where($data)->select();
                $this->ajaxReturn($area);
            }

            $res = D('Address');
            $info = $res->find($id);
            $where['id'] =  $info['uid'];
            $user = $res->table('__USERS__')->where($where)->find(); 
            $area = D('area');
            //查出所有的省
            $province = $area->where('parentid=0')->select();

            //查出当前条地址保存的省下面的市
            $city = $area->where(['parentid'=>$info['province']])->select();

            //查出当前条地址保存的市下面的所有的县
            $district = $area->where(['parentid'=>$info['city']])->select();
            
            $this->assign('province', $province);
            $this->assign('city', $city);
            $this->assign('district', $district);
            $this->assign('listC', $info);
            $this->assign('user', $user);
            $this->display();
        }
    }  

    /**
     * 删除用户地址
     * @param  int $id 要删除的ID
     */
    public function delAddres($id)
    {
        $res = M('Address')->delete($id);
        if ($res) {
            $this->success('删除成功');
        } else {
            $this->error('删除失败');
        }
    }

    //支付页面
    public function pay()
    {
        $id = I('id');
        $res = M('Orders');
        $orders = $res->where('id='.$id)->find();
        
        $aid = $orders['aid'];
        $ordersdata = $res->table('__ORDERSDATA__')->where("id=".$id)->find();

        //解析地址的省，市，县为字符
        $address = D('Admin/Address');
        $addresStr =  $address->where('id='.$aid)->getData();

        $this->assign('addresStr', $addresStr);
        $this->assign('orders', $orders);
        $this->assign('ordersdata', $ordersdata);
        $this->assign('user', $user);
        $this->display();
    }

    public function takegoods() 
    {
        // dump($_POST);
        $where['id'] = I('id');
        $orders = M('Orders')->where($where)->find(); 
        if ($orders['post_status'] != 1 || $orders['pay_status'] != 1) {
            $this->error('抱歉，订单目前状态不可改变！', U('index'));
        } else {
            $id = I('id') ? I('id') : '';
            $orders = M('Orders');

            $data['post_status'] = 2;
            $res = $orders->where('id='.$id)->save($data);
            if ($res) {
                $this->success('确认收货！');
            } else {
                $this->error('确认收货失败！');
            }      
        }    

    }

    /**
     * geetest生成验证码
     */
    public function geetest_show_verify(){
        $geetest_id=C('GEETEST_ID');
        $geetest_key=C('GEETEST_KEY');
        $geetest=new \Org\Yam\Geetest($geetest_id,$geetest_key);
        $user_id = "test";
        $status = $geetest->pre_process($user_id);
        $_SESSION['geetest']=array(
            'gtserver'=>$status,
            'user_id'=>$user_id
            );
        echo $geetest->get_response_str();
        exit;
    }
 
    /**
     * geetest submit 提交验证
     */
    public function geetest_submit_check(){
        $data=I('post.');
        if (geetest_chcek_verify($data)) {
            echo '验证成功';
        }else{
            echo '验证失败';
        }
    }
 
    /**
     * geetest ajax 验证
     */
    public function geetest_ajax_check(){
        $data=I('post.');
        echo intval(geetest_chcek_verify($data));
    }
}