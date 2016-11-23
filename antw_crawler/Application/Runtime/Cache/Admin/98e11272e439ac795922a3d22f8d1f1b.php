<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html lang="zh-cn" class="no-js fixed-layout">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <title>蚁巢服务管理平台</title>
        <meta name="description" content="">
        <meta name="keywords" content="admin">
        <meta name="renderer" content="webkit">
        <meta http-equiv="Cache-Control" content="no-siteapp" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="icon" type="image/png" href="http://local.antnest.clcw.com.cn/Application/Admin/Public/Images/favicon.png">
        <link rel="apple-touch-icon-precomposed" href="http://local.antnest.clcw.com.cn/Application/Admin/Public/images/app-icon72x72@2x.png">
        <meta name="apple-mobile-web-app-title" content="Amaze UI" />
        <link rel="stylesheet" href="http://local.antnest.clcw.com.cn/Application/Admin/Public/Css/amazeui.css"/>
        <link rel="stylesheet" href="http://local.antnest.clcw.com.cn/Application/Admin/Public/Css/admin.css">

        <!--[if lt IE 9]>
        <script src="http://libs.baidu.com/jquery/1.11.1/jquery.min.js"></script>
        <script src="http://cdn.staticfile.org/modernizr/2.8.3/modernizr.js"></script>
        <script src="assets/js/amazeui.ie8polyfill.min.js"></script>
        <![endif]-->

        <!--[if (gte IE 9)|!(IE)]><!-->
        <script src="http://local.antnest.clcw.com.cn/Application/Admin/Public/Js/jquery.min.js"></script>
        <!--<![endif]-->
        <script src="http://local.antnest.clcw.com.cn/Application/Admin/Public/Js/amazeui.js"></script>
        <script src="http://local.antnest.clcw.com.cn/Application/Admin/Public/Js/app.js"></script>
        <script type='text/javascript' src="http://local.antnest.clcw.com.cn/Application/Admin/Public/Js/jquery.form.js"></script>
    </head>
    <body>


<!--[if lte IE 9]>
<p class="browsehappy">你正在使用<strong>过时</strong>的浏览器，Amaze UI 暂不支持。 请 <a href="http://browsehappy.com/" target="_blank">升级浏览器</a>
  以获得更好的体验！</p>
<![endif]-->

<header class="am-topbar am-topbar-inverse admin-header">
  <div class="am-topbar-brand">
    <strong>Ant-nest</strong> <small>蚁巢服务管理平台</small>
  </div>

  <button class="am-topbar-btn am-topbar-toggle am-btn am-btn-sm am-btn-success am-show-sm-only" data-am-collapse="{target: '#topbar-collapse'}"><span class="am-sr-only">导航切换</span> <span class="am-icon-bars"></span></button>

  <div class="am-collapse am-topbar-collapse" id="topbar-collapse">

    <ul class="am-nav am-nav-pills am-topbar-nav am-topbar-right admin-header-list">   
      <!-- li><a href="javascript:;"><span class="am-icon-envelope-o"></span> 收件箱 <span class="am-badge am-badge-warning">5</span></a></li -->
      <li class="am-dropdown" data-am-dropdown>
        <a class="am-dropdown-toggle" data-am-dropdown-toggle href="javascript:;">
          <span class="am-icon-users"></span> 管理员 <span class="am-icon-caret-down"></span>
        </a>
        <ul class="am-dropdown-content">
          <!-- <li><a href="#"><span class="am-icon-user"></span> 资料</a></li> -->
          <!-- <li><a href="#"><span class="am-icon-cog"></span> 设置</a></li> -->
          <li><a href="<?php echo U('admin/logout');?>"><span class="am-icon-power-off"></span> 退出</a></li>
        </ul>
      </li>
      <li class="am-hide-sm-only"><a href="javascript:;" id="admin-fullscreen"><span class="am-icon-arrows-alt"></span> <span class="admin-fullText">开启全屏</span></a></li>
    </ul>
  </div>
</header>

