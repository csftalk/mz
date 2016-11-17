$(function(){
	//取出价格、数量，计算出小计
	$('.main02-02tr2').each(function(index){
		var oprice=$('.oprice').eq(index).text();
		var osnum=$('.osnum').eq(index).text();
		var ototal=osnum*oprice;
		$('.ototal').eq(index).text(ototal);
	})

	//取消订单
	$('.concal').each(function(index){
		$('.concal').eq(index).click(function(){
			$('.status').eq(index).text('订单已取消');
			var id=$(this).attr('data');
			$.post(url+'/Order/concal',{id:id},function(msg){
				if(msg){
					loaction.reload();
				}
			})
		})
	})

	//查看订单详情
		$('.look').click(function(){
			$('.l_detail').slideDown();
			var id=$(this).attr('data');
			$.post(url+'/Order/find',{id:id},function(msg){
				console.log(msg);
				$('.l_name').text(msg[0]['person']);
				$('.l_phone').text(msg[0]['aphone']);
				var l_adress=msg[0]['province']+' '+msg[0]['city']+' '+msg[0]['county']+' '+msg[0]['town']+' '+msg[0]['more'];
				$('.l_a').text(l_adress);
				$('.l_img img').attr('src',src+'/'+msg[0]['pic']);
				$('.l_o').text(msg[0]['number']);
				$('.l_c1').text(msg[0]['gname']);
				$('.l_c2').text(' '+msg[0]['net']+' '+msg[0]['color']+' '+msg[0]['mem']);
				$('.l_n').text(msg[0]['snum']);
				$('.l_g').text(msg[0]['price']);
				$('.l_s').text(msg[0]['s']==2?'已付款':'未付款');
				$('.l_t').text(msg[0]['orderTime']);
			},'json')
		})
	$('.l_close').click(function(){
		$('.l_detail').slideUp();
	})
})