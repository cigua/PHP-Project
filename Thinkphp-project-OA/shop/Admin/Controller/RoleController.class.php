<?php
  // 角色控制器
  namespace Admin\Controller;
  use Tools\AdminController;
  class RoleController extends AdminController {
    // 所有角色列表展示
    function showlist() {
      $info=D('Role')->select();
      $this->assign('info',$info);
      $this->display();
    }
    // 分配权限
    function distribute($role_id) {
      $role=new \Model\RoleModel();
      if(!empty($_POST)) {
        $z=$role->saveAuth($role_id,$_POST['auth_id']);
        if($z) {
          $this->redirect('showlist',array(),2,'添加权限成功');
        } else {
          $this->redirect('distribute',array('role_id',$role_id),2,'添加权限失败');
        }
      } else {
        // 根据传递过来的 $role_id 查询对于的角色信息
        $role_info=D('Role')->find($role_id);
        // 角色原先就有的权限数组
        $have_auth=explode(',',$role_info['role_auth_ids']);
        // 顶级权限
        $auth_infoA=D('Auth')->where('auth_level=0')->select();
        // 次级权限
        $auth_infoB=D('Auth')->where('auth_level=1')->select();

        $this->assign('have_auth',$have_auth);
        $this->assign('auth_infoA',$auth_infoA);
        $this->assign('auth_infoB',$auth_infoB);
        $this->assign('role_info',$role_info);
        $this->display();
      }
    }
  }