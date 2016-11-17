<?php
/**
 * 魅族商城
 * =========================================================================
 * 版权所有:“年年19”开发小组
 * 网站地址: http://mz.7hyd.com
 * -------------------------------------------------------------------------
 * Author: 陈盛富
 * Date: 2016-10-25
 * =========================================================================
 */
namespace Home\Model;
use Think\Model;
use Think\Model\RelationModel;


class GoodsAttModel extends RelationModel
{
    	 
    protected $_link = array(
    		//关联type表
		'TypeAtt' => array(    
			'mapping_type'    => self::BELONGS_TO,    
			//'class_name'       => 'Type',   
			 'foreign_key'       => 'aid',    
			// 'mapping_name'  => 'goods',
			'mapping_fields'  => 'id,key' ,
			'as_fields'           => 'id:typeid,key:typekey',

			 ),

	);	


    	function doData($data){
    		$arr = array();   		
    		$prevId = '';
    		foreach($data as $k=>$v) {
    			if ($v['typeid'] == $prevId) {
    				$arr[count($arr)-1][1] .= ','.$v['value'] ;
    				
    				
    				
    			} else {
    				$arr[] = [$v['typekey'],$v['value']];
    			}
    			$prevId = $v['typeid'] ;
    		}

    		return $arr;

    	}



}