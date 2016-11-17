<?php
/*
公共函数库
 */

/**
  * 邮件发送函数
  */
function sendMail($to, $subject, $content) {
    //导入vender\PHPMailer\classphpmailer.php
    //注意：用vender函数导入的是.php的文件！！！！
    Vendor('PHPMailer.classphpmailer');
    $mail = new PHPMailer(); /*实例化*/
    $mail->IsSMTP(); /*启用SMTP*/
    $mail->Host         =   C('MAIL_HOST'); /*smtp服务器的名称*/

    $mail->SMTPDebug    =   C('MAIL_DEBUG'); /*开启调试模式，显示信息*/
    $mail->Port         =   C('MAIL_PORT'); /*smtp服务器的端口号*/
    $mail->SMTPSecure   =   C('MAIL_SECURE'); /*注意：要开启PHP中的openssl扩展,smtp服务器的验证方式*/

    $mail->SMTPAuth     =   C('MAIL_SMTPAUTH'); /*启用smtp认证*/
    $mail->Username     =   C('MAIL_USERNAME'); /*你的邮箱名*/
    $mail->Password     =   C('MAIL_PASSWORD') ; /*邮箱密码*/
    $mail->From         =   C('MAIL_FROM'); /*发件人地址（也就是你的邮箱地址）*/
    $mail->FromName     =   C('MAIL_FROMNAME'); /*发件人姓名*/
    $mail->AddAddress($to,"name");
    $mail->WordWrap     =   50; /*设置每行字符长度*/
    $mail->IsHTML(C('MAIL_ISHTML')); /* 是否HTML格式邮件*/
    $mail->CharSet      =   C('MAIL_CHARSET'); /*设置邮件编码*/
    $mail->Subject      =   $subject; /*邮件主题*/
    $mail->Body         =   $content; /*邮件内容*/
    $mail->AltBody      =   "This is the body in plain text for non-HTML mail clients"; /*邮件正文不支持HTML的备用显示*/
    if(!$mail->Send()) {
        return "邮件发送失败: " . $mail->ErrorInfo;
        exit();
    } else {
        return "ok";
    }
}



function countPeople()
{
        $online_log = "./Public/Log/count.dat"; //保存人数的文件,
        $timeout = 30;//30秒内没动作者,认为掉线 
        $entries = file($online_log); 

        $temp = array(); 

        for ($i=0;$i<count($entries);$i++) { 
        $entry = explode(",",trim($entries[$i])); 
        if (($entry[0] != getenv('REMOTE_ADDR')) && ($entry[1] > time())) { 
        array_push($temp,$entry[0].",".$entry[1]."\n"); //取出其他浏览者的信息,并去掉超时者,保存进$temp
        } 
        } 

        array_push($temp,getenv('REMOTE_ADDR').",".(time() + ($timeout))."\n"); //更新浏览者的时间
        $users_online = count($temp); //计算在线人数

        $entries = implode("",$temp); 
        //写入文件
        $fp = fopen($online_log,"w"); 
        flock($fp,LOCK_EX); //flock() 不能在NFS以及其他的一些网络文件系统中正常工作
        fputs($fp,$entries); 
        flock($fp,LOCK_UN); 
        fclose($fp); 

        // echo "当前有".$users_online."人在线"; 
        return $users_online;
}

/**
 * 跳向支付宝付款
 * @param  array $order 订单数据 必须包含 out_trade_no(订单号)、price(订单金额)、subject(商品名称标题)、gid（商品id）
 */
function alipay($order){
    vendor('Alipay.AlipaySubmit','','.class.php');
    // 获取配置
    $config=C('ALIPAY_CONFIG');
    $data=array(
        "_input_charset" => $config['input_charset'], // 编码格式
        "logistics_fee" => "0.00", // 物流费用
        "logistics_payment" => "SELLER_PAY", // 物流支付方式SELLER_PAY（卖家承担运费）、BUYER_PAY（买家承担运费）
        "logistics_type" => "EXPRESS", // 物流类型EXPRESS（快递）、POST（平邮）、EMS（EMS）
        "notify_url" => $config['notify_url'], // 异步接收支付状态通知的链接
        "out_trade_no" => $order['out_trade_no'], // 订单号
        "partner" => $config['partner'], // partner 从支付宝商户版个人中心获取
        "payment_type" => "1", // 支付类型对应请求时的 payment_type 参数,原样返回。固定设置为1即可
        "price" => $order['price'], // 订单价格单位为元
        // "price" => 0.01, // // 调价用于测试
        "quantity" => "1", // price、quantity 能代替 total_fee。 即存在 total_fee,就不能存在 price 和 quantity;存在 price、quantity, 就不能存在 total_fee。 （没绕明白；好吧；那无视这个参数即可）
        "receive_address" => '1', // 收货人地址 即时到账方式无视此参数即可
        "receive_mobile" => '1', // 收货人手机号码 即时到账方式无视即可
        "receive_name" => '1', // 收货人姓名 即时到账方式无视即可
        "receive_zip" => '1', // 收货人邮编 即时到账方式无视即可
        "return_url" => $config['return_url'], // 页面跳转 同步通知 页面路径 支付宝处理完请求后,当前页面自 动跳转到商户网站里指定页面的 http 路径。
        "seller_email" => $config['seller_email'], // email 从支付宝商户版个人中心获取
        "service" => "create_direct_pay_by_user", // 接口名称 固定设置为create_direct_pay_by_user
        "show_url" => $config['show_url'].'?id='.$order['gid'], // 商品展示网址,收银台页面上,商品展示的超链接。
        "subject" => $order['subject'] // 商品名称商品的标题/交易标题/订单标 题/订单关键字等
    );
    $alipay=new \AlipaySubmit($config);
    $new=$alipay->buildRequestPara($data);
    $go_pay=$alipay->buildRequestForm($new, 'get','支付');
    echo $go_pay;
}

/**
 * 微信扫码支付
 * @param  array $order 订单 必须包含支付所需要的参数 body(产品描述)、total_fee(订单金额)、out_trade_no(订单号)、product_id(产品id)
 */
function weixinpay($order){
    $order['trade_type']='NATIVE';
    Vendor('Weixinpay.Weixinpay');
    $weixinpay=new \Weixinpay();
    $weixinpay->pay($order);
}

/**
 * 生成二维码
 * @param  string  $url  url连接
 * @param  integer $size 尺寸 纯数字
 */
function qrcode($url,$size=6){
    Vendor('Phpqrcode.phpqrcode');
    ob_clean();
    QRcode::png($url,false,QR_ECLEVEL_L,$size,2,false,0xFFFFFF,0x000000);
}