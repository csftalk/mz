$(function(){
	//定义一个方法getTotal改变总价
	function getTotal(){
		var total=0;
		$('.every:checked').each(function(){
			total+=Number($(this).parent().siblings('.p').find('.price').text());
			// console.log(total);
		})
		$('#total').text(total);
		$('#copy2').text(total);
	}
	getTotal();

	//选择一个的时候全部选择
	//获得#all的checked的属性值
	$('#all').click(function(){
		var value=$(this).prop('checked');
		console.log(value);
		if(value==true){
			$('.every').prop('checked',true);
			//被选中后改变总价
			getTotal();
		}else{
			$('.every').prop('checked',false);
			getTotal();
		}
	})

	//单选一个的时候计算总价
	$('.every').click(function(){
		getTotal();
	})


	//数量改变函数
	function getNum(obj,num){
		//商品ID
		var id=obj.attr('data');
		// alert(id);
		//发送请求
		$.post(url+'/Shop/update',{id:id,snum:num},function(msg){
			// console.log(msg);
			if(msg=='yes'){
				//修改数量
				obj.text(num);

				//修改小计
				var price=Number(obj.parents('.shu').prev().find('.pri').text());
				var sum=price*num;
				obj.parents('.shu').next().find('.price').text(sum);

				//修改总价
				getTotal();
			}
		})
	}

	//数量+1
	$('.jia').click(function(){
		var jia=$(this).parent().prev();
		var add=Number(jia.text());
		add++;
		
		//最多5件
		if(add>5) return false;
		getNum(jia,add);
	})

	//数量-1
	$('.jian').click(function(){
		var jian=$(this).parent().next();
		var low=Number(jian.text());
		low--;
		
		//最少1件
		if(low<1) return false;
		getNum(jian,low);
	})

	//删除商品
	$('.del').click(function(){
		//创建对象为删除按钮
		var that=$(this);
		//商品ID
		var id=$(this).parents('.delete').siblings('.shu').find('.b').attr('data');
		$.post(url+'/Shop/del',{id:id},function(msg){
			if(msg=='yes'){
				// 1、删除成功后刷新本页面
				// location.reload();
				// 2、无刷新页面操作
				that.parents('.shangpin').remove();
			}else{
				alert('删除失败');
			}
		})
	})

	//结算（没有商品不能提交去结算）
	//根据总价格去判断，如果总价为0，说明没有物品，不能去结算
	
	$('#jisuan').click(function(){
		var zongjia=Number($('#total').text());
		if(zongjia==0){
			return false;
		}

		//定义一个空数组
		var ids=[];
		$('.every:checked').each(function(){
			var id=$(this).attr('data');
			ids.push(id);
		})
		$.get(url+'/Shop/demo',{'id[]':ids},function(msg){
			console.log(msg);
			if(msg=='yes'){
				window.location.href=url+'/Shop/clearbuy';
			}else{
				alert('提交失败');
			}
		})
	})

	var em=$('.every').attr('data');
	// alert(em);
	if(em == undefined){
		$('#empty').css('display','block');
	}else{
		$('#empty').css('display','none');
	}

})