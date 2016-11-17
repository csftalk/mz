<?php
/**
 * 魅族商城
 * =========================================================================
 * 版权所有:“年年19”开发小组
 * 网站地址: http://mz.7hyd.com
 * -------------------------------------------------------------------------
 * Author: XXX
 * Date: 2016-10-15
 * =========================================================================
 */
namespace Admin\Model;
use Think\Model;

/**
 * 添加商品分类模型类
 * 实现了商品添加的自动验证
 */
class TypeModel extends Model
{
    //自动验证：写的一定是数据表中的字段
    protected $_validate = [
		['name', 'require', '类型名称不能为空！'],
		['name', '1,50', '类型名称的值最长不能超过 50 个字符！', 1, 'length', 3],
    ];

    //定义一个方法，获取树壮的分类信息
    public function getTree()
    {
        $list = $this->select();
        return $this->tree($list); 
    }

    //递归查找所有分类
    public function tree($arr, $pid=0, $level=0)
    {
        static $tree = array();
        foreach ($arr as $v) {
            if ($v['pid'] == $pid) {
                //说明找到PID，保存起来
                $v['level'] = $level;
                $tree[] = $v;
                //继续找pid
                $this->tree($arr, $v['id'], $level+1);
            }
        }
        return $tree;
    }

    //指定一个分类，找其后台分类的id，包括他自己
    public function getSubIds($id)
    {
        //找所有分类
        $data = $this->select();
        //递归找出所有子分类
        $list = $this->tree($data, $id);
        $res = array();
        foreach ($list as $v) {
            $res[] = $v['id'];
        }

        //把id追加到数组
        $res[] = $id;
        return $res;
    }

    //获取一个分类所有子分类的id
    public function getSonId($id)
    {
        //找所有分类
        $data = $this->select();
        //递归找出所有子分类的Id
        return $this->_getSonId($data, $id);
    }

    //递归查找儿子
    private function _getSonId($data, $pid, $isclear = false)
    {
        static $ret;
        //因为每次调用静态变量都会追加，所以要格式化一下
        if ($isclear) {
            $ret = array();
        }
        foreach ($data as $k=>$v) {
            if ($v['pid'] == $pid) {
                $ret[] = $v['id'];
                //再找这条分类的子分类
                $this->_getSonId($data, $v['id']);
            }
        }
        return $ret;
    }

    //删除前验证是否有子分类
    protected function _before_delete($option)
    {
        $check = $this->getSonId($option['where']['id']);
        if ($check) {
            $this->error ='该分类下有子分类,不能删除';
            return false;
        }
    }

}

