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

           <!-- content start -->
  <div class="admin-content">

    <div class="am-cf am-padding">
      <div class="am-fl am-cf"><strong class="am-text-primary am-text-lg">优信拍数据采集</strong> / <small>车辆搜索</small></div>
    </div>



    <div class="am-g">
      <div class="am-u-sm-16 am-u-md-8">
        <div class="am-form-group">
          <select id='select_car_city' data-am-selected="{btnSize: 'sm'}">
            <option value="">&nbsp;&nbsp;&nbsp;-----所在地-----&nbsp;&nbsp;&nbsp;</option>
            <?php if(is_array($city_option_list)): foreach($city_option_list as $key=>$option): ?><option value="<?php echo ($option["city_id"]); ?>"><?php echo ($option["city_name"]); ?> (<?php echo ($option["city_car_count"]); ?>辆)</option><?php endforeach; endif; ?>
          </select>

          <select id='select_resp_code' data-am-selected="{btnSize: 'sm'}">
            <option value="">&nbsp;&nbsp;&nbsp;-----交易状态-----&nbsp;&nbsp;&nbsp;</option>
            <option value="-1">正在报价</option>
            <option value="-15">已成交</option>
            <option value="-3">车辆流拍</option>
          </select>

          <select id='select_master_brand' data-am-selected="{btnSize: 'sm'}">
            <option value="">&nbsp;&nbsp;&nbsp;-----品牌-----&nbsp;&nbsp;&nbsp;</option>
            <?php if(is_array($master_brand_option_list)): foreach($master_brand_option_list as $key=>$option): ?><option value="<?php echo ($option["master_brand_id"]); ?>"><?php echo ($option["master_brand_letter"]); ?>&nbsp;<?php echo ($option["master_brand_name"]); ?></option><?php endforeach; endif; ?>
          </select>

          <select id='select_brand' data-am-selected="{btnSize: 'sm'}">
            <option value="">&nbsp;&nbsp;&nbsp;-----车系-----&nbsp;&nbsp;&nbsp;</option>
          </select>
        </div>
      </div>

      <div class="am-u-sm-12 am-u-md-3">
        <div class="am-input-group am-input-group-sm">
          <input type="text" class="am-form-field" id="keyword_search_tag">
          <span class="am-input-group-btn">
            <button class="am-btn am-btn-default" id="btn_search" type="button">搜索</button>
          </span>
        </div>
      </div>
    </div>

    <div class="am-g">
      <div class="am-u-sm-12">
        <form class="am-form">
          <table class="am-table am-table-striped am-table-hover table-main">
            <thead>
              <tr>
                <th class="table-id">PublishID</th>
                <th class="table-id">CarSourceID</th>
                <th class="table-title">标题</th>
                <th class="table-type">车辆所在地</th>
                <th class="table-type">品牌</th>
                <th class="table-type">车系</th>
                <th class="table-type">车牌号</th>
                <th class="table-type">上牌时间</th>
                <th class="table-type">公里数</th>
                <th class="table-type">代办费</th>
                <th class="table-type">交易费</th>
                <th class="table-type">成交总价</th>
                <th class="table-type">交易状态</th>
                <th class="table-date am-hide-sm-only">更新时间</th>
                <th class="table-date am-hide-sm-only">采集时间</th>
              </tr>
          </thead>
          <tbody id="product_list_box">
            <?php if(is_array($car_list)): foreach($car_list as $key=>$item): ?><tr>
                <td><a href="http://i.youxinpai.com/auctionhall/detailforeveryone.aspx?id=<?php echo ($item["publish_id"]); ?>" target="view_window"><?php echo ($item["publish_id"]); ?></a></td>
                <td><?php echo ($item["carsource_id"]); ?></td>
                <td><?php echo ($item["car_name"]); ?> (<?php echo ($item["car_original_color"]); ?>)</td>
                <td><?php echo ($item["car_city"]); ?></td>
                <td><?php echo ($item["master_brand_name"]); ?></td>
                <td><?php echo ($item["brand_name"]); ?></td>
                <td><?php echo ($item["license_number"]); ?></td>
                <td><?php echo ($item["license_date"]); ?></td>
                <td><?php echo (round($item['mileage']/10000,2)); ?> (万公里)</td>
                <td><?php echo ($item["buyer_agent_fee"]); ?></td>
                <td><?php echo ($item["buyer_trade_fee"]); ?></td>
                <td>
                  <?php switch($item["resp_code"]): case "-15": ?><span style="color:green;"><?php echo ($item["total_price"]); ?></span><?php break;?>
                      <?php case "-3": ?><span style="color:red;"><?php echo ($item["total_price"]); ?></span><?php break;?>
                      <?php default: endswitch;?>
                  
                </td>
                <td>
                    <?php switch($item["resp_code"]): case "-15": ?>已成交<?php break;?>
                        <?php case "-12": ?>等待竞价<?php break;?>
                        <?php case "-7": ?>竞价结束待处理<?php break;?>
                        <?php case "-3": ?>车辆流拍<?php break;?>
                        <?php case "-1": ?>正在报价<?php break;?>
                        <?php default: endswitch;?>
                </td>
                <td><?php echo ($item["tradetime"]); ?></td>
                <td><?php echo ($item["crawlertime"]); ?></td>
              </tr><?php endforeach; endif; ?>
          </tbody>
        </table>
          <div class="am-cf">
            共 <span id="product_count_tag"><?php echo ($row_count); ?></span> 条记录
            <div class="am-fr">

              <ul data-am-widget="pagination" class="am-pagination am-pagination-default">

                  当前第 <span id="page_num_tag"> <?php echo ($page_num); ?> </span> 页

                  <li class="am-pagination-first">
                    <a href="#" class="">首 页</a>
                  </li>

                  <li class="am-pagination-prev">
                    <a href="#" class="">上一页</a>
                  </li>

                    <li class="am-pagination-next">
                      <a href="#" class="">下一页</a>
                    </li>

                    <li class="am-pagination-last">
                      <a href="#" class="">末 页</a>
                    </li>
              </ul>
            </div>
        </div>
        </form>
      </div>

    </div>
  </div>
  <!-- content end -->
