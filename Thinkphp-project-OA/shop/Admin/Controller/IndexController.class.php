<?php
  // 后台Index控制器
  namespace Admin\Controller;
  use Tools\AdminController;

  class IndexController extends AdminController {
    function head() {
      $this->display();
    }

    function left() {
      // 获取 session
      $admin_id=session('admin_id');
      $admin_name=session('admin_name');
      // 根据 id 获取用户信息
      $admin_info=D('Manager')->find($admin_id);
      // 角色id
      $role_id=$admin_info['mg_role_id'];
      // 角色信息
      $role_info=D('role')->find($role_id);
      // 权限ids集合
      $auth_ids=$role_info['role_auth_ids'];
      // 所有的权限集合
      if($admin_name==='admin') {
        // 如果是超级管理员，则直接获取所有权限
        // 顶级权限
        $auth_infoA=D('Auth')->where("auth_level=0")->select();
        // 次级权限
        $auth_infoB=D('Auth')->where("auth_level=1")->select();
      } else {
        // 顶级权限
        $auth_infoA=D('Auth')->where("auth_level=0 and auth_id in ($auth_ids)")->select();
        // 次级权限
        $auth_infoB=D('Auth')->where("auth_level=1 and auth_id in ($auth_ids)")->select();
      }
      
      // 把获得的权限信息传递给页面显示
      $this->assign('auth_infoA',$auth_infoA);
      $this->assign('auth_infoB',$auth_infoB);

      $this->display();
    }

    function right() {
      $this->display();
    }

    function index() {
      $this->display();
    }
  }