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
    
    	
	//在添加时调用Create 方法时允许接收表单的字段
	//protected $insertFileds = 'name,type,status,desc';


	//自动验证
	protected $_validate = [
		// ['tid', 'require', '产品类型必须选择！！', 1, ],
		// ['name', 'require', '产品名称不能为空！！', 1, ],
		// ['desc', 'require', '产品描述不能为空！！', 1, ],
		// ['key', '','属性名已存在！！', 2, 'unique' ],
		
	];

	//自动完成
	 protected $_auto = [
	 	
	 ];




	//字段映射
	protected $_map = [
		
	];
    	


	//获取表单中的aid 和值
    	public function getAtt($data){
    		$arr = array();
		$cache = '';
		foreach($data as $k=>$v) {
			    if ($v == '') {
			        unset($data[$k]);
			    } else {
			         if (strpos($k, 'att') === 0) {
			            $cache = ltrim($k,'att');
			             if (is_array($v)){
			                 foreach($v as $y) {
			                    $arr[] = ['aid'=>$cache, 'value'=>$y]; 
			                 }
			             } else {
			                
			                $arr[] = ['aid' =>$cache,  'value'=>$v] ; 
			             }
			             
			        
			       }   
	   		 }
 
	          }

	          return $arr;

    	}


    	/**
    	 * GoodsAtt/index
    	 */
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