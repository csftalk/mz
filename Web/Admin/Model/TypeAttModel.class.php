<?php
namespace Admin\Model;
use Think\Model\RelationModel;

class TypeAttModel extends RelationModel
{	

	//关联type表
	protected $_link = array(
		'Type' => array(    
			'mapping_type'    => self::BELONGS_TO,    
			//'class_name'       => 'Type',   
			 'foreign_key'       => 'tid',    
			// 'mapping_name'  => 'goods',
			'mapping_fields'  => 'name' ,
			'as_fields'           => 'name:typename',

			 ),


	 );

	//在添加时调用Create 方法时允许接收表单的字段
	protected $insertFileds = 'key,is_only,value';




	//字段映射
	// protected $_map = [
	// 	'id'=>'tid',
	// ];

	//自动验证
	protected $_validate = [
		['key', 'require', '属性名不能为空！！', 1, ],
		// ['key', '','属性名已存在！！', 2, 'unique' ],
		
	];

	//自动完成
	 protected $_auto = [
	 	['tid', 'getId', 1,'callback'],
	 ];


	 //获取typeid
	 protected function getId()
	 {
	 	return I('get.id');
	 } 


}