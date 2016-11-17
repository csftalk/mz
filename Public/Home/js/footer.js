$(document).ready(function(){
	$('#weixin').mouseover(function(){
		$('.weixin').css('display','block');
	}).mouseout(function(){
		$('.weixin').css('display','none');
	})

	/*返回顶部*/
	if($(document).scrollTop()>300){
		$('.backtop').css('display','block');
	}
	$(window).scroll(function(){
		if($(document).scrollTop()>300){
			$('.backtop').css('display','block');
		}else{
			$('.backtop').css('display','none');
		}
	})
	// $('.backtop').click(function(){
	// 	$(document).scrollTop()=0;
	// 	console.log($(document).scrollTop());
	// })
})