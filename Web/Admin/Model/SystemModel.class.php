<?php
/**
 * 魅族商城
 * =========================================================================
 * 版权所有:“年年19”开发小组
 * 网站地址: http://mz.7hyd.com
 * -------------------------------------------------------------------------
 * Author: 陈盛富
 * Date: 2016-10-15
 * =========================================================================
 */
namespace Admin\Model;
use Think\Model;

class SystemModel extends Model{


	public function dispose($arr)
	{
		foreach ($arr as $key => $value) {
			if ($value['because'] == '') {
				$arr[$key]['because'] = 'sshot-60.png';
			}
			if ($value['result'] == '') {
				$arr[$key]['result'] = '空';
			}
			if ($value['course'] == '') {
				$arr[$key]['course'] = '空';
			}

		}

		return $arr;
	}
}