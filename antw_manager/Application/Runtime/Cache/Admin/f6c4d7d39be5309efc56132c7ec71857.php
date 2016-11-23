<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html lang="zh-cn" class="no-js fixed-layout">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <title>蚁巢业务服务管理平台</title>
        <meta name="description" content="">
        <meta name="keywords" content="admin">
        <meta name="renderer" content="webkit">
        <meta http-equiv="Cache-Control" content="no-siteapp" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="icon" type="image/png" href="http://local.antweaver.clcw.com.cn/Application/Admin/Public/Images/favicon.png">
        <link rel="apple-touch-icon-precomposed" href="http://local.antweaver.clcw.com.cn/Application/Admin/Public/images/app-icon72x72@2x.png">
        <meta name="apple-mobile-web-app-title" content="Amaze UI" />
        <link rel="stylesheet" href="http://local.antweaver.clcw.com.cn/Application/Admin/Public/Css/amazeui.css"/>
        <link rel="stylesheet" href="http://local.antweaver.clcw.com.cn/Application/Admin/Public/Css/admin.css">

        <!--[if lt IE 9]>
        <script src="http://libs.baidu.com/jquery/1.11.1/jquery.min.js"></script>
        <script src="http://cdn.staticfile.org/modernizr/2.8.3/modernizr.js"></script>
        <script src="assets/js/amazeui.ie8polyfill.min.js"></script>
        <![endif]-->

        <!--[if (gte IE 9)|!(IE)]><!-->
        <script src="http://local.antweaver.clcw.com.cn/Application/Admin/Public/Js/jquery.min.js"></script>
        <!--<![endif]-->
        <script src="http://local.antweaver.clcw.com.cn/Application/Admin/Public/Js/amazeui.js"></script>
        <script src="http://local.antweaver.clcw.com.cn/Application/Admin/Public/Js/app.js"></script>
        <script type='text/javascript' src="http://local.antweaver.clcw.com.cn/Application/Admin/Public/Js/jquery.form.js"></script>
    </head>
    <body>


<!--[if lte IE 9]>
<p class="browsehappy">你正在使用<strong>过时</strong>的浏览器，Amaze UI 暂不支持。 请 <a href="http://browsehappy.com/" target="_blank">升级浏览器</a>
  以获得更好的体验！</p>
<![endif]-->