<div class="am-cf admin-main">
  <!-- sidebar start -->
  <div class="admin-sidebar am-offcanvas" id="admin-offcanvas">

      <div class="am-offcanvas-bar admin-offcanvas-bar">

      <ul class="am-list admin-sidebar-list">
        <li><a href="<?php echo U('admin/main');?>"><span class="am-icon-home"></span> 首页</a></li>


        <li class="admin-parent">
          <a class="am-cf" data-am-collapse="{target: '#collapse-nav-nav1'}"><span class="am-cf"></span> 系统模块<span class="am-icon-angle-right am-fr am-margin-right"></span></a>
          <ul class="am-list am-collapse admin-sidebar-sub am-in" id="collapse-nav-nav1">
            <li><a href="<?php echo U('admin/debuger/sms');?>"><span class="am-cf"></span> 接口调试</a></li>
          </ul>
        </li>

        <li class="admin-parent">
          <a class="am-cf" data-am-collapse="{target: '#collapse-nav-nav2'}"><span class="am-cf"></span> SMS短信服务<span class="am-icon-angle-right am-fr am-margin-right"></span></a>
          <ul class="am-list am-collapse admin-sidebar-sub am-in" id="collapse-nav-nav2">
            <!-- <li><a href="<?php echo U('admin/debuger/sms');?>"><span class="am-icon-bug"></span> 接口调试</a></li> -->
            <li><a href="<?php echo U('admin/log/monitor');?>"><span class="am-cf"></span> 服务监控</a></li>
            <!-- <li><a href=""><span class="am-cf"></span> 访问日志</a></li> -->
            <li><a href="<?php echo U('admin/log/taskservice');?>"><span class="am-cf"></span> 任务服务日志</a></li>
          </ul>
        </li>

        <li class="admin-parent">
          <a class="am-cf" data-am-collapse="{target: '#collapse-nav-nav2'}"><span class="am-cf"></span> 来拍车订阅<span class="am-icon-angle-right am-fr am-margin-right"></span></a>
          <ul class="am-list am-collapse admin-sidebar-sub am-in" id="collapse-nav-nav2">
            <!-- <li><a href="<?php echo U('admin/debuger/sms');?>"><span class="am-icon-bug"></span> 接口调试</a></li> -->
            <li><a href="<?php echo U('admin/auction/monitor');?>"><span class="am-cf"></span> 车商订阅服务监控</a></li>
            <!-- <li><a href=""><span class="am-cf"></span> 访问日志</a></li> -->
            <li><a href="<?php echo U('admin/auction/taskservice');?>"><span class="am-cf"></span> 任务服务日志</a></li>
          </ul>
        </li>

        <!-- li class="admin-parent">
          <a class="am-cf" data-am-collapse="{target: '#collapse-nav-nav3'}"><span class="am-cf"></span> 用户中心服务<span class="am-icon-angle-right am-fr am-margin-right"></span></a>
          <ul class="am-list am-collapse admin-sidebar-sub am-in" id="collapse-nav-nav3">
            <li><a href="admin-log.html"><span class="am-cf"></span> 访问日志</a></li>
          </ul>
        </li -->
        
      </ul>

      <div class="am-panel am-panel-default admin-sidebar-panel">
        <div class="am-panel-bd">
          <p><span class="am-icon-bookmark"></span> 公告</p>
          <p></p>
        </div>
      </div>

    </div>
  </div>
  <!-- sidebar end -->

  <!-- content start -->
  <div class="admin-content">


    <div class="admin-content-body">

         <div class="am-cf am-padding">
    <div class="am-fl am-cf"><strong class="am-text-primary am-text-lg">拍单订阅服务</strong> / <small>服务监控</small></div>
</div>

<hr>
<ul class="am-avg-sm-1 am-avg-md-4 am-margin am-padding am-text-center admin-content-list ">
  <li><a class="am-text-danger"><span class="am-icon-btn am-icon-recycle"></span><br/>拍单订阅分发任务数<br/><?php echo ($suborder_task_count); ?></a></li>
  <li><a class="am-text-secondary"><span class="am-icon-btn am-icon-recycle"></span><br/>拍单订阅推送任务数<br/><?php echo ($subpush_task_count); ?></a></li>
</ul>

