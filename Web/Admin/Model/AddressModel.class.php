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
namespace Admin\Model;
use Think\Model;

/**
 * 地址模型类
 * 
 */
class AddressModel extends Model
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
    ];

    //解析地址省、市、县为字符
    public function getData()
    {
        $arr = $this->select();
        foreach ($arr as $k=>$v) {
             $arr[$k]['province'] = M('area')->where(['id'=>$v['province']])->getField('areaname');
             $arr[$k]['city'] = M('area')->where(['id'=>$v['city']])->getField('areaname');
             $arr[$k]['district'] = M('area')->where(['id'=>$v['district']])->getField('areaname');
        }
        return $arr;
    }

}

