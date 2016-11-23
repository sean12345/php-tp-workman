<?php
/**
 * AN服务平台
 * 动态路由表
 *
 * @access  public
 * @category API
 * @version v1.0
 * @license (http://www.clcw.com.cn/licenses/LICENSE-2.0)
 * @copyright (c) 2016-2026 http://www.clcw.com.cn All rights reserved.
 */
return array(
          /*Auction*/
          array('auctionsub/api/order/add', 'Auction/Index/addSubOrder', '', array('method'=>'POST')),
          array('auctionsub/api/notice/send', 'Auction/Index/sendJpushMsg', '', array('method'=>'POST')),
          // 测试
          array('auctionsub/test/:is_fetch', 'Auction/Unittest/index', '', array('method'=>'GET')),
          array('auctionsub/test', 'Auction/Unittest/index', '', array('method'=>'GET')),
          // 说明文档
          array('auctionsub/doc/:doc_name', 'Auction/Static/doc?m_from=Auction', ' ', array('method'=>'GET')),
          array('auctionsub/doc', 'Auction/Static/doc?m_from=Auction', ' ', array('method'=>'GET')),

);