<div class="am-g">
  <div class="am-u-md-12">
    <div class="am-panel am-panel-default">
      <div class="am-panel-hd am-cf" >拍单订阅服务开关</div>
      <div id="collapse-panel-3" class="am-in">
              <div class="am-margin">
                <button type="button" class="am-btn am-btn-success" id="am-btn-start-service"> 启动服务</button>
                <button type="button" class="am-btn am-btn-warning" id="am-btn-stop-service"> 停止服务</button>
                <div class="am-alert am-alert-danger" id="am-alert-tag" style="display: none;" data-am-alert>
                    <p></p>
                </div>
              </div>                
            <div class="am-u-sm-12 am-u-sm-centered">
                <pre class="">
                    </br>
                    <?php if(is_array($subpush_service_status)): foreach($subpush_service_status as $key=>$line): echo ($line); ?> . </br><?php endforeach; endif; ?>
                </pre>
            </div>
      </div>
    </div>
  </div>
</div>

<div class="am-modal am-modal-confirm" tabindex="-1" id="am-confirm-sms-stop">
  <div class="am-modal-dialog">
    <div class="am-modal-hd"></div>
    <div class="am-modal-bd" id="am-confirm-sms-tag">您确定要停止订阅推送处理服务吗？</div>
    <div class="am-modal-footer">
      <span class="am-modal-btn" data-am-modal-confirm>确定</span>
      <span class="am-modal-btn" data-am-modal-cancel>取消</span>
    </div>
  </div>
</div>

<div class="am-modal am-modal-confirm" tabindex="-1" id="am-confirm-sms-start">
  <div class="am-modal-dialog">
    <div class="am-modal-hd"></div>
    <div class="am-modal-bd" id="am-confirm-sms-tag">您确定要启动订阅推送服务吗？</div>
    <div class="am-modal-footer">
      <span class="am-modal-btn" data-am-modal-confirm>确定</span>
      <span class="am-modal-btn" data-am-modal-cancel>取消</span>
    </div>
  </div>
</div>

  <script type="text/javascript">

    $(function() {

              $('#am-btn-stop-service').on('click', function() {
                    var $btn = $(this);
                    $btn.button('loading');
                    $('#am-confirm-sms-stop').modal({
                          relatedTarget: this,
                          onConfirm: function(options) {
                                  $.ajax({
                                    url: '/Admin/Auction/ajaxSubPushServiceStop',
                                    type: 'post',
                                    dataType: 'json',
                                    data: '',
                                    success: function(data) {
                                          if (data.code == '000000') {
                                              refresh();
                                          } else {
                                              $("#am-alert-tag p").html('code: ' + data.code + ', msg: ' + data.msg);
                                              $("#am-alert-tag").show();
                                              $btn.button('reset');
                                          }
                                    },
                                    error: function(e) {
                                              $("#am-alert-tag p").html('当前ajax请求失败');
                                              $("#am-alert-tag").show();
                                              $btn.button('reset');
                                    }
                                  });
                          },
                          onCancel: function() {
                                $btn.button('reset');
                          }
                    });
                });

                $('#am-btn-start-service').on('click', function() {
                    var $btn = $(this);
                    $btn.button('loading');
                    $('#am-confirm-sms-start').modal({
                        relatedTarget: this,
                        onConfirm: function(options) {
                                  $.ajax({
                                    url: '/Admin/Auction/ajaxSubPushServiceStart',
                                    type: 'post',
                                    dataType: 'json',
                                    data: '',
                                    success: function(data) {
                                          if (data.code == '000000') {
                                              refresh();
                                          } else {
                                              $("#am-alert-tag p").html('code: ' + data.code + ', msg: ' + data.msg);
                                              $("#am-alert-tag").show();
                                              $btn.button('reset');
                                          }
                                    },
                                    error: function(e) {
                                              $("#am-alert-tag p").html('当前ajax请求失败');
                                              $("#am-alert-tag").show();
                                              $btn.button('reset');
                                    }
                                  });
                        },
                        onCancel: function() {
                            $btn.button('reset');
                        }
                    });
                  });
    });
    
    function refresh(){
        window.location.reload();//刷新当前页面.
    }
  </script>
    </div>


    <footer class="admin-content-footer">
      <hr>
      <p class="am-padding-left">© 2016 CLCW Inc. Licensed under MIT license.</p>
    </footer>
  </div>
  <!-- content end -->

</div>

<a href="#" class="am-icon-btn am-icon-th-list am-show-sm-only admin-menu" data-am-offcanvas="{target: '#admin-offcanvas'}"></a>

</body>
</html>