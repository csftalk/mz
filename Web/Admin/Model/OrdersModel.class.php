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
namespace Admin\Model;
use Think\Model;

/**
 * 订单模型类
 * 
 */
class OrdersModel extends Model
{
    //自动验证：写的一定是数据表中的字段
    protected $_validate = [
		['getman', 'require', '收货人不能为空'],
        ['phone', 'require', '联系手机不能为空'],
        ['phone','number','手机号码必须是数字'],
        ['phone','11','联系手机必须是11位数字',3,'length'],
        ['province', '/^[1-9]\d*$/', '地址：省不能为空'],
        ['city', '/^[1-9]\d*$/', '地址：市不能为空'],
        ['district', '/^[1-9]\d*$/', '地址：县/区不能为空'],
        ['detailed', 'require', '详细地址不能为空'],
        ['post_method', 'require', '发货方式不能为空'],
        ['post_id', 'require', '快递单号不能为空'],
    ];

    public function getData()
    {
        $arr = $this->select();
        foreach ($arr as $k=>$v) {
            $arr[$k]['addtime'] = date('Y-m-d H:i:s', $v['addtime']);
        }
        return $arr;
    }

    //转换商品属性ID为属性字符串
    public function convertGattIdToGattStr($gaid)
    {
        if ($gaid != "默认") {
         // $sql = "select group_concat(concat(b.key, ':',a.value)separator '&ensp;') gastr from mz_goods_att a left join mz_type_att b on a.aid=b.id where a.id in('$gaid')";
         $sql = "select group_concat(concat(b.key, ':',a.value)separator '&ensp;') gastr from mz_goods_att a left join mz_type_att b on a.aid=b.id where a.id in($gaid)";
            
            $res = $this->query($sql);
            return $res[0]['gastr'];
        } else {
            return '默认';
        }
    }

    //解析地址省、市、县为字符
    public function ordersStr()
    {
        $arr = $this->select();

        //发货方式：1 顺丰， 2 圆通，3 EMS
        $method = [1=>'顺丰快递', 2=>'圆通快递', 3=>'邮政EMS'];
        //订单状态 0 未发货 1 已发货 2 已收到货 3 取消订单
        $post_status = ['未发货', '已发货', '已收货', '取消订单'];
        //支付状态 0 未支付 1 已支付
        $pay_status = ['未支付', '已支付'];
        foreach ($arr as $k=>$v) {
            //从订单表里面查，解决用户删除地址，从地址表里面找不到
            $arr[$k]['province'] = M('area')->where(['id'=>$v['province']])->getField('areaname');
            $arr[$k]['city'] = M('area')->where(['id'=>$v['city']])->getField('areaname');
            $arr[$k]['district'] = M('area')->where(['id'=>$v['district']])->getField('areaname');
            $arr[$k]['addtime'] = date('Y-m-d H:i:s', $v['addtime']);
            $arr[$k]['post_method'] = $method[ $v['post_method']];
            $arr[$k]['post_status'] = $post_status[ $v['post_status']];
            $arr[$k]['pay_status'] = $pay_status[ $v['pay_status']];
        }
        return $arr;
    }
}

