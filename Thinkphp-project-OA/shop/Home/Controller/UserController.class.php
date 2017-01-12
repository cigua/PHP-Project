<?php
  namespace Home\Controller;
  use Think\Controller;
  // 用户控制器
  class UserController extends Controller {
    // 登录系统
    function login() {
      // 展现模板，模板与当前操作方法名称一致
      $this->display();
    }

    // 登录系统
    function register() {
      $user=new \Model\UserModel();
      if(!empty($_POST)) {
        // $_POST['user_hobby']=implode(',',$_POST['user_hobby']);
        // $z=$user->add($_POST);
        // echo $z;
        // 调用 tp内置 create() 方法收集数据
        $data=$user->create();
        if($data) {
          $data['user_hobby']=implode(',',$data['user_hobby']);
          $z=$user->add($data);
          if($z) {
            $this->redirect('Index/index');
          }
        } else {
          $this->assign('errorInfo',$user->getError());
        }
      }
      $this->display();
    } 
  }