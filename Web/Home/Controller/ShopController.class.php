<?php
	namespace Home\Controller;
	use Think\Controller;
	header('Content-type:text/html;charset=utf8');
	class ShopController extends mainController
	{
		public function insert(){
			$seid=session('?id');
			if(!$seid){
				echo 'no';
				return false;
			}
			//用户id
			$uid=session('id');
			//实例化
			$add=M('shop');
			//把uid放入post
			$_POST['uid']=$uid;
			//创建数据对象
			$inster=$add->create();
			// dump($insert);
			//判断
			if($inster){
				$data=$add->add();
				if($data){
					echo "yes";
				}else{
					echo "no";
				}
			}else{
				echo "no";
			}
		}

		public function shop(){
			$uid=session('id');
			//实例化
			$shop=M();
			//查询数据
			$data=$shop->field('s.*,g.*,s.snum as nums,s.id as sid')->table('__SHOP__ s,__GOODS__ g')->where("s.gid=g.id and s.uid=$uid")->select();
			$this->assign('data',$data);
			// dump($data);
			$this->display();
		}

		public function update(){
			$post=I('post.');
			// echo json_encode($post);
			//实例化
			$update=M('shop');
			//创建数据对象
			$obj=$update->create();
			//判断
			if($obj){
				$data=$update->save();
				if($data){
					$this->ajaxReturn('yes');
				}else{
					$this->ajaxReturn('no');
				}
			}else{
				$this->ajaxReturn('no');
			}
		}

		//删除购物车商品
		public function del(){
			//接收id
			$id=I('post.id');
			//实例化
			$model=M('shop');
			// 删除
			$data=$model->delete($id);
			//判断
			if($data){
				$this->ajaxReturn('yes');
			}else{
				$this->ajaxReturn('no');
			}
		}

		public function demo(){
			$uid=session('id');
			$get=I('get.id');
			// 根据id获取商品的信息
			//实例化 
			$goods=M();
			// dump($get);
			//查询条件 
			$where['s.id']=array('in',$get);
			$where['s.gid']=array('exp','=g.id');
			$where['s.uid']=$uid;
			$map['id']=array('in',$get);

			// $where['s.gid']='g.id';
			//联合查询数据 
			$data=$goods->table('meizu_shop s,meizu_goods g')->where($where)->select();
			// echo $goods->_sql();
			// echo json_encode($data);
			// dump($data);


			// // 当点击去结算的时候，把商品从购物车删除,把商品加入订单，状态未付款；
			// $shop_del=$goods->table('meizu_shop')->where($map)->delete();
			// echo $goods->_sql();


			// 将获取到的信息存入到session中
			if($data){
				// $data['expire']='3600';
				session('data',$data);
				$this->ajaxReturn('yes');
			}else{
				$this->ajaxReturn('no');
			}
		}

		//跳转到第二步
		public function buyMore(){
			$sesid=session('?id');
			if(!$sesid){
				echo 'no';
				return false;
			}
			$post=$_POST;
			session('buyMore',$post);
			$bmore=session('buyMore');
			
			$this->redirect('Shop/shop2');
			// dump($bmore);
		}
		public function clearbuy(){
			session('?buy');
			session('buy',null);
			$this->redirect('Shop/shop2');
		}
		public function cleardata(){
			// session('?data');
			session('data',null);
			$this->redirect('Shop/shop2');
		}
		public function shop2(){
			$sesid=session('?id');
			if(!$sesid){
				$this->error('请先登录',U('Login/login'));
				return false;
			}
			$uid=session('id');
			// 实例化
			$shop=M();
			//从购物车(shop)/商品(goods )表数据
			$data=session('data');
			$buy=session('buy');
			
			//实例化adress
			$adress3=M('adress');
			//获取用户地址
			$getAdress=$adress3->where("uid=$uid")->select();
			$bmore=session('buyMore');


			// 分配变量
			$this->assign('data',$data);
			$this->assign('bmore',$bmore);
			$this->assign('buy',$buy);
			$this->assign('adress',$getAdress);
			//输出模板
			$this->display();
		}


		//城市联动
		public function city(){
			//实例化area表
			$area=M('area');
			//接收到的数据
			$post['upid']=I('post.upid');
			//查询数据
			$data=$area->where($post)->select();
			//返回数据
			$this->ajaxReturn($data);
		}

		public function adress(){
			//添加用户地址
			$uid=session('id');
			$_POST['uid']=$uid;
			$adress2=M('adress');
			$ad=$adress2->create();
			if($ad){
				$addres=$adress2->add();
				if($addres){
					$this->ajaxReturn('yes');
				}else{
					$this->ajaxReturn('no');
				}
			}else{
				$this->ajaxReturn('no');
			}

			//分配遍量
			$this->display('Shop/shop2');
		}

		public function verify(){
			//验证码
			//实例化\Think\Verify()
			$verify=new \Think\Verify();
			//设置验证字符
			$verify->codeSet='1234567890';
			$verify->useImgBg=false;
			$verify->length=4;
			$verify->useNoise=false;
			//生成验证码
			$verify->entry();
		}

		//验证码验证
		public function check_verify(){
			$code=I('post.code');
			$verify=new \Think\Verify();
			if($verify->check($code)){
				echo 'yes';
			}else{
				echo "no";
			}
		}

		//修改收货地址
		public function finds(){
			$id=I('post.id');
			$finds=M('adress');
			$find=$finds->where("id=$id")->find();
			$this->ajaxReturn($find);
		}
		public function edit(){
			$id=I('post.id');
			//实例化
			$edit=M('adress');
			//创建数据对象
			$res=$edit->create();
			//判断
			if($res){
				$data=$edit->where("id=$id")->save();
				if($data){
					echo 'yes';
				}else{
					echo 'no';
				}
			}else{
				echo "no";
			}
		}

		//删除地址
		public function dels(){
			$id=I('post.id');
			$del=M('adress');
			$data=$del->delete($id);
			if($data){
				$this->ajaxReturn('yes');
			}else{
				$this->ajaxReturn('no');
			}
		}

		//接收地址下信息 
		public function getaid(){
			//接收地址
			$aid=I('post.');
			session('aid',$aid);
			$se=session('aid');
			if($se){
				$this->ajaxReturn('yes');
			}else{
				$this->ajaxReturn('no');
			}
		}
		

		//跳转到shop3的页面
		
		public function shop3(){
			//从session中取出aid
			$id=session('aid')['aid'];
			$cop=session('aid')['cop'];
			$shang=session('data');
			$buy=session('buy');
			$bmore=session('buyMore');


			/*****************生成订单号*******************/
			//生成24位唯一订单号码，格式：YYYY-MMDD-HHII-SS-NNNN,NNNN-CC，其中：YYYY=年份，MM=月份，DD=日期，HH=24格式小时，II=分，SS=秒，NNNNNNNN=随机数，CC=检查码
 
			 @date_default_timezone_set("PRC");
			 
			 
			  //订购日期
			 
			  $order_date = date('Y-m-d');
			 
			  //订单号码主体（YYYYMMDDHHIISSNNNNNNNN）
			 
			  $order_id_main = date('YmdHis') . rand(10000000,99999999);
			 
			  //订单号码主体长度
			 
			  $order_id_len = strlen($order_id_main);
			 
			  $order_id_sum = 0;
			 
			  for($i=0; $i<$order_id_len; $i++){
			 
			  $order_id_sum += (int)(substr($order_id_main,$i,1));
			  }
 
			  //唯一订单号码（YYYYMMDDHHIISSNNNNNNNNCC）
			 
			  $order_id = $order_id_main . str_pad((100 - $order_id_sum % 100) % 100,2,'0',STR_PAD_LEFT);

			/*****************根据ID查找对应的地址************/
			$data=M('adress');
			$adress=$data->where("id=$id")->find();
		
			
			/********************查询用户余额******************/
			$uid=session('id');
			//实例化
			$user=M('user');
			$money=$user->field('idealMoney')->where("id=$uid")->find();
			// dump($money);

			//获取用户密码
			$pwd=M('user');
			$data=$pwd->field('password')->where("id=$uid")->select();
			

			// 分配变量
			$this->assign('pwd',$data);
			$this->assign('dizhi',$adress);
			$this->assign('balance',$money);
			$this->assign('shang',$shang);
			$this->assign('buy',$buy);
			$this->assign('bmore',$bmore);
			$this->assign('cop',$cop);
			$this->assign('order_id',$order_id);

			$this->display();
		}

		//跳转到第四个页面(支付成功)
		public function shop4(){
			$uid=session('id');
			//接收ajax传过来的数据，用户选择的商品类型
			$bcolor=$_POST['color'];
			$bnet=$_POST['net'];
			$bsnum=$_POST['snum'];
			$bmem=$_POST['mem'];

			// 接收订单号
			$orderID=$_POST['orders'];
			// dump($orderID);
			$order2=session();
			// 从session buy,data中获取gid,uid,color,net,mem,status,
			$se=session('?data');
			$bu=session('?buy');
			$now=(session('buy'));
			// dump($bu);
			$bmore=session('buyMore');
			// dump($bmore);
			//从aid中获得aid
			$aid=session('aid')['aid'];
			//购买时间
			$orderTime=time();
			$status=$_POST['status'];
			if($status==2){
				$user=M('user');
				//从user中取出score
				$score=$user->field('score')->where("id=$uid")->find();
				$newScore['score']=intval($score['score'])+10;
				$reScore=$user->where("id=$uid")->save($newScore);
			}
			
			if($se){
				$data='';
				foreach($order2['data'] as $value) {
					$where['gid']=$value['gid'];
					$where['uid']=$value['uid'];
					$where['aid']=$aid;
					$where['number']=$orderID;
					$where['snum']=$value['snum'];
					$where['color']=$value['color'];
					$where['net']=$value['net'];
					$where['mem']=$value['mem'];
					$where['status']=$_POST['status'];
					$where['orderTime']=date('Y-m-d H:i:s',$orderTime);
					$order=M('order');
					$data=$order->add($where);
				}
				if($data){
					echo "yes";
				}else{
					echo 'no';
				}
			}else{
				$where['gid']=$now['id'];
				$where['uid']=$uid;
				$where['aid']=$aid;
				$where['number']=$orderID;
				$where['snum']=$bmore['snum'];
				$where['color']=$bmore['color'];
				$where['net']=$bmore['net'];
				$where['mem']=$bmore['mem'];
				$where['status']=$_POST['status'];
				$where['orderTime']=date('Y-m-d H:i:s',$orderTime);
				$order=M('order');
				$data2=$order->add($where);
				// dump($where);
				// dump($data2);
				// echo $order->_sql();
				if($data2){
					echo 'yes';
				}else{
					echo 'no';
				}
			}

			//更新一下账户余额,
			
			$data=M('user');

			//定义标示符
			$yue['idealMoney']=$_POST['indeal'];
			$yue2=$_POST['indeal'];

			//执行更新语句
			if($yue2>0){
				$balan=$data->where("id=$uid")->save($yue);
			}
		}
	}