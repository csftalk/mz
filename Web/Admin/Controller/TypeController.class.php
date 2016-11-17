<?php
/**
 * 魅族商城
 * =========================================================================
 * 版权所有:“年年19”开发小组
 * 网站地址: http://mz.7hyd.com
 * -------------------------------------------------------------------------
 * Author: 游安明
 * Date: 2016-10-118
 * =========================================================================
 */
namespace Admin\Controller;
use Think\Controller;
class TypeController extends CommonController 
{
    public function index()
    {
    	$arr = D('Type')->getTree();
    	$this->assign('list', $arr);
        $this->display();
    }

    /**
     * 添加商品分类
     */
	public function add()
    {

    	if (IS_POST) {
    		$data['name'] = I('name');
    		$data['pid'] = I('pid',0,'int'); //PID通常是整型，所以处理为整型

    		$typeModel = D('Type');
    		if ($typeModel->create($data)) {
    			//验证通过
                $res = $typeModel->add($data);
    			if ($res) {
    				//M添加成功
    				$this->success('添加成功！', U('index'), 1);
    			} else {
    				$this-> error('添加失败！');
    			}
    		} else {
    			//M验证失败
    			$this->error($typeModel->getError());
    		}
    		return;
    	}
    	//载入添加分类页面
    	//获取所有分类
    	$res = D('Type')->getTree();
    	$this->assign('list', $res);
    	$this->display();
    }
    
    /**
     * 删除商品分类
     * @param  int $id 要删除的ID
     */
    public function del($id)
    {
        $where['tid'] = I('get.id');
        $res = D('Type');
        $ordersMoled = M('Goods');
        $orders = $ordersMoled->where($where)->select();
        $goodsattMoled = M('TypeAtt');
        $typeAtt = $goodsattMoled->where($where)->select();

        if ($typeAtt != false) {
            $this->error('分类下有属性，不可删除');
        }

        if ($orders != false) {
            $this->error('分类下有商品，不可删除');
        }

        if ($res->delete(I('get.id', 0)) !== false) {
            $this->success('删除成功');
        } else {
            $this->error($res->getError());
        }
    }

    public function edit($id)
    {
        $id = I('id');
        // dump($id);

        if (IS_POST) {
            //更新分类
            $data['name'] = I('name');
            $data['pid'] = I('pid', 0 ,'int');
            $data['id'] = $id;

            $typeModel = D('Type');
            $ids =  $typeModel->getSubIds($data['id']);
            if (in_array($data['pid'],$ids)) {
                $this->error('抱歉，不能把当前分类及其子分类作为其上级分类');
            }

            // dump($data);
            if ($typeModel->create($data)) {
                //验证通过
                if ($typeModel->save()) {
                    $this->success('修改分类成功！', U('index'), 1);
                } else {
                    $this->error('修改分类失败！');
                }
            } else {
                $this->error($typeModel->getError());
            }
            return;
        }

    	$lis = M('Type')->find($id);
        $list = D('Type')->getTree();
        $this->assign('list', $list);
        $this->assign('lis', $lis);
        $this->display();
    }

    //导出Excel
    public function out()
    {
        $arr = M('Type')->select();
        $data = array();
        foreach ($arr as $v) {
            $data[] = array($v['id'],$v['pid'],$v['name']);
        }
        // var_dump($data);die;

        //导入PHPExcel类库，因为PHPExcel没有用命名空间，只能inport导入
        import("Org.Util.PHPExcel");
        import("Org.Util.PHPExcel.Writer.Excel5");
        import("Org.Util.PHPExcel.IOFactory.php");

        $filename="type_excel";
        $headArr=array("分类ID","分类PID","分类名称");
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