<header class="am-topbar am-topbar-inverse admin-header">
  <div class="am-topbar-brand">
    <strong>Ant-weaver</strong> <small>蚁巢业务服务管理平台</small>
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
            <li><a href="<?php echo U('admin/fdebuger/sms');?>"><span class="am-cf"></span> 接口调试(文件传输)</a></li>
          </ul>
        </li>

        <li class="admin-parent">
          <a class="am-cf" data-am-collapse="{target: '#collapse-nav-nav2'}"><span class="am-cf"></span> 优信拍数据集成<span class="am-icon-angle-right am-fr am-margin-right"></span></a>
          <ul class="am-list am-collapse admin-sidebar-sub am-in" id="collapse-nav-nav2">
            <li><a href="<?php echo U('admin/youxinpai/monitor');?>"><span class="am-cf"></span> 服务监控</a></li>
            <li><a href="<?php echo U('admin/youxinpai/taskservicelog');?>"><span class="am-cf"></span> 任务服务日志</a></li>
            <li><a href="<?php echo U('admin/youxinpai/product/search');?>"><span class="am-cf"></span> 车辆搜索</a></li>
          </ul>
        </li>
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

               <script language="JavaScript">
            <!--
            $(function(){
                $('#frm_requester').ajaxForm({
                    beforeSend: clearResult,
                    beforeSubmit:  checkForm,  // pre-submit callback
                    success:       complete,  // post-submit callback
                    dataType: 'json'
                });
                function checkForm(){
                    if( '' == $.trim($('#api_url').val())){
                        $('#error_msg').html('标题不能为空').show();
                        return false;
                    }

                    if( '' == $.trim($('input[name=request_type]').val())){
                        $('#error_msg').html('  请选择请求方式').show();
                        return false;
                    }
                    //可以在此添加其它判断
                }

                function clearResult(){
                    $("#response_result").val('处理中...');
                }

                function complete(data){
                    $("#response_result").val('');
                    var ar = JSON.stringify(data, null, 4);    // 缩进4个空格
                    $("#response_result").val(ar);
                    // if (data.status==1){
                    //     $('#result').html(data.info).show();
                    //     // 更新列表
                    //     data = data.data;
                    //     var html =  '<div class="result" style=\'font-weight:normal;background:#A6FF4D\'><div style="border-bottom:1px dotted silver">标题：'+data.title+'  [ '+data.create_time+' ]</div><div class="content">内容：'+data.content+'</div></div>';
                    //     $('#list').prepend(html);
                    // }else{
                    //     $('#result').html(data.info).show();
                    // }
                }

            });
            function checkTitle(){
                $.post('/Admin/Debuger/checkTitle',{'title':$('#title').val()},function(data){
                    $('#result').html(data.info).show();
                },'json');
            } 
            //-->
    </script>

      <div class="am-cf am-padding am-padding-bottom-0">
        <div class="am-fl am-cf">
            <strong class="am-text-primary am-text-lg">系统模块</strong> / <small>接口调试(文件传输)</small>
        </div>
      </div>
      <hr>
      <div class="am-g">
        <div class="am-u-md-6">
          <div class="am-panel am-panel-default">
            <div class="am-panel-hd am-cf" data-am-collapse="{target: '#collapse-panel-1'}">请求接口<span class="am-icon-chevron-down am-fr" ></span></div>
            <div class="am-panel-bd am-collapse am-in" id="collapse-panel-1">
                <form class="am-form" id="frm_requester" name="frm_requester" method='post' action="/Admin/Debuger/frequest">
                <div class="am-tab-panel " id="tab3">

                    <!-- div class="am-g am-margin-top">
                      <div class="am-u-sm-4 am-u-md-2 am-text-right">选择接口:</div>
                      <div class="am-u-sm-8 am-u-md-10">
                        <select data-am-selected="{btnSize: 'sm'}" id="api_number" name="api_number">
                          <option value="1">短信发送服务</option>
                          <option value="2">短信验证码校验服务</option>
                        </select>
                      </div>
                    </div -->

                    <div class="am-g am-margin-top-sm">
                      <div class="am-u-sm-4 am-u-md-2 am-text-right">
                        接口地址:
                      </div>
                      <div class="am-u-sm-8 am-u-end">
                        <input type="text" class="am-input-sm" id="api_url" name="api_url" value="http://antnest.clcw.com.cn/">
                      </div>
                    </div>

                    <div class="am-g am-margin-top-sm">
                      <div class="am-u-sm-4 am-u-md-2 am-text-right">
                        app_key:
                      </div>
                      <div class="am-u-sm-4 am-u-end">
                        <input type="text" class="am-input-sm" id="app_key" name="app_key" value="AK2016.API.1001" placeholder="HEADER参数">
                      </div>
                    </div>

