$(document).ready(function(){
	
	/*商品小图展示*/
	$('.minpic img').each(function(index){
		$('.minpic img').eq(index).click(function(){
			var src=$(this).attr('src');
			$(".det_2_1>a img").attr('src',src);
		})
	})

	/*商品网络类型选择*/
	$('.t').each(function(index){
		$(this).click(function(){
			var type=$('.net').eq(index).html();
			$('.t').css({'border':'1px solid #e5e5e5'});
			$('.t').eq(index).css({'border':'1px solid #00c3f5'});
			$('#det_5_2').html(type);

			// var data=$(this).attr('data');
			// $.post(url+'/Detail/attr',{data:data},function(msg){
			// 	var str='';
			// 	for(var i in msg){
			// 		str+='<a class="liantong yin" href="javascript:;" bgcolor="#FFF">';
			// 			str+='<span>'
			// 				str+='<span class="name"><span>'+msg[i]["color"]+'</span></span>'
			// 			str+='</span>'
			// 		str+='</a>'
			// 	}
			// 	$('.col').html(str);
				
			// },'json')
		})
	})

// <div>
// 	<a></a>
// </div>
// 	$('div').on('click','a',fu)
	
	// /*图片展示*/
	$(".det_2_1>a img").css('display','none');
	$('#detimg').css('display','block');
	$('.yin').each(function(index){
		$(this).click(function(){
			color=$('.name').eq(index).html();
			$('.yin').css({'border':'1px solid #e5e5e5'})
			$(this).css({'border':'1px solid #00c3f5'});
			$('#det_5_3').html(color);
			$('.minpic').css('display','none');
			$('.minpic').eq(index).css('display','block');
			maxpic=$('.minpic>a:first-child img').eq(index).attr('src');
			$(".det_2_1>a img").attr('src',maxpic);
		})
	})

	


	/*商品内存选择*/
	$('.nn').each(function(index){
		$(this).click(function(){
			var memory=$.trim($(this).text());
			$('.nn').css({'border':'1px solid #e5e5e5'});
			$('.nn').eq(index).css({'border':'1px solid #00c3f5'});
			$('#det_5_4').html(memory);
		})
	})

	/*商品详情图片栏*/
	$(window).scroll(function(){
		var fooer=$(document).height()-$(document).scrollTop();
		// console.log(fooer);
		if($(document).scrollTop()>960){
			$('.detail_6').css({'margin':'0','width':'1170px','position':'fixed','top':'0','background':'#fff','border-bottom':'1px solid #e5e5e5'});
			$('.detail_6_1').css('display','block');
		}else{
			$('.detail_6_1').css('display','none');
			$('.detail_6').css('position','relative');
		}
		if(fooer<630){
			$('.detail_6').css('display','none');
		}else{
			$('.detail_6').css('display','block');
		}
		// console.log($(document).scrollTop())
	})

	/**/
	$('.d').each(function(index){
		$('.d').eq(index).click(function(){
			$('.d').removeClass('det_6_1');
			$(this).addClass('det_6_1');
			$('.d').addClass('det_6_2');
			$('.x').css('display','none');
			$('.x').eq(index).css('display','block');
		})
	})
	

	/*商品数量的增减*/
	var j=$('.num_2').html();
	$('.more').mousedown(function(even){
		$(this).css({'border':'1px solid #00c3f5'});
			if(j<5){
				j++;
			}
			$('.num_2').html(j);
			var n=$('.num_2').html();
			var price=$('#det_5_5').html();
			var num=price*n;
			$('#res_1').html(num);
	}).mouseup(function(){
		$(this).css({'border':'1px solid #e5e5e5'});
	})
	$('.low').mousedown(function(even){
		$(this).css({'border':'1px solid #00c3f5'});
			if(j>1){
				j--;
			}
			$('.num_2').html(j);
			var n=$('.num_2').html();
			var price=$('#det_5_5').html();
			var num=price*n;
			$('#res_1').html(num);
	}).mouseup(function(){
		$(this).css({'border':'1px solid #e5e5e5'});
	})

	

	$('.goshop').click(function(){
		//获取商品的数量
		var mai=$('.num_2').html();
		// alert(mai);

		/*加入购物车*/
		// 商品Id
		var id=Number($('#goods').attr('data'));
		//网络类型
		var nets=$('#det_5_1').html();
		
		// 商品颜色
		var colors=$('#det_5_3').html();
		//商品数量
		var gnum=Number($('.num_2').html());
		//手机内存
		var mem=$('#det_5_4').html();
		// alert(net);
		$.post(url+'/Shop/insert',{gid:id,net:nets,color:colors,snum:gnum,mem:mem},function(msg){
			if(msg=='yes'){
				window.location.href=url+'/Shop/shop';
			}else{
				alert('请先登录');
				window.location.href=url+'/Login/login';
			}
		})
	})
	$('#buy').click(function(){
		//定义标示符
		var mar=true;
		// 商品Id
		var id=Number($('#goods').attr('data'));
		//网络类型
		var nets=$('#det_5_1').html();
		
		// 商品颜色
		var colors=$('#det_5_3').html();
		//商品数量
		var gnum=Number($('.num_2').html());
		//手机内存
		var mem=$('#det_5_4').html();

		$.post(url+'/Shop/buyMore',{gid:id,net:nets,color:colors,snum:gnum,mem:mem},function(msg){
			console.log(msg);
		})
	})

	//商品评价
	$('.ping').click(function(){
		$('.pingjia').css('display','block');
	})
})