</div>
  <script type="text/javascript">

    /**
     * 搜索数据列表
     * 
     * @param  json $searchOption 数据搜索条件
     * @return mix
     */
    function getList(searchOption) {
        var fieldCount = 0;
        $("#product_list_box").html('');
        $("#product_count_tag").html('');
        $("#page_num_tag").html('');

        $.ajax({
          url: '/Admin/Youxinpai/ajaxProductSearch',
          type: 'get',
          dataType: 'json',
          async : false,
          data: searchOption,
          success: function(data) {
                if (data.code == '000000') {
                    var strProductList = "";
                    $.each(data.data.car_list, function(i, item){
                          fieldCount++;
                          strProductList += "<tr>";
                          strProductList += "<td><a href='http://i.youxinpai.com/auctionhall/detailforeveryone.aspx?id="+item.publish_id+"' target='view_window'>"+item.publish_id+"</a></td>";
                          strProductList += "<td>"+item.carsource_id+"</td>";
                          strProductList += "<td>"+item.car_name+"("+item.car_original_color+")"+"</td>";
                          strProductList += "<td>"+item.car_city+"</td>";
                          strProductList += "<td>"+item.master_brand_name+"</td>";
                          strProductList += "<td>"+item.brand_name+"</td>";
                          strProductList += "<td>"+item.license_number+"</td>";
                          strProductList += "<td>"+item.license_date+"</td>";
                          strProductList += "<td>"+(item.mileage/10000).toFixed(2)+" (万公里)</td>";
                          strProductList += "<td>"+item.buyer_agent_fee+"</td>";
                          strProductList += "<td>"+item.buyer_trade_fee+"</td>";
                          switch(item.resp_code){
                                  case '-15': strProductList += "<td><span style='color:green;'>"+item.total_price+"</span></td>";break;
                                  case '-3': strProductList += "<td><span style='color:red;'>"+item.total_price+"</span></td>";break;
                                  default:strProductList += "<td></td>";break;
                          }

                          switch(item.resp_code){
                                  case '-15': strProductList += "<td>已成交</td>";break;
                                  case '-12': strProductList += "<td>等待竞价</td>";break;
                                  case '-7': strProductList += "<td>竞价结束待处理</td>";break;
                                  case '-3': strProductList += "<td>车辆流拍</td>";break;
                                  case '-1': strProductList += "<td>正在报价</td>";break;
                                  default: strProductList += "<td></td>";break;
                          }

                          strProductList += "<td><?php echo ($item["tradetime"]); ?></td>";
                          strProductList += "<td><?php echo ($item["crawlertime"]); ?></td>";
                          strProductList += "</tr>";
                    });

                    $("#product_list_box").html(strProductList);
                    $("#product_count_tag").html(data.data.row_count);
                    $("#page_num_tag").html(data.data.page_num);

                } else {
                    $("#am-alert-tag p").html('code: ' + data.code + ', msg: ' + data.msg);
                    $("#am-alert-tag").show();
                }
          },
          error: function(e) {
                    $("#am-alert-tag p").html('当前ajax请求失败');
                    $("#am-alert-tag").show();
                    $btn.button('reset');
          }
        });
        return fieldCount;
    }

    /**
     * 搜索主品牌下对应车系选项列表
     * 
     * @param  int masterBrandID
     * 
     * @return mix
     */
    function getBrandList(masterBrandID) {

        var strOptionList = '<option value="">&nbsp;&nbsp;&nbsp;-----车系-----&nbsp;&nbsp;&nbsp;</option>';
        $("#select_brand").html(strOptionList);
        var searchOption = 'master_brand_id=' + masterBrandID;
        $.ajax({
          url: '/Admin/Youxinpai/ajaxGetBrandOptionList',
          type: 'get',
          dataType: 'json',
          async : true,
          data: searchOption,
          success: function(data) {
                if (data.code == '000000') {
                    $.each(data.data, function(i, item){
                          strOptionList += '<option value="' + item.brand_id + '">' + item.brand_name + '</option>';
                    });
                    $("#select_brand").html(strOptionList);

                } else {
                    $("#am-alert-tag p").html('code: ' + data.code + ', msg: ' + data.msg);
                    $("#am-alert-tag").show();
                }
          },
          error: function(e) {
                    $("#am-alert-tag p").html('当前ajax请求失败');
                    $("#am-alert-tag").show();
                    $btn.button('reset');
          }
        });
    }

    function getSearchOption() {
        var searchOption = '';
        searchOption += "resp_code=" + $('#select_resp_code').val();
        searchOption += "&car_city_id=" + $('#select_car_city').val();
        searchOption += "&master_brand_id=" + $('#select_master_brand').val();
        searchOption += "&brand_id=" + $('#select_brand').val();
        searchOption += "&keyword=" + $('#keyword_search_tag').val();
        return searchOption;
    }


    $(function() {

          $('#btn_search').on('click', function(){
                var searchOption = getSearchOption();
                searchOption += "&page_num=1";
                getList(searchOption);
          });

          $('#select_resp_code').on('change', function(){
                var searchOption = getSearchOption();
                searchOption += "&page_num=1";
                getList(searchOption);
          });

          $('#select_car_city').on('change', function(){
                var searchOption = getSearchOption();
                searchOption += "&page_num=1";
                getList(searchOption);
          });

          $('#select_master_brand').on('change', function(){
                var masterBrandID = $('#select_master_brand').val();
                if (masterBrandID > 0) {
                    getBrandList(masterBrandID);
                }
                var searchOption = getSearchOption();
                searchOption += "&page_num=1";
                getList(searchOption);
          });

          $('#select_brand').on('change', function(){
                var searchOption = getSearchOption();
                searchOption += "&page_num=1";
                getList(searchOption);
          });

          $('.am-pagination-first').on('click', function(){
                var searchOption = getSearchOption();
                var pageNum = 1;
                searchOption += "&page_num=" + pageNum;
                getList(searchOption);
                $('.am-pagination-next').show();
          });

          $('.am-pagination-prev').on('click', function(){
                var searchOption = getSearchOption();
                var pageNum = $("#page_num_tag").text();
                if (pageNum <= 1) {
                    pageNum = 1;
                } else {
                    pageNum--;
                }
                searchOption += "&page_num=" + pageNum;
                var dataCount = getList(searchOption);

                if (dataCount > 0) {
                    // $('.am-pagination-next').hide();
                    $('.am-pagination-next').show();
                }
          });

          $('.am-pagination-next').on('click', function(){
                var searchOption = getSearchOption();
                var pageNum = $("#page_num_tag").text();
                pageNum++;
                searchOption += "&page_num=" + pageNum;
                var dataCount = getList(searchOption);

                if (dataCount == 0) {
                    $('.am-pagination-next').hide();
                }
          });

          $('.am-pagination-last').on('click', function(){
                var searchOption = getSearchOption();
                searchOption += "&page_num=-1";
                getList(searchOption);
                $('.am-pagination-next').hide();
          });

    });
    
    function refresh(){
        window.location.reload();//刷新当前页面.
        // 或者下方刷新方法
        // parent.location.reload()刷新父亲对象（用于框架）--需在iframe框架内使用
        // opener.location.reload()刷新父窗口对象（用于单开窗口
        // top.location.reload()刷新最顶端对象（用于多开窗口）
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