<?php
/**
 * 升序排列数字
 *@param String 如：1,4,2
 *@return String  如：1,2,4
 */
function attSort($str)
{
	$str = explode(',', $str);
	sort($str);
	return join(',', $str);

}


//传递一个父级分类ID返回所有子类ID
//return array 一个一维数组
 function getChilds($cate, $id) 
{
   $arr = [];
   foreach ($cate as $v) {
       if ($v['pid'] == $id) {
           $arr[] = $v['id'];
           $arr = array_merge($arr, getChilds($cate, $v['id']));
       }
   }
   return $arr;
}