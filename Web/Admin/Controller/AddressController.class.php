<?php
/**
 * 魅族商城
 * =========================================================================
 * 版权所有:“年年19”开发小组
 * 网站地址: http://mz.7hyd.com
 * -------------------------------------------------------------------------
 * Author: 游安明
 * Date: 2016-10-26
 * =========================================================================
 */
namespace Admin\Controller;
use Think\Controller;
// use Think\Page;

class AddressController extends CommonController 
{
    public function index()
    {

        $getman = I('getman') ? I('getman') : '';
        $phone = I('phone') ? I('phone') : '';
        $province = I('province') ? I('province') : '';
        $city = I('city') ? I('city') : '';
        $district = I('district') ? I('district') : '';
        $detailed = I('detailed') ? I('detailed') : '';
        $map['getman'] = array('like',"%$getman%");
        $map['phone'] = array('like',"%$phone%");
        $map['detailed'] = array('like',"%{$province}{$city}{$district}{$detailed}%");
        $map['_logic'] = 'AND';

        $address = D('Address');
        $total = $address->where($map)->count();
        $page = new \Org\Yam\Page ($total, C('PAGE_NUM'));
        
        $arr = $address->alias('a')->field('a.*,u.username')->join('left join __USERS__ as u on a.uid=u.id')->where($map)->limit($page->firstRow.','.$page->listRows)->getData();
        // echo $address->_sql();die();
        // dump($total);die;

        $btn = $page->show();

        $this->assign('list', $arr);
        $this->assign('btn', $btn);
        $this->display();
        
    } 

    public function add()
    {
        if(IS_POST){
    		$data['uid'] = I('uid');
    		$data['getman'] = I('getman');
    		$data['phone'] = I('phone');
    		$data['province'] = I('province');
    		$data['city'] = I('city');
    		$data['district'] = I('district');
    		$data['detailed'] = I('detailed');

    		$address = D('Address');
            if ($address->create($data)) {
                $res = $address->add($data);
                //验证通过
        		if ($res) {
        			$this->success('添加成功！');
        		} else {
        			// echo $address->_sql();die;
        			$this->error('添加失败！');
        		}
            } else {
                //验证失败
                $this->error($address->getError());
            }

        }else{

            //三级联动数据
            if($_GET['areaId']){
                $where['parentid']=$_GET['areaId'];
                $area = D('Area')->where($where)->select();
                $this->ajaxReturn($area);
            }
            $this->display();
        }
    }

    /**
     * 删除地址
     * @param  int $id 要删除的ID
     */
    public function del($id)
    {
        $res = M('Address')->delete($id);
        if ($res) {
            $this->success('删除成功');
        } else {
            $this->error('删除失败');
        }
    }

    public function edit(){
    	$id = I('get.id');
    	// dump($id);
        if(IS_POST){
            $data['getman'] = I('getman');
            $data['phone'] = I('phone');
            $data['province'] = I('province');
            $data['city'] = I('city');
            $data['district'] = I('district');
            $data['detailed'] = I('detailed');
            $data['id'] = I('id');
            // dump($data);

            $address = D('Address');
            if ($address->create($data)) {
                //验证通过
                if ($address->where('id='.$data['id'])->save()) {
                    $this->success('修改地址成功！');
                } else {
            		// echo $address->_sql();die();
                    $this->error('修改地址信息失败！');
                }
            } else {
                $this->error($address->getError());
            }
            return;

        }else{
            
            //三级联动数据
            if($_GET['areaId']){
                $data['parentid']=$_GET['areaId'];
                $area = D('Area')->where($data)->select();
                $this->ajaxReturn($area);
            }

            $res = D('Address');
			$info = $res->find($id);
            $user = $res->table('__USERS__')->where('id='.$info['uid'])->find();

            $area = D('area');
            //查出所有的省
            $province = $area->where('parentid=0')->select();

            //查出当前条地址保存的省下面的市
            $city = $area->where(['parentid'=>$info['province']])->select();

            //查出当前条地址保存的市下面的所有的县
            $district = $area->where(['parentid'=>$info['city']])->select();
            
	        $this->assign('province', $province);
	        $this->assign('city', $city);
	        $this->assign('district', $district);
	        $this->assign('listC', $info);
            $this->assign('user', $user);
	        $this->display();

        }
    }

    //导出Excel
    public function out()
    {
        $getman = I('getman') ? I('getman') : '';
        $phone = I('phone') ? I('phone') : '';
        $province = I('province') ? I('province') : '';
        $city = I('city') ? I('city') : '';
        $district = I('district') ? I('district') : '';
        $detailed = I('detailed') ? I('detailed') : '';
        $map['getman'] = array('like',"%$getman%");
        $map['phone'] = array('like',"%$phone%");
        $map['detailed'] = array('like',"%{$province}{$city}{$district}{$detailed}%");
        $map['_logic'] = 'AND';

        $address = D('Address');
        $arr = $address->alias('a')->field('a.*,u.username')->join('left join __USERS__ as u on a.uid=u.id')->where($map)->getData();
        // dump($arr);die;
        $data = array();
        foreach ($arr as $v) {
            $data[] = array($v['id'],$v['uid'],$v['getman'],$v['phone'],$v['province'].$v['city'].$v['district'].$v['detailed']);
        }
        // var_dump($data);die;

        //导入PHPExcel类库，因为PHPExcel没有用命名空间，只能inport导入
        import("Org.Util.PHPExcel");
        import("Org.Util.PHPExcel.Writer.Excel5");
        import("Org.Util.PHPExcel.IOFactory.php");

        $filename="地址_excel";
        $headArr=array("ID","用户名","收货人","联系人","地址");
        $this->getExcel($filename,$headArr,$data);
    }

    private function getExcel($fileName,$headArr,$data)
    {
            //对数据进行检验
            if(empty($data) || !is_array($data)){
                die("data must be a array");
            }
            //检查文件名
            if(empty($fileName)){
                exit;
            }

            $date = date("Y_m_d",time());
            $fileName .= "_{$date}.xls";

            //创建PHPExcel对象，注意，不能少了\
            $objPHPExcel = new \PHPExcel();
            $objProps = $objPHPExcel->getProperties();
            
            //设置表头
            $key = ord("A");
            foreach($headArr as $v){
                $colum = chr($key);
                $objPHPExcel->setActiveSheetIndex(0) ->setCellValue($colum.'1', $v);
                $key += 1;
            }
            
            $column = 2;
            $objActSheet = $objPHPExcel->getActiveSheet();
            foreach($data as $key => $rows){ //行写入
                $span = ord("A");
                foreach($rows as $keyName=>$value){// 列写入
                    $j = chr($span);
                    $objActSheet->setCellValue($j.$column, $value);
                    $span++;
                }
                $column++;
        }

            $fileName = iconv("utf-8", "gb2312", $fileName);
            //重命名表
            // $objPHPExcel->getActiveSheet()->setTitle('test');
            //设置活动单指数到第一个表,所以Excel打开这是第一个表
            $objPHPExcel->setActiveSheetIndex(0);
            header('Content-Type: application/vnd.ms-excel');
            header("Content-Disposition: attachment;filename=\"$fileName\"");
            header('Cache-Control: max-age=0');

            $objWriter = \PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
            $objWriter->save('php://output'); //文件通过浏览器下载
            exit;
        }

}
