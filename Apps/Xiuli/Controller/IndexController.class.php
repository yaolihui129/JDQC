<?php
namespace Xiuli\Controller;
use Think\Controller;
class IndexController extends Controller {
    public function index(){
    
        if(!($_SESSION['init'])){
                $m=D('product');
                $data=$m->find(1);
                $_SESSION['web']=$data['web'];
                $_SESSION['adress']=$data['adress'];
                $_SESSION['desc']=$data['desc'];
                $_SESSION['phone']=$data['phone'];
                $_SESSION['tel']=$data['tel'];
                $_SESSION['qq']=$data['qq'];
                $_SESSION['weburl']=$data['url'];
                $_SESSION['record']=$data['record'];                
                $_SESSION['img']=$data['path'].$data['img'];
                $_SESSION['init']=1;                      
            }
            $_SESSION['ip']=get_client_ip();
            $_SESSION['browser']=GetBrowser();
            $_SESSION['os']=GetOs();
            
        
        
        $m=D('tp_ad');
        $where['prodid']=1;
        $pic=$m->where($where)->order('utime desc')->select();
        $this->assign('pic',$pic);
        
        $m=D('xl_prodservice');
        $where['istj']=1;
        $data=$m->where($where)
                ->field("id,mark,name,state,money,smoney,num,istj,cate,path,img,utime")
                ->order('utime desc')
                ->select();
        $this->assign('data',$data);
     
        $this->display();
        
        
    }
}