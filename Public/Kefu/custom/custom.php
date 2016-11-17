<?php
session_start();



?>

<!DOCTYPE html>
<html><head>
    	<noscript>
			<meta http-equiv="refresh" content="0;url=about:noscript" />
		</noscript>
		<meta name="renderer" content="webkit"><!-- webkit(极速核)|ie-comp(ie兼容内核)|ie-stand(ie标准内核) -->
		<meta http-equiv="X-UA-Compatible" content="IE=Edge">
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        
        
		<link href="../css/new_main.css" rel="stylesheet" type="text/css">
        <link href="../css/skin.css" rel="stylesheet" type="text/css" title="newSkin">
		
        
		<style type="text/css">#ReceiveDriverContent,.gac_m{display:none;}#track{position:absolute;top:0;left:0;z-index:-1;visibility:hidden;}</style>
        <title>魅族在线客服</title></head>
	<body  >
		<div id="container" style="height: 646px;">
			<div style="position:absolute;width:300px;height:300px; left:85px;top:50px;">
			
		              </div>
			<div id="scorInfo">
			    <div class="l_side s_l"></div>
				<div class="r_side s_r"></div>
				<div class="s_content"><span id="headerBox"><marquee scrollamount="2" class="robotTitle">您好，小魅为您服务</marquee></span><span id="headerBoxTime"></span></div>
				<div class="clearfloat"></div>
			</div>
			<div id="cont">	
			<div id="exitChat" class="exitChat"></div>
				<div class="cont_main">
					<div class="l_side c_l"></div>
					<div class="r_side c_r"></div>
					<div id="center">					
						<div id="mid_content" class="mid_content" style="display:none;">
							<div class="mid_l_c" style="right: 505px;">
								<div class="side" id="side" style="bottom: 120px;">
									<div id="center_left1_container" class="center_left1_container">
											<div id="history" style="overflow-y:scroll;">
											
												
												
                                                
											<!--内容-->
									<!-- 		<div id="" class="lim_operator lim_clearfloat "><div class="lim_bubble"><div class="lim_time show_left">21:20:08</div><div class="lim_dot "><p class="robotinfo"><b>省电更快真八核CPU，双卡双4G，快充，指纹支付，Super Amoled 屏幕，1300 万像素激光对焦后置相机！然而，仅699，18:00 预约 ，11.11首发，魅妹决定双十一剁手！！</b></p></div></div><div class="lim_tale" ><div id="radiusborder"></div><p class="call_me" title="1212">12121</p></div></div>
                                            
                                            
                                            <div id="" class="lim_visitor lim_clearfloat "><div class="lim_bubble"><div class="lim_time show_right">21:20:19</div><div class="lim_dot ">魅蓝E 屏幕参数</div></div><div class="lim_tale" ><div id="radiusborder"></div><p class="call_me" title="我">我</p></div></div> -->
                                            
                                            </div>
										
											
										<div id="sysTip" style="display:none;"></div>									
									</div>
								</div>
								<!--end side-->
								<div class="bottom" id="bottom" style="height: 120px;">
									<div class="center_left">
										<div class="center_left1" style="height: 40px;"></div>
											
										<!--end center_left2 -->
										<div class="center_left2">
											<div id="inputarea"><div id="inputbox" name="inputbox" style="outline:none;" autocomplete="off" contenteditable="true"></div><span class="input_tip" style="display: inline;"></span></div>
											<div id="voiceChangeText">
												<div id="voiceBut"></div>
											</div>
										</div>
										<div class="center_left3">
											<span id="footerBox" class="footerBox"></span>
											<div class="closeEnterBar">										
												<div class="entera" style="background-color: rgb(159, 159, 160); cursor: pointer;">
													<div id="enter" class="cn">发送</div>
													<div id="shortcutkey"></div>
													<div id="shortKeyText" class="shortKeyText">Enter</div>
													
													<div class="clo"></div>
												</div>
											</div>
										</div>
									</div>
									<!--end center_left -->
								</div>
								<!--end bottom-->
							</div>
							
														
							<!--end main-->							
						</div>						
					</div>					
					<div class="clearfloat"></div>	
				</div>
				
			</div>			
			
		</body>
        <script src="../jquery-1.7.2.min.js"></script>
        <script>
        var sid = '';
        var uid = <?php echo isset($_SESSION['userInfo']['id']) ?$_SESSION['userInfo']['id']:'false';?>;

        //查询是否有客服在线
        function start() {
            $.get('selectonline.php', {uid:uid}, function(res) {
            		if (res[0] == 'ok') {
            			 sid = res[1];
            			 $('#mid_content').css('display', 'block');
            			 var time = date();
        			$('#history').append('<div id="" class="lim_operator lim_clearfloat "><div class="lim_bubble"><div class="lim_time show_left">'+time+'</div><div class="lim_dot "><p class="robotinfo">您好！！！</p></div></div><div class="lim_tale" ><div id="radiusborder"></div><p class="call_me" title="客服">客服'+sid+'</p></div></div>');
        			$('#history').scrollTop(11300);
            			 select();
            		} else {
            			alert('没有客服在线！！！');
            			window.close();
            		}
            }, 'json');
        }
        
        //查询mz_talk表的sid
        function select(){
        	$.get('cometCustom.php', {sid:sid}, function(res){
        		if (res) {
        			// console.dir(res);
        			var time = date();
        			$('#history').append('<div id="" class="lim_operator lim_clearfloat "><div class="lim_bubble"><div class="lim_time show_left">'+time+'</div><div class="lim_dot "><p class="robotinfo">'+ res.text+'</p></div></div><div class="lim_tale" ><div id="radiusborder"></div><p class="call_me" title="客服">客服'+sid+'</p></div></div>');
        			$('#history').scrollTop(11300);
        			window.setTimeout(function(){select();},1500);  

        		}
        	}, 'json');
        }
        


        //回车
        $('#inputbox').keypress(function(e){
        	event = e || event;
        	if (event.keyCode == 13) {
	    event.cancelBubble = true;
	    event.returnValue = false;
	    send();
 	 }
        });

        //点击发送
        $('.entera').click(function(){
        	send();
        });


        //send()
        function send(){

        	var text = $('#inputbox').html();
        	if (text == '') {
        		alert('内容不能为空！！');
        	} else {
        		$.post('customSend.php', {uid:uid, text:text}, function(res){

	        		if (res == 'ok') {
	        			$('#inputbox').html('');
	        			// alert('ok');
	        			var time = date();
	        			$('#history').append('<div id="" class="lim_visitor lim_clearfloat "><div class="lim_bubble"><div class="lim_time show_right">'+time+'</div><div class="lim_dot ">'+ text +'</div></div><div class="lim_tale" ><div id="radiusborder"></div><p class="call_me" title="我">我</p></div></div></div>');
	        			$('#history').scrollTop(11300);
	        		} else {
	        			alert('发送失败！！');
	        		}
        		});
        	}
        	
        }

        
        //end

        window.onbeforeunload = un;
        function  un() {
        	// alert(11);
        	$.get('customEnd.php');
        }

       // $(window).unload( function () { $.get('customEnd.php'); } );
// $(window).unload( function () { alert("Bye now!"); } );
//.onbeforeunload(function () { $.get('customEnd.php'); } );

        if (uid) {
        	start();
        } else {
        	alert('登录后才可以使用客服功能！！');
        	window.close();
        }

        function date(){
        	var date = new Date();
        	var hour = date.getHours();
        	var minute = date.getMinutes();
        	var second = date.getSeconds();
        	return hour+':'+minute+':'+second;
        	
        }
        
        </script>
        
        
        </html>