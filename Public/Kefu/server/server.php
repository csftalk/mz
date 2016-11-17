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
	<body>
	
		<div id="container" style="height: 646px;position:relative;">
			<div style="position:absolute;width:300px;height:300px; left:85px;top:50px;">
			<button id="s_start" style="cursor:pointer;">开始</button>&nbsp;&nbsp;<!-- <button id="s_stop" disabled="disabled"style="cursor:pointer;" >结束</button>  -->
			<p><span>状态：</span><span id="s_status">未开始！！</span></p>
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
									<div id="center_left1_container" class="center_left1_container" >
											<div id="history" style="overflow-y:scroll;">
											
												
												
                                                
											<!--内容-->
										<!-- 	<div id="" class="lim_operator lim_clearfloat "><div class="lim_bubble"><div class="lim_time show_left">21:20:08</div><div class="lim_dot "><p class="robotinfo"><b>省电更快真八核CPU，双卡双4G，快充，指纹支付，Super Amoled 屏幕，1300 万像素激光对焦后置相机！然而，仅699，18:00 预约 ，11.11首发，魅妹决定双十一剁手！！</b></p></div></div><div class="lim_tale" ><div id="radiusborder"></div><p class="call_me" title="1212">12121</p></div></div>
                                            
                                            
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
        var uid = '';//客户id
        var sid = <?php  echo $_SESSION['adminInfo']['id'];?>;

        //开始
        $('#s_start').click(function(){
        	start();
            $('#s_start').attr('disabled', true);
        });

        function start()
        {
            $.get('serverStart.php',{},function(res){
                if (res == 'ok') {
                    $('#s_status').html('无客户！！');
                    serverListen();
                    //$('#mid_content').css('display', 'block');
                } else {
                    alert('开始客服服务失败');
                }
            });
        }



       /* //结束*/
        $('#s_stop').click(function(){
        	stop();
        });

        function stop()
        {
           $.get('serverStop.php',{uid:uid},function(res){
                if (res == 'ok') {
                    alert('服务已停止！！');
                    $('#s_status').html('服务已停止');
                } else {
                    alert('亲，客户还没离开哦！！');
                }
            }); 
        }




        //监听mz_online 是否有客户来
        function serverListen(){
        	$.get('serverListen.php', {},function(res){
        		if (res[0] == 'ok') {
        			uid = res[1];
        			$('#mid_content').css('display', 'block');
        			$('#s_status').html('服务中！！----客户'+uid);
        			select();
        			userLeave();
        		}
        	}, 'json');
        }


        //监听mz_talk
        function select(){
        	$.get('cometServer.php', {uid:uid}, function(res){
        		if (res == 'leave') {
        			

        		} else {
        			// console.dir(res);
        			$('#history').append('<div id="" class="lim_operator lim_clearfloat "><div class="lim_bubble"><div class="lim_time show_left">21:20:08</div><div class="lim_dot "><p class="robotinfo">'+ res.text+'</p></div></div><div class="lim_tale" ><div id="radiusborder"></div><p class="call_me" title="客户">客户'+uid+'</p></div></div>');
        			$('#history').scrollTop(11300);
        			window.setTimeout(function(){select();},1500);  
        		}
        	}, 'json');
        }


        //监听mz_online表 用户是否离开
        function userLeave(){
        	$.get('userLeave.php',{uid:uid}, function(res) {
        		if (res == 'leave'){
        			$('#mid_content').css('display', 'none');
                                        $('#history').html('');
        			// window.location.reload()
                                        $('#s_status').html('本次服务已结束，请重新开始！！');
                                        $('#s_start').attr('disabled', false);
                                        
        			
        		}
        	});
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
        		$.post('serverSend.php', {sid:sid, text:text}, function(res){
	        		if (res == 'ok') {
	        			$('#inputbox').html('');
	        			// alert('ok');
	        			$('#history').append('<div id="" class="lim_visitor lim_clearfloat "><div class="lim_bubble"><div class="lim_time show_right">21:20:19</div><div class="lim_dot ">'+ text +'</div></div><div class="lim_tale" ><div id="radiusborder"></div><p class="call_me" title="我">我</p></div></div></div>');
                                                    $('#history').scrollTop(11300);

	        		} else {
	        			alert('发送失败！！');
	        		}
        		});
        	}
        	
        }




        // start();
        // //end
        // window.unload = function() {$.get('serverEnd.php'); }


        $(window).unload( function () { $.get('serverEnd.php'); } );
        </script>
        
        
        </html>