<!--                     <div class="am-g am-margin-top-sm">
                      <div class="am-u-sm-4 am-u-md-2 am-text-right">
                        client_id:
                      </div>
                      <div class="am-u-sm-4 am-u-end">
                        <input type="text" class="am-input-sm" id="client_id" name="client_id" placeholder="HEADER参数">
                      </div>
                    </div> -->

                    <div class="am-g am-margin-top-sm">
                      <div class="am-u-sm-4 am-u-md-2 am-text-right">
                        secret_key:
                      </div>
                      <div class="am-u-sm-4 am-u-end">
                        <input type="text" class="am-input-sm" id="secret_key" name="secret_key" value="ax1001erttt643ee" placeholder="HEADER参数">
                      </div>
                    </div>

                    <div class="am-g am-margin-top-sm">
                      <div class="am-u-sm-4 am-u-md-2 am-text-right">
                        请求内容类型:
                      </div>
                      <div class="am-u-sm-8 am-u-end">
                        <input type="text" id="content_type" name="content_type" class="am-input-sm" value="application/x-www-form-urlencoded" readonly="readonly">
                      </div>
                    </div>

                    <div class="am-g am-margin-top-sm">
                      <div class="am-u-sm-4 am-u-md-2 am-text-right">
                        文件1:
                      </div>
                      <div class="am-u-sm-4 am-u-end">
                        <!-- <input type="text" class="am-input-sm" id="secret_key" name="secret_key" value="ax1001erttt643ee" placeholder="HEADER参数"> -->
        <!-- 　　　　<button type="button" class="am-btn am-btn-default am-btn-sm"> -->
        <!-- 　　　　<i class="am-icon-cloud-upload"></i> 选择要上传的文件</button> -->
        　　　　<input name="file_01" type="file" multiple>
                      </div>
                    </div>


                    <div class="am-g am-margin-top-sm">
                      <div class="am-u-sm-4 am-u-md-2 am-text-right">
                        文件2:
                      </div>
                      <div class="am-u-sm-4 am-u-end">
                        <!-- <input type="text" class="am-input-sm" id="secret_key" name="secret_key" value="ax1001erttt643ee" placeholder="HEADER参数"> -->
        <!-- 　　　　<button type="button" class="am-btn am-btn-default am-btn-sm"> -->
        <!-- 　　　　<i class="am-icon-cloud-upload"></i> 选择要上传的文件</button> -->
        　　　　<input name="file_02" type="file" multiple>
                      </div>
                    </div>

                    <div class="am-g am-margin-top">
                      <div class="am-u-sm-4 am-u-md-2 am-text-right">请求方式:</div>
                      <div class="am-u-sm-8 am-u-md-10">
                        <div class="am-btn-group" data-am-button>
                          <label class="am-btn am-btn-default am-btn-xs">
                            <input type="radio" name="request_type" value="GET"> GET
                          </label>
                          <label class="am-btn am-btn-default am-btn-xs">
                            <input type="radio" name="request_type" value="POST"> POST
                          </label>
                          <!-- label class="am-btn am-btn-default am-btn-xs">
                            <input type="radio" name="request_type" value="PUT"> PUT
                          </label -->
                        </div>
                      </div>
                    </div>

                    <div class="am-g am-margin-top-sm">
                      <div class="am-u-sm-4 am-u-md-2 am-text-right">
                        接口入参:
                      </div>
                      <div class="am-u-sm-8 am-u-end">
                        <textarea id="request_params" name="request_params" rows="10" placeholder="Json格式"></textarea><span></span>
                      </div>
                    </div>                  
                </div>

                <div class="am-margin">
                  <small class="am-form-error"><label  id="error_msg"></label></small>                  
                </div>

                <div class="am-margin">
                  <input type="hidden" name="ajax" value="1">
                  <input type="submit"  class="am-btn am-btn-primary am-btn-xs" value="提 交">
                  <input type="reset" class="am-btn am-btn-primary am-btn-xs" value="清 空">
                </div>
              </form>
            </div>
          </div>
          <!-- div class="am-panel am-panel-default">
            <div class="am-panel-hd am-cf" data-am-collapse="{target: '#collapse-panel-2'}">HTTP通讯<span class="am-icon-chevron-down am-fr" ></span></div>
            <div id="collapse-panel-2" class="am-in">
              <table class="am-table am-table-bd am-table-bdrs am-table-striped am-table-hover">
                <tbody>
                <tr>
                  <th>Response</th>
                  <th>Date</th>
                  <th>Size</th>
                  <th>Time</th>
                </tr>
                <tr>
                  <td>200</td>
                  <td>2016-07-20 09:30:10</td>
                  <td>1000 B</td>
                  <td>200 ms</td>
                </tr>
                </tbody>
              </table>
            </div>
          </div -->
        </div>

        <div class="am-u-md-6">
          <div class="am-panel am-panel-default">
            <div class="am-panel-hd am-cf" data-am-collapse="{target: '#collapse-panel-3'}">响应结果<span class="am-icon-chevron-down am-fr" ></span></div>
            <div class="am-panel-bd am-collapse am-in am-cf" id="collapse-panel-3">
                <div class="am-tab-panel " id="tab3">
                  <form class="am-form">

                    <div class="am-g am-margin-top-sm">
                      <div class="am-u-sm-4 am-u-md-2 am-text-right">
                        响应结果:
                      </div>
                      <div class="am-u-sm-9 am-u-end">
                        <textarea id="response_result" rows="27"></textarea>
                      </div>
                    </div>
                  </form>
                </div>
            </div>
          </div>
        </div>
      </div>



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