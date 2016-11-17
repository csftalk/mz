var timeoutid;
$(document).ready(function(){
	$('.nav_1').each(function(index){
		$(this).mouseover(function(){
			// alert(index);
			timeoutid=setTimeout(function(){
				$(".slide").removeClass('hidden');
				$(".slide .row").eq(index).removeClass('hidden');
			},500);
		}).mouseout(function(){
			$(".slide").addClass('hidden');
			$(".slide .row").eq(index).addClass('hidden');
			clearTimeout(timeoutid);
		})
	})

	$('.slide .row').mouseover(function(){
		$(".slide").removeClass('hidden');
		$(this).addClass('display');
		$(this).removeClass('hidden');
	}).mouseout(function(){
		$(".slide").addClass('hidden');
		$(this).addClass('hidden');
	})

	/*购物车*/
	$('.shopping').mouseover(function(){
		$('.shop_2').css('display','block');
	}).mouseout(function(){
		$('.shop_2').css('display','none');
	})
	$('.shop_2').mouseover(function(){
		$(this).css('display','block');
	}).mouseout(function(){
		$(this).css('display','none');
	})
	
	

})







