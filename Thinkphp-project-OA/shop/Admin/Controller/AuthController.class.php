<?php
  // 权限控制器
  namespace Admin\Controller;
  use Tools\AdminController;
  class AuthController extends AdminController {
    // 所有权限列表展示
    function showlist() {
      $info=D('Auth')->order('auth_path')->select();
      $this->assign('info',$info);
      $this->display();
    }

    // 添加权限
    function tianjia() {
      $auth=new \Model\AuthModel();
      if(!empty($_POST)) {
        $z=$auth->saveData($_POST);
        dump($z);
        // if($z) {
        //    $this->redirect();
        // } else {
        //    $this->redirect();
        // }
      } else {
        $auth_infoA=$auth->where('auth_level=0')->select();
        $this->assign('auth_infoA',$auth_infoA);
        $this->display();
      }
    }
  }