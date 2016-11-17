$(function(){
	//shop2的页面
	function getTotal2(){
		var total2=0;
		$('.price').each(function(){
			total2+=Number($(this).text());
			// console.log(total);
		})
		$('#total2').text(total2);
		$('#copy').text(total2);
	}
	getTotal2();

	//地址
	$('.adress_2').each(function(index){
		$(this).mousemove(function(){
			$(this).css('border','3px solid #00c3f5');
			$('.adress_3').eq(index).css({'display':'block'});
		}).mouseout(function(){
			$(this).css('border','3px solid #f0f0f0');
			$('.adress_3').eq(index).css({'display':'none'});
		}).click(function(){
			$('.adress_2').css('background','');
			$('.adress_2').css('border','3px solid #f0f0f0');
			$(this).css('border','3px solid #00c3f5');
			var sr=src+"/Home/images/adress.png";
			$(this).css({'background':"url("+sr+")",'border':''});
			//提交收货地址
			$sid=$(this).attr('data');
			$('.adress').attr('status',$sid);
		})
	})

	$('.adress_3').each(function(index){
		$(this).mouseover(function(){
			$(this).css({'display':'block'});
			$('.adress_2').eq(index).css('border','3px solid #00c3f5');
		}).mouseout(function(){
			$(this).css('display','none');
		})
	})

	//城市联动
	// 1、首先获取省份的值
	$.post(url+'/Shop/city','upid=0',function(msg){
		// console.log(msg);
		//定义一个空变量
		var str='';
		for(var i in msg){
			str+='<option value="'+msg[i]['id']+'">'+msg[i]['name']+'</option>';
		}
		// console.log(str);
		$('#province,#province2').append(str);
	},'json');

	//2、改变省份，获取市
	$('#province,#city,#county,#province2,#city2,#county2').change(function(){
		//定义一个公共对象
		var that=$(this);
		//当省份改变的时候，后边的所有同辈都变为选择状态
		that.nextAll().html('<option value="">--请选择--</option>');
		//获取省份的ID
		var id=that.val();
		//根据省ID获取市
		$.post(url+'/Shop/city','upid='+id,function(msg){
			// console.log(msg);
			//如果获取不到数据，直接返回false;
			if(msg==null) return false;
			//给str一个默认值
			var str='<option value="">--请选择--</option>';
			//遍历并组装数据
			for(var i in msg){
				str+='<option value="'+msg[i]['id']+'">'+msg[i]['name']+'</option>';
			}
			that.next().html(str);
		})
	})

	//提交信息
		var bool=false;
		//判断收件人名字
		$('#person,#person2').blur(function(){
			var person=$(this).val();
			if(person.length==0){
				$('.p span').text('必填');
				return false;
			}else if(person.length>12){
				$('.p span').text('不能超过12个字');
				return false
			}else{
				$('.p span').text('');
			}
		})

		//判断电话
		$('#aphone,#aphone2').blur(function(){
			var aphone=$(this).val();
			if(aphone.length!=11){
				$('.a span').text('必须为11位');
				return false;
			}else{
				$('.a span').text('');
			}
		})


		//判断地址
		$('.btn1').click(function(){
			var pval=$('#province option:selected').val();
			var province=$('#province option:selected').text();
			var cval=$('#city option:selected').val();
			var city=$('#city option:selected').text();
			var yval=$('#county option:selected').val();
			var county=$('#county option:selected').text();
			var tval=$('#town option:selected').val();
			if((pval=='') || (cval==='') || (yval=='')){
				$('.ds span').text('请选择地址');
				return false;
			}else{
				$('.ds span').text('');
			}
			//判断镇是否存在
			var town='';
			if(tval==''){
				town='';
			}else{
				town=$('#town,#town2 option:selected').text();
			}
		})
		
		//获取详细地址
		$('#mores,#mores2').blur(function(){
			var mores=$(this).val();
			if(mores.length==0){
				$('.m span').text('必填');
			}else if(mores.length>50){
				$('.m span').text('不能超过50个字');
			}else{
				$('.m span').text('');
			}
		})
		//添加地址
		$('.btn1').click(function(){
			if(bool=='false'){
				exit();
			}
			var person=$('#person').val();
			var aphone=$('#aphone').val();
			var mores=$('#mores').val();
			var province=$('#province option:selected').text();
			var city=$('#city option:selected').text();
			var county=$('#county option:selected').text();
			var town='';
			var tval=$('#town option:selected').val();
			if(tval==''){
				town='';
			}else{
				town=$('#town option:selected').text();
			}

			//发送请求
			$.post(url+'/Shop/adress',{person:person,aphone:aphone,more:mores,province:province,city:city,county:county,town:town},function(msg){
				// dump(msg);
				// 1、发送成功后刷新本页面
				if(msg=='yes'){
					location.reload();
				}else{
					alert('再试一遍');
				}
			})
			$('.add_form').slideUp;
		})

		//添加新地址
		$('#add').click(function(){
			$('.add_form').slideToggle();
			$('.add_form2').css('display','none');
			$('input').val('');
		})

		//取消添加地址
		$('.btn2').click(function(){
			$('.add_form,.add_form2').slideUp();
		})

		//修改地址
		$('.btn3').click(function(){
			
			if(bool=='false'){
				exit();
			}
			var id=$('#hid').val();
			var person=$('#person2').val();
			var aphone=$('#aphone2').val();
			var mores=$('#mores2').val();
			var province=$('#province2 option:selected').text();
			var city=$('#city2 option:selected').text();
			var county=$('#county2 option:selected').text();
			var town='';
			var tval=$('#town2 option:selected').val();
			if(tval==''){
				town='';
			}else{
				town=$('#town2 option:selected').text();
			}

			//发送请求
			$.post(url+'/Shop/edit',{id:id,person:person,aphone:aphone,more:mores,province:province,city:city,county:county,town:town},function(msg){
				// dump(msg);
				// 1、发送成功后刷新本页面
				if(msg=='yes'){
					location.reload();
				}else{
					alert('再试一遍');
				}
			})
			$('.add_form2').slideUp;
		})
		//修改收货地址
		$('.edit').each(function(){
			$(this).click(function(){
				var id=$(this).attr('data');
				$('.add_form2').slideDown();
				$('.add_form').css('display','none');
				$.post(url+'/Shop/finds',{id:id},function(msg){
					console.log(msg);
					$('#hid').val(msg['id']);
					$('#person2').val(msg['person']);
					$('#aphone2').val(msg['aphone']);
					$('#mores2').val(msg['more']);
					$('#province2 option:selected').text(msg['province']);
				})

			})
		})

		//删除地址
		$('.dels').each(function(){
			$(this).click(function(){
				var id=$(this).attr('data');
				$.post(url+'/Shop/dels',{id:id},function(msg){
					// console.log(msg);
					if(msg=='yes'){
						location.reload();
					}else{
						alert('删除失败');
					}
				})
			})
		})

		//验证码刷新
		$('.shua').click(function(){
			$('.verify img').attr('src',url+'/Shop/verify?a='+Math.random());
		})

		$('.code').blur(function(){
			var code=$(this).val();
			$.post(url+'/Shop/check_verify',{code:code},function(msg){
				// console.log(msg);
				if(msg=='no'){
					$('.xing span').text('验证码错误').css('color','red');
				}else{
					$('.xing span').text('正确').css('color','green');
				}
			})
		})

		//判断session
		var buy2=$('#buy2').attr('data');
		// alert(buy2);
		if(buy2==''){
			$('#buy2').css('display','none');
		}else{
			$('#buy2').css('display','block');
		}

		var jg=$('.jg').attr('data');
		if(jg==''){
			$('.jg').css('display','none');
		}else{
			$('.jg').css('display','block');
		}


	//去结算 
	$('#jisuan2').click(function(){
		//是否选择地址 
		var status=$('.adress').attr('status');
		var ver=$('.xing span').text();
		var cop=$('#copy').text();
		// alert(status);
		if(status=='0'){
			alert('请选择收货地址');
		}else if(ver==''){
			alert('验证码错误');
		}else if(ver=='验证码错误'){
			alert('验证码错误');
		}else{
			$.post(url+'/Shop/getaid',{aid:status,cop:cop},function(msg){
				// console.log(msg);
				if(msg=='yes'){
					window.location.href=url+'/Shop/shop3';
				}else{
					alert('提交失败');
				}
			})
		}
	})
})