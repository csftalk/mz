<?php
namespace Home\Controller;
use Think\Controller;
class DetailController extends CommonController {
    public function index()
    {
      $id = I('get.id');
 
      $gMap['id'] = $id;
      $gMap['status'] = 2;
      $gMap['rollback'] =1;
      $gData = M('Goods')->where("id=$id")->field('id,name,desc')->find();
      $m = M();
      $aidArr = $m->query("select aid,count(id) as co from mz_goods_att where gid = {$id} group by aid having co > 1");
      //款式
      if (empty($aidArr)) {
      	//echo 'aid 空';
        $data = '';
      } else {
        //款式
        foreach ($aidArr as $key => $value) {
              $aidArr[$key] = $value['aid'];
        }
        $i = 0;
        foreach ($aidArr as  $value) {
                $ci = $m->query("select `key` from mz_type_att where id = {$value}");
                $data[$i][]= $ci[0]['key']; 

                $data[$i][] = $m->query("select id,aid,value from mz_goods_att where aid = {$value} and gid = {$id}");
                $i++;
         }

      }
      
      //展示图片
      $showPath = M('PicShow')->where("gid=$id")->field('pic_path')->order('sort')->select();
      //参数
      $gaModel = D('GoodsAtt');
      $info = $gaModel->where("gid=$id")->relation(true)->select();
      $info = $gaModel->doData($info);
      //描述图片
      $descPath = M('PicDesc')->where("gid=$id")->field('pic_path')->limit(4)->select();
      $this->assign('data', $data);//款式
      $this->assign('showPath', $showPath);//展示图
      $this->assign('info', $info);//参数
      $this->assign('descPath', $descPath);//描述图
      $this->assign('gData', $gData);//商品表的信息
      $this->display();
    }

    /**
     * ajax获取描述图片
     */
    public function desc()
    {
    	$data = I('get.');
      $gid = $data['gid']; //商品表的id
      $att_id = attSort($data['str']); //公共函数
      $pMap['gid'] = $gid; 
      $pMap['att_id'] = $att_id;
      $info = M('PriceStore')->where($pMap)->field('id,price,store')->find();  //价格库存表的id  一维数组
      if ($info['id']) {
         $res[] = 1;// 表示找到
         $map['pid'] = $info['id'];
         $map['gid'] = $gid;
         $m = M('PicDesc');
         $descPath = $m->where($map)->field('pic_path')->select();
         $res[] = $descPath;
         $res[] = $info['price'];
         $res[] = $info['store'];

      } else{
        $res[] = 2;//表示没找到
      }   
      echo json_encode($res);
    }

    function test()
    {
      dump($_POST);
    }
}