<?php
/**
 * 魅族商城
 * =========================================================================
 * 版权所有:“年年19”开发小组
 * 网站地址: http://mz.7hyd.com
 * -------------------------------------------------------------------------
 * Author: 游安明
 * Date: 2016-10-27
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
    //转换商品属性ID为属性字符串
    public function convertGattIdToGattStr($gaid)
    {
        if ($gaid) {
         $sql = "select group_concat(concat(b.key, ":",a.value)separator '&ensp;') gastr from mz_goods_att a left join mz_type_att b on a.aid=b.id where a.id in('.$gaid.')";
            $res = $this->query($sql);
            return $res[0]['gastr'];
        } else {
            return '默认';
        }
    }

    //改变订单为已支付状态
    // public function changeOrderStatus($id)
    // {
    //     $where['id'] = $id;
    //     $this->where($where)->setField('pay_status', 1);

    // }
}


