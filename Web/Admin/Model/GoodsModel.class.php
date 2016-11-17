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


class GoodsModel extends RelationModel
{
    //关联模型
    
    protected $_link = array(
    		//关联type表
		'Type' => array(    
			'mapping_type'    => self::BELONGS_TO,    
			//'class_name'       => 'Type',   
			 'foreign_key'       => 'tid',    
			// 'mapping_name'  => 'goods',
			'mapping_fields'  => 'id,name' ,
			'as_fields'           => 'id:typeid,name:typename',

			 ),
		


	 );


    
    
    	
	//在添加时调用Create 方法时允许接收表单的字段
	protected $insertFileds = 'name,type,status,desc';


	//自动验证
	protected $_validate = [
		['tid', 'require', '产品类型必须选择！！', 1, ],
		['name', 'require', '产品名称不能为空！！', 1, ],
		['name', '','产品已存在！！', 2, 'unique' ],
		['desc', 'require', '产品描述不能为空！！', 1, ],
		
		
	];

	//自动完成
	 protected $_auto = [
	 	['addtime', 'time', 1,'function'],
	 	['rollback', '1' ]
	 ];




	//字段映射
	protected $_map = [
		'type'=>'tid',
	];
    
}