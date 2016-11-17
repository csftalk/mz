<?php
namespace Admin\Controller;
use Think\Controller;
class SystemController extends CommonController {

    public function index(){
       
    }

    /**
     * 网站关闭与启用
     */
   public function setting()
   {
        if (IS_POST) {
            $val = I('post.val');
            $res = M('System')->where('id = 1')->setField('result',$val);
            if ($res) {
                echo 'ok'; die;
            } else {
                echo 'fail'; die;
            }
        }else{
            $data = M('System')->where('id = 1')->find();
            $this->assign('data', $data);
            $this->display();
        }
   }
    
   /**
     * 显示首页图片
     */
    public function advertisement()
    {   
        $m = D('System');
        $list = $m->where('id in (2,3,4,5,6)')->select();
        $list = $m->dispose($list);
        // dump($list);die;
        $this->assign('list', $list);
        $this->display();
    }
    
    /**
     * 添加首页图片
     */
    public function advertisement_add()
    {
        if (IS_POST) {

                if ($_FILES['file']['name'] == '') {
                $this->error('请选择展示图片！！');
                die;
                }
                if (I('post.link') == '') {
                    $this->error('请输入图片链接！！');
                    die;
                }
                if (I('post.sort') == '') {
                    $this->error('请输入图片排序！！');
                    die;
                }
                $config = array(
                            'mimes'         =>  array(), //允许上传的文件MiMe类型
                            'maxSize'       =>  0, //上传的文件大小限制 (0-不做限制)
                            'exts'          =>  array('jpg', 'gif', 'png', 'jpeg'), //允许上传的文件后缀
                            'autoSub'       =>  false, //自动子目录保存文件
                            //'subName'       =>  array('date', 'Y-m-d'), //子目录创建方式，[0]-函数名，[1]-参数，多个参数使用数组
                            'rootPath'      =>  './Public/Uploads/', //保存根路径
                            'savePath'      =>  'Advertisement/',//保存路径
                          
                    );
                $up = new \Think\Upload($config);
                $info =  $up->uploadOne($_FILES['file']);
                if ($info) {
                        $id = I('get.id');
                        $m = M('System');
                        $arr = $m->where("id = $id")->find();
                        @unlink('./Public/Uploads/'.$arr['because']);
                        $data['because'] = $info['savepath'].$info['savename'];
                        $data['result'] = I('post.link');
                        $data['course'] = I('post.sort');
                        $res = M('System')->where("id = $id")->save($data);
                        if ($res) {
                            $this->success('新增/修改成功！！！', U('advertisement'));
                        } else {
                            @unlink('Public/Uploads/'.$data['because']);
                            $this->error('新增/修改失败！！！');
                        }
                } else {

                    $this->error($up->getError());
                }
                   
            } else {
                $id=I('get.id');
                $this->assign('id', $id);
                $this->display();
            }




    }

    /**
     * ajax删除首页图片
     */
    public function advertisement_del() 
    {
                    $id = I('get.id');
                    $m = M('System');
                    $info = $m->where("id = $id")->find();
                    @unlink('./Public/Uploads/'.$info['because']);
                    $data['because'] = '';
                    $data['result'] = '';
                    $data['course'] = '';
                    $res = $m->where("id = $id")->save($data);
                    if ($res) {
                        echo 'ok';die;
                    } else {
                        echo 'fail';die;
                    }
    }


    /**
     * ajax修改链接/属性
     */
    public function advertisement_save()
    {
        $id = I('post.id');
        $name = I('post.name');
        $val = I('post.val');
        if ($name == 'link') {
            $name = 'result';
        } else {
            $name = 'course';
        }
        $res = M('System')->where("id = $id")->setField($name,$val);
        if ($res) {
            echo 'ok';die;
        } else {
            echo 'fail';die;
        }

    }



}
