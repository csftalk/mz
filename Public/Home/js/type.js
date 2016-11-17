$(document).ready(function(){
	$('.type_1 .li').click(function(){
		$('.type_1 .li').css({'background':'#fff','color':'#666'});
		$(this).css({'background':'#00c3f5','color':'#FFF'});
		$('.type_2').css('display','none');
		$('.type_2').eq(index).css('display','block');
		$('.type_2').eq(index).removeClass('hidden');
	})
})