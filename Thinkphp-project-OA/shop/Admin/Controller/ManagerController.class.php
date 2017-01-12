<?php
  namespace Admin\Controller;
  // use Tools\AdminController;
  use Think\Controller;
  use Think\Verify;

  class ManagerController extends Controller {
    // 登录系统
    function login(){
      if(!empty($_POST)) {
        $vry=new \Think\Verify();
        if($vry->check($_POST['captcha'])) {
          $userpwd=array(
            'mg_name'=>$_POST['admin_user'],
            'mg_pwd'=>$_POST['admin_psd']
          );
          $info=D('Manager')->where($userpwd)->find();
          if($info) {
            session('admin_name',$info['mg_name']);
            session('admin_id',$info['mg_id']);
            $this->redirect('Index/index');
          } else {
            dump($info);
          }
        } else {
          echo '验证码错误';
        }
      }
      $this->display();
    }
    
    // 退出系统
    function logout() {
      // 清除所有 session
      session(null);
      $this->redirect('Manager/login');
    }

    // 生成验证码
    function verifyImg() {
      $cfg=array(
        'imageH'=>24,
        'imageW'=>90,
        'fontSize'=>13,
        'length'=>4,
        'fontttf'=>'4.ttf'
      );
      // 实例化 tp框架自带的验证码类
      $very=new \Think\Verify($cfg);
      $very->entry();
    }
  }