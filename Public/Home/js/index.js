/*banner轮播图*/
$(document).ready(function(){
	var s=null;
	var i=0;
	function run(){
		s=setInterval(function(){
			//隐藏所有图片
			$('.banner img').css('display','none');
			//显示对应的图片
			$('.banner img').eq(i).css('display','block');
			$('.num li').eq(i).css('background','#00c3f5').siblings().css('background','#EEE');

			//指针
			i++;

			//界限判断
			if(i>=$('.banner img').length){
				i=0;
			}
		},2000)
	}
	run();

	//鼠标放在图片上
	$('.banner img').mouseover(function(){
		clearInterval(s);
	}).mouseout(function(){
		run();
	})

	//鼠标放在标识上
	$('.num li').mouseover(function(){
		clearInterval(s);

		//鼠标的位置
		i=$(this).index();

		//隐藏所有图片
		$('.banner img').css('display','none');

		//显示对应的图片
		$('.banner img').eq(i).css('display','block');
		$('.num li').eq(i).css('background','#00c3f5').siblings().css('background','#EEE');
	})

	/*banner轮播图结束*/

	/*banner侧栏*/
	var m='';
	var n;
	$('.banner_2 a[class="a"]').each(function(index){
		
		$(this).mouseover(function(){
			n=index;
			// alert(n);
			// alert(index);
			m=setTimeout(function(){
				$('.banner_4').eq(index).css('display','block');
			},300)
		}).mouseout(function(){
			$('.banner_4').eq(index).css('display','none');
			clearInterval(m);
		})

		$(this).mouseover(function(){
			var attr=$(this).attr('value');
			$.post(url+'/Index/type',"id="+attr,function(msg){
				var str='';
				for(var k in msg){
					str+='<a href="">';
						str+='<div class="banner_5">';
							str+='<div class="banner_6">';
								str+='<img src="'+src+'/'+msg[k]["pic"]+'" alt="">';
							str+='</div>';
							str+='<div class="banner_7">'+msg[k]["gname"]+'</div>';
						str+='</div>';
					str+='</a>';
					var right='<a href="">';
							right+='<img src="'+src+'/'+msg[1]["pic"]+'" alt="">';
						right+='</a>';
				}
				$('.banner_8').html(right);
				$('.banner_3').html(str);
				console.log(msg);
			},'json')

		})
	})
	$('.banner_4').mouseover(function(){
		$(this).css('display','block');
		$('.banner_2 a[class="a"]').eq(n).css('background','#FFF');
	}).mouseout(function(){
		$(this).css('display','none');
		$('.banner_2 a[class="a"]').eq(n).css('background','');
	})


	// setInterval(function(){
		// run3();
	// 	if($('.hot_4').css('left')<0){
	// 		$('.hot_4').animate({left:'0px'},'slow');
	// 	}else{
	// 		$('.hot_4').animate({left:'-1200px'},'slow');
	// 	}
	// 	console.log($('.hot_4').css('left'));
	// },1000);
	

	$('#right').click(function(){
		$('.hot_4').stop(true);
		$('.hot_4').animate({left:'0px'},'slow');
	})
	$('#left').click(function(){
		$('.hot_4').stop(true);
		$('.hot_4').animate({left:'-1200px'},'slow');
	})

	$('.hot_3 a').mouseover(function(){
		$('#more').css('color','#00c3f5');
		$('#more img').css('top','-10px');
	}).mouseout(function(){
		$('#more').css('color','#333');
		$('#more img').css('top','7px');
	})


	$('.notice').mouseover(function(){
		$(this).css('scrollamount','0');
	})
		// var s=$('.stat').text();
			// console.log(s);
			$('.stat2,.stat').each(function(index){
				var s=$(this).text();
				console.log(s);
			if(s=='0'){
				$(this).css({'background':'rgb(255,255,255)','z-index':'-1','position':'relative'});
			}else if(s=='1'){
				$(this).css({'background':'rgb(240, 65, 95)'}).html('特惠');
			}else if(s=='2'){
				$(this).css({'background':'rgb(245, 150, 70)'}).html('现货');
			}else if(s=='3'){
				$(this).css({'background':'rgb(0, 175, 190)'}).html('赠品');
			}else if(s=='4'){
				$(this).css({'background':'rgb(245, 150, 70)'}).html('热卖');
			}else if(s=='5'){
				$(this).css({'background':'rgb(0, 195, 245)'}).html('新品');
			}
		})
})







