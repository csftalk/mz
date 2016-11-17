$(function(){

	//判断一下session
		var nm=$('.nm').attr('data');
		// alert(nm);
		if(nm==''){
			$('.nm').css('display','none');
		}else{
			$('.nm').css('display','block');
		}
		var gs=$('.gs').attr('data');
		// alert(nm);
		if(gs==''){
			$('.gs').css('display','none');
		}else{
			$('.gs').css('display','block');
		}

	$('.now').click(function(){
		//账户余额
		var balance=$('.balance').val();
		//应付金额
		var scopy=$('.scopy').text();
		//判断
		var bal=balance-scopy;
		// alert(bal);
		if(bal<0){
			alert('您的账户余额不足');
			//当点击支付时就把数据提交插入数据库，当提交成功时，状态为2（付款成功），当提交失败时，状态为3（未付款）
			var order=$('.order').text();
			$.post(url+'/Shop/shop4',{indeal:bal,orders:order,status:3},function(msg){
				console.log(msg);
				if(msg=='yes'){
					window.location.href=url+'/Order/order?status=1';
				}
			});
		}else{
			var pwd=$('.pwd').val();
			var password=prompt('请输入密码','');
			if($.md5(password)==pwd){
				alert('支付成功');
				//当点击支付时就把数据提交插入数据库，当提交成功时，状态为1（付款成功），当提交失败时，状态为2（未付款）
				var order=$('.order').text();
				$.post(url+'/Shop/shop4',{indeal:bal,orders:order,status:2,},function(msg){
					// console.log(msg);
					if(msg=='yes'){
						window.location.href=url+'/Order/order?status=1';
					}
				});
			}else{
				alert('密码错误');
			}
		}
	})

})