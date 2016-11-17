<?php
/**
 * 魅族商城
 * =========================================================================
 * 版权所有:“年年19”开发小组
 * 网站地址: http://mz.7hyd.com
 * -------------------------------------------------------------------------
 * Author: 游安明
 * Date: 2016-10-19
 * =========================================================================
 */
namespace Admin\Controller;
use Think\Controller;
// use Think\Page;
class OrdersController extends CommonController 
{
    public function index()
    {
        
        //查询带搜索
        $oid = I('oid') ? I('oid') : '';
        $getman = I('getman') ? I('getman') : '';
        $phone = I('phone') ? I('phone') : '';

        $map['oid'] = array('like', "%$oid%");
        $map['getman'] = array('like',"%$getman%");
        $map['phone'] = array('like',"%$phone%");
        $map['_logic'] = 'AND';
    
        $orders = D('Orders');
        //查询联表数据总条数
        $total = $orders->alias('o')->field('d.oid, o.getman, o.phone')->where($map)->join('left join __ORDERSDATA__ as d on o.id=d.id')->count();

        //实例化自定义分页类
        $page = new \Org\Yam\Page($total, C('PAGE_NUM'));
        
        $arr = $orders->alias('o')->order('addtime desc')->join('left join __ORDERSDATA__ as d on o.id=d.id')->where($map)->limit($page->firstRow.','.$page->listRows)->getData();
        $btn = $page->show();
        // dump($arr);die;

        $this->assign('list', $arr);
        $this->assign('btn', $btn);
        $this->display();
        
    }

    //订单详情
    public function details()
    {

        $oid = I('oid');
        $res = D('Ordersdata');
        $orderdata = $res->where("id={$oid}")->find();
        // $orders = $res->table('__ORDERS__')->where("id={$oid}")->find();
        //解析地址的省，市，县为字符
        $addressModel = D('Orders');
        $orders =  $addressModel->where('id='.$orderdata['id'])->ordersStr();

        $uid = $orders[0]['uid'];
        $users = $res->table('__USERS__')->where("id={$uid}")->find(); 
             
        $this->assign('listdata', $orderdata);
        $this->assign('user', $users);
        $this->assign('orders', $orders[0]);
        $this->display();
    }
	
    //修改收货信息
	public function edit()
    {

        $id = I('oid');
        $res = M('Ordersdata');
        $orderdata = $res->where("id={$id}")->find();
        $orders = $res->table('__ORDERS__')->where("id={$id}")->find();
        $uid = $orders['uid'];
        $users = $res->table('__USERS__')->where("id={$uid}")->find(); 

        //如果订单状态大于0则不能修改
        if ($orders['post_status'] > 0) {
            $this->error('抱歉，订单目前状态不可修改！', U('index'));
        } else {
            if (IS_POST) {
                
                $id = I('id');
                //province city district
                $data['getman'] = I('getman');
                $data['phone'] = I('phone');
                $data['province'] = I('province');
                $data['city'] = I('city');
                $data['district'] = I('district');
                $data['detailed'] = I('detailed');

                $oredersModel = D('Orders');

                if ($oredersModel->create($data)) {
                    //验证通过
                    if ($oredersModel->where('id='.$id)->save()) {
                        $this->success('修改收货信息成功！');
                    } else {
                        $this->error('修改收货信息失败！');
                    }
                } else {
                    $this->error($oredersModel->getError());
                }
                return;
            } else {

                //三级联动数据
        		if ($_GET['areaId']) {
        			$data['parentid']=$_GET['areaId'];
        			$area = D('Area')->where($data)->select();
        			$this->ajaxReturn($area);
        		}

                $address = D('Orders');
                $info = $address->find($id);
                // dump($info);

                $area = D('area');
                //查出所有的省
                $province = $area->where('parentid=0')->select();

                //查出当前条地址保存的省下面的市
                $city = $area->where(['parentid'=>$info['province']])->select();

                //查出当前条地址保存的市下面的所有的县
                $district = $area->where(['parentid'=>$info['city']])->select();
                    
                $this->assign('info', $info);
                $this->assign('province', $province);
                $this->assign('city', $city);
                $this->assign('district', $district);

                $this->assign('listdata', $orderdata);
                $this->assign('list', $orders);
                $this->assign('user', $users);
                $this->display();
            }
            
        }

    }

    //改变订单状态
    public function changeStatus()
    {
        $where['id'] = I('id');
        $orders = M('Orders')->where($where)->find(); 
        if ($orders['post_status'] != 0 || $orders['pay_status'] != 0) {
            $this->error('抱歉，订单目前状态不可修改！', U('index'));
        } else {
            $orders = M('Orders');
            $data['post_status'] = 3;
            $res = $orders->where($where)->save($data);
            if ($res) {
                $this->success('订单成功设为：无效订单');
            } else {
                $this->error('订单修改失败');
            }      
        }    
    }

    //支付
    public function pay()
    {
        if (IS_POST) {
            //从支付页面传来的id
            $id = I('orderid') ? I('orderid') : '';
            $data['pay_status'] = 1;
            $orders = M('Orders');
            $res = $orders->where('id='.$id)->save($data);
                if ($res) {
                    // $this->success('订单已支付！',U('delivery'));
                    $this->success('订单已支付！',U("Orders/delivery", ['id'=>$id]));
                } else {
                    $this->error('订单支付失败！');
                }

        } else {
            //从支付按钮传来的id
            $id = I('id');
            $res =  D('Orders');
            //解析地址的省、市、县为字符
            $orders = $res->where('id='.$id)->ordersStr();
        
            $ordersdata = $res->table('__ORDERSDATA__')->where('id='.$id)->find();
            $user = $res->table('__USERS__')->where('id='.$orders[0]['uid'])->find();

            $this->assign('orders', $orders);
            $this->assign('ordersdata', $ordersdata);
            $this->assign('user', $user);

            $this->display();
        }
    }

