<?php
namespace Admin\Controller;
class ProdserviceController extends CommonController {
    public function index(){
        $m=D('tp_cate');
        $where['prodid']=$_SESSION['prodid'];
        $arr=$m->where($where)->order('sn')->select();
        $this->assign('arr',$arr);
        /*实例化模型*/
        $cate=!empty($_GET['cate']) ? $_GET['cate'] : $arr['0']['id'];
        $m=D('xl_prodservice');
        $map[cate]=$cate;
        $data=$m->where($map)->select();
        $this->assign('data',$data);
//         dump($data);
        $this->assign('cate',$cate);
        /*新增*/
        $this -> assign("state", formselect());
        
        $this->display();
    }
    
    
    public function add(){
        /*实例化模型*/
        $m=D('tp_cate');
        $arr=$m->find($_GET['cate']);
        if ($arr){
            $where['pid']=$arr['pid'];             
        }else {
            $where['pid']=0;
        }
        $m=D('tp_cate');
        $where['prodid']=$_SESSION['prodid'];
        $arr=$m->where($where)->select();
        $this->assign('arr',$arr);
        //dump($arr);
        $m=D('xl_prodservice');
        $map['cate']=$arr['id'];
        $count=$m->where($map)->count()+1;
        $this->assign("c",$count);       
        $this->assign("cate",$_GET['cate']);
        $this->display();
    
    } 
    
    
    public function insert(){
    
        $m=D('xl_prodservice');
         
        $_POST['moder']=$_SESSION['realname'];
        $_POST['prodid']=$_SESSION['prodid'];
    
        if(!$m->create()){
            $this->error($m->getError());
        }
        $lastId=$m->add();
        if($lastId){
            $this->success("成功");
        }else{
            $this->error('失败');
        }
    }
    
    public function order(){
        /* 实例化模型*/
        $db = D('xl_prodservice');
        $num = 0;
        foreach($_POST['sn'] as $id => $sn) {
            $num += $db->save(array("id"=>$id, "sn"=>$sn));
        }
        if($num) {
            $this->success("排序成功!");
    
        }else{
            $this->error("排序失败...");
        }
    }
    
    public function mod(){
        $m=D('xl_prodservice');
        $arr=$m->find($_GET[id]);
        $this->assign('arr',$arr);
               
        $this->display();
    }
    
    
    public function update(){
        /* 实例化模型*/
        $db=D('xl_prodservice');
        $_POST['moder']=$_SESSION['realname'];
        if ($db->save($_POST)){
            $this->success("修改成功！");
        }else{
            $this->error("修改失败！");
        }
    }
    
    public function img(){
        $m=D('xl_prodservice');
        $arr=$m->find($_GET[id]);
        $this->assign('arr',$arr);
    
        $this->display();
    }
    
    public function pic(){
        $upload = new \Think\Upload();// 实例化上传类
        $upload->maxSize =     7145728 ;// 设置附件上传大小
        $upload->exts     =     array('jpg', 'gif', 'png', 'jpeg');// 设置附件上传类型
        $upload->rootPath =  './Upload/'.$_SESSION['qz'].'/';// 设置附件上传目录
        $upload->savePath = '/Product/'; // 设置附件上传目录
    
        $info  =   $upload->upload();
    
        if(!$info) {// 上传错误提示错误信息
            $this->error($upload->getError());
        }else{// 上传成功 获取上传文件信息
            $_POST['path']=$info['img']['savepath'];
            $_POST['img']=$info['img']['savename'];
            /* 实例化模型*/
            $db=D('xl_prodservice');
            if ($db->save($_POST)){
                $image = new \Think\Image();
                $image->open('./Upload/'.$_SESSION['qz'].$info['img']['savepath'].$info['img']['savename']);
                //$image->thumb(800, 400,\Think\Image::IMAGE_THUMB_SCALE)->save('./Upload/'.$info['img']['savepath'].$info['img']['savename']);  //从中央剪裁
                $image->thumb(800, 400)->save('./Upload/'.$_SESSION['qz'].$info['img']['savepath'].$info['img']['savename']);   //等比例缩放
                $this->success("上传成功！");
            }else{
                $this->error("上传失败！");
            }
        }
    }
    
    public function del(){
        /* 接收参数*/
        $id = !empty($_POST['id']) ? $_POST['id'] : $_GET['id'];
        /* 实例化模型*/
        $m=D('xl_prodservice');
        $count =$m->delete($id);
        if ($count>0) {
            $this->success('删除成功');
        }else{
            $this->error('删除失败');
        }
    
    }
    
    
    
}