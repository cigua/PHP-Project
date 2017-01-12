<?php
  namespace Home\Controller;
  use Think\Controller;
  // 商品控制器
  class GoodsController extends Controller {
    // 商品列表展示
    function showlist() {
      $this->display();
    }

    // 商品详情
    function detail() {
      $this->display();
    } 
  }