    //发货
    public function delivery()
    {
        if (IS_POST) {
            //从发货页面传来的id
            $id = I('orderid');
            $post_method =I('postMethod');
            $post_id =I('postId');

            $data['post_status'] = 1;
            $data['post_method'] = $post_method;
            $data['post_id'] = $post_id;

            $orders = D('Orders');
            if ($orders->create($data)){
                $res = $orders->where('id='.$id)->save();
                if ($res) {
                    $this->success('订单发货成功！');
                    $this->sendMail($id);
                } else {
                    $this->error('订单发货失败！');
                }
            } else {
                $this->error($orders->getError());
            }

        } else {
            //从发货按钮传来的id
            $id = I('id');
            $res =  D('Orders');
            //解析地址的省、市、县为字符
            $orders = $res->where('id='.$id)->ordersStr();
        
            $ordersdata = $res->table('__ORDERSDATA__')->where('id='.$id)->find();
            $user = $res->table('__USERS__')->where('id='.$orders[0]['uid'])->find();


            $this->assign('orders', $orders);
            $this->assign('ordersdata', $ordersdata);
            $this->assign('user', $user);

            $this->display();
        }
    }
    

    //导出Excel
    public function out()
    {
        $orders = D('Orders');
        $oid = I('oid') ? I('oid') : '';
        $getman = I('getman') ? I('getman') : '';
        $phone = I('phone') ? I('phone') : '';
        $map['d.oid'] = array('like',"%$oid%");
        $map['getman'] = array('like',"%$getman%");
        $map['phone'] = array('like',"%$phone%");
        $map['_logic'] = 'AND';
        
        $orders = D('Orders');
        $arr = $orders->alias('o')->order('addtime desc')->join('left join __ORDERSDATA__ as d on o.id=d.id')->where($map)->ordersStr();
        // echo $orders->_sql();die();
        // dump($arr);die;
        $data = array();
        foreach ($arr as $v) {
            $data[] = array($v['oid'],$v['g_name'],$v['g_attr_str'],$v['g_price'],$v['g_number'],$v['addtime'],$v['getman'],$v['phone'],$v['province'].$v['city'].$v['district'].$v['detailed']);
        }
        // var_dump($data);die;province city district

        //导入PHPExcel类库，因为PHPExcel没有用命名空间，只能inport导入
        import("Org.Util.PHPExcel");
        import("Org.Util.PHPExcel.Writer.Excel5");
        import("Org.Util.PHPExcel.IOFactory.php");

        $filename="订单_excel";
        $headArr=array("订单ID","商品名称","商品属性","商品价格","商品数量",'下单时间',"联系人","联系手机",'地址');
        $this->getExcel($filename,$headArr,$data);
    }

    private function getExcel($fileName,$headArr,$data)
    {
        //对数据进行检验
        if(empty($data) || !is_array($data)){
            die("data must be a array");
        }
        //检查文件名
        if(empty($fileName)){
            exit;
        }

        $date = date("Y_m_d",time());
        $fileName .= "_{$date}.xls";

        //创建PHPExcel对象，注意，不能少了\
        $objPHPExcel = new \PHPExcel();
        $objProps = $objPHPExcel->getProperties();
        
        //设置表头
        $key = ord("A");
        foreach($headArr as $v){
            $colum = chr($key);
            $objPHPExcel->setActiveSheetIndex(0) ->setCellValue($colum.'1', $v);
            $key += 1;
        }
        
        $column = 2;
        $objActSheet = $objPHPExcel->getActiveSheet();
        foreach($data as $key => $rows){ //行写入
            $span = ord("A");
            foreach($rows as $keyName=>$value){// 列写入
                $j = chr($span);
                $objActSheet->setCellValue($j.$column, $value);
                $span++;
            }
            $column++;
    }

        $fileName = iconv("utf-8", "gb2312", $fileName);
        //重命名表
        // $objPHPExcel->getActiveSheet()->setTitle('test');
        //设置活动单指数到第一个表,所以Excel打开这是第一个表
        $objPHPExcel->setActiveSheetIndex(0);
        header('Content-Type: application/vnd.ms-excel');
        header("Content-Disposition: attachment;filename=\"$fileName\"");
        header('Cache-Control: max-age=0');

        $objWriter = \PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
        $objWriter->save('php://output'); //文件通过浏览器下载
        exit;
    }

    //发货发送邮件模板
    private function sendMail($id)    
    {

        $model = M('Ordersdata');
        $ordersdata = $model->where('id='.$id)->find();
        $user = $model->table('__USERS__')->where('id='.$ordersdata['uid'])->find();

        $oredersModel = D('Orders');
        $orders = $oredersModel->where('id='.$id)->ordersStr();

        $toMail = $user['email'];
        $title = $user['username'].',您的订单已发货，请注意查收，订单编号：'.$ordersdata['oid'];
        $content = '<p>亲爱的'.$user['username'].':</p><p>您的如下商品已发货,:</p><p>'.$ordersdata['g_name'].'&ensp;'.$ordersdata['g_attr_str'].'&ensp;X&ensp;'.$ordersdata['g_number'].'</p><p>发货方式：'.$orders[0]['post_method'].'</p><p>快递单号：'.$orders[0]['post_id'].'</p>';

        $res = sendMail($toMail, $title, $content);
        return  $res;
    }

}
