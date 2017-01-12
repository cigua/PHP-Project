<?php
  // 后台商品控制器
  namespace Admin\Controller;
  use Tools\AdminController;

  class GoodsController extends AdminController {
    // 列表展示
    // function showlist() {
    //   // 实例化Model对象
    //   $goods=new \Model\GoodsModel();
    //   $info=$goods->select('20,25');
    //   // 绑定模板变量
    //   $this->assign('info',$info);
    //   $this->display();
    // }
    function showlist() {
      $goods=D('Goods');
      // 分页
      // 总记录数
      $cnt=$goods->count();
      // 每页显示的记录数
      $per=7;
      $page_obj=new \Tools\Page($cnt,$per);
      $sql="select * from sw_goods order by goods_id desc ".$page_obj->limit;
      $info=$goods->query($sql);
      // 页码列表,默认左右两边最多显示 4 个
      $pagelist=$page_obj->fpage(array(3,4,5,6,7,8));

      $this->assign('info',$info);
      $this->assign('pagelist',$pagelist);
      $this->display();
    }
    // 添加商品
    function tianjia() {
      $goods=D('Goods');
      if(!empty($_POST)){
        // dump($_FILES);
        if($_FILES['goods_pic']['error'] === 0) {
          // 设置上传图片文件的存储位置
          $cfg=array(
            'rootPath'=>'./Public/Upload'
          );
          $up=new \Think\Upload($cfg);
          // 上传附件
          $z=$up->uploadOne($_FILES['goods_pic']);
          // 完整路径，便于保存到数据库
          $bigpicname=$up->rootPath.$z['savepath'].$z['savename'];
          $_POST['goods_big_img']=substr($bigpicname,2);

          // 给上传的图片制作缩略图
          $im=new \Think\Image();
          $im->open($bigpicname);
          // 如果原图不是正方形，则按照较大的尺寸，进行等比例缩放
          $im->thumb(150,150);
          $smallpicname=$up->rootPath.$z['savepath']."small_".$z['savename'];
          $im->save($smallpicname);
          // 将缩略图路径保存到数据库
          $_POST['goods_small_img']=substr($smallpicname,2);
        }
        // 收集表单数据
        $data=$goods->create();
        $z=$goods->add($data);
        if($z) {
          $this->redirect('showlist',array(),2,'添加商品成功！');
        } else {
          $this->redirect('tianjia',array(),2,'添加商品失败！');
        }
      } else {
        // 展示表单
        $this->display();
      }
    }
    // 修改/更新商品
    function upd($goods_id) {
      // $goods=D('goods');
      // $goods->goods_name='坚果手机';
      // $goods->goods_price=3500;
      // $goods->weight=116;
      // $z=$goods->where('goods_id=2')->save();
      // dump($z);
      // $info=D('goods')->select($goods_id);
      $goods=D('goods');
      if(!empty($_POST)) {
        $z=$goods->save($_POST);
        if($z) {
          $this->redirect('showlist',array(),2,'修改商品成功！');
        } else {
          $this->redirect('upd',array('goods_id'=>$goods_id),2,'修改商品失败！');
        }
      } else {
        $info=$goods->find($goods_id);
        $this->assign('info',$info);
        $this->display();
      }
    }
  }