<?php
namespace Admin\Controller;
use Think\Controller;
class IndexController extends CommonController {
    public function index(){
       $this->display();
    }
    public function welcome()
    {
        $count = countPeople();
        $this->assign('count', $count);
        $this->display();
    }
    
    public function show1()
    {
        $this->display();
    }
    
    public function add(){
        $this->display();
    }
    
    
}
