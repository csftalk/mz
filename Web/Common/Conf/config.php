<?php
return array(
	//'配置项'=>'配置值'

	//数据库配置信息
    'DB_TYPE'               =>  'pdo',     	// 数据库类型
    // 'DB_DSN'                =>  'mysql:host=112.74.90.177;dbname=meizu;charset=utf8',
    // 'DB_USER'               =>  'lamp',     // 用户名
    // 'DB_PWD'                =>  '123456',          // 密码
    'DB_DSN'                =>  'mysql:host=localhost:3306;dbname=meizu;charset=utf8',
    'DB_USER'               =>  'root',     // 用户名
    'DB_PWD'                =>  '',          // 密码192.168.33.35
    'DB_PREFIX'             =>  'mz_',    	// 数据库表前缀

    // 'SHOW_PAGE_TRACE'       =>   true,		// 显示页面Trace信息，上线前改为false
    'URL_MODEL'             =>   2,			// URL模式：REWRITE模式

    //修改定界符
    'TMPL_L_DELIM'    =>    '{{',			// 左定界符
    'TMPL_R_DELIM'    =>    '}}',			// 右定界符

    //设置分页显示多少条
    'PAGE_NUM'      =>  10,					// 分页每页显示条数

    //发送邮件
    'MAIL_HOST'     => 'smtp.qq.com',          /*smtp服务器的名称、smtp.126.com*/
    'MAIL_SMTPAUTH' => TRUE,                    /*启用smtp认证*/
    'MAIL_DEBUG'    => flase,                    /*是否开启调试模式*/
    'MAIL_USERNAME' => '373185427@qq.com',      /*邮箱名称*/
    'MAIL_FROM'     => '373185427@qq.com',      /*发件人邮箱*/
    'MAIL_FROMNAME' => '年年十九项目组',         /*发件人昵称*/
    'MAIL_PASSWORD' => 'fbbxfdrjvlsubjab',      /*发件人邮箱的密码*/
    'MAIL_CHARSET'  => 'utf-8',                 /*字符集*/
    'MAIL_ISHTML'   => TRUE,                    /*是否HTML格式邮件*/
    'MAIL_PORT'     => 465,                     /*邮箱服务器端口*/
    'MAIL_SECURE'   => 'ssl',                   /*smtp服务器的验证方式，注意：要开启PHP中的openssl扩展*/
	
    //滑块验证
	'GEETEST_ID'             => '034b9cc862456adf05398821cefc94eb',//极验id  仅供测试使用
    'GEETEST_KEY'            => 'b7f064b9ae813699de794303f0b0e76f',//极验key 仅供测试使用

    //支付宝支付配置
    'ALIPAY_CONFIG'          => array(
        'partner'            => '2088521094273719', // partner 从支付宝商户版个人中心获取
        'seller_email'       => '223015223@qq.com', // email 从支付宝商户版个人中心获取
        'key'                => '6g4ziell1aaj7r6fdyrcck47hzydkdix', // key 从支付宝商户版个人中心获取
        'sign_type'          => strtoupper(trim('MD5')), // 可选md5  和 RSA 
        'input_charset'      => 'utf-8', // 编码 (固定值不用改)
        'transport'          => 'http', // 协议  (固定值不用改)
        'cacert'             => VENDOR_PATH.'Alipay/cacert.pem',  // cacert.pem存放的位置 (固定值不用改)
        'notify_url'         => 'http://mz.7hyd.com/notify.php', // 异步接收支付状态通知的链接,必须是公网能够访问的页面
        'return_url'         => 'http://192.168.33.35/Project-2/meizu/Home/Alipay/alipayReturn', // 页面跳转 同步通知 页面路径 支付宝处理完请求后,当前页面自 动跳转到商户网站里指定页面的 http 路径。 (扫码支付专用)
        'show_url'           => 'http://192.168.33.35/Project-2/meizu/Home/Detail/index.html', // 商品展示网址,收银台页面上,商品展示的超链接。 (扫码支付专用)
        'private_key_path'   => '', //移动端生成的私有key文件存放于服务器的 绝对路径 如果为MD5加密方式；此项可为空 (移动支付专用)
        'public_key_path'    => '', //移动端生成的公共key文件存放于服务器的 绝对路径 如果为MD5加密方式；此项可为空 (移动支付专用)
        ),

    //微信支付配置
    'WEIXINPAY_CONFIG'       => array(
        'APPID'              => 'wxcf724e3cd76c29af', // 微信支付APPID
        'MCHID'              => '1405934202', // 微信支付MCHID 商户收款账号
        'KEY'                => 'Shenlvhuwai7Campyouanming8888888', // 微信支付KEY
        'APPSECRET'          => 'b27045d699213ec7d346f3ebaccda3fc',  //公众帐号secert
        'NOTIFY_URL'         => 'http://192.168.33.35/Project-2/meizu/Home/WeixinPay/notify', // 接收支付状态的连接
        ),
);