<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html>
<head lang="en">
  <meta charset="UTF-8">
  <title>登录 | AN蚁巢服务平台</title>
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0, minimum-scale=1.0, maximum-scale=1.0, user-scalable=no">
  <meta name="format-detection" content="telephone=no">
  <meta name="renderer" content="webkit">
  <meta http-equiv="Cache-Control" content="no-siteapp" />
  <link rel="icon" type="image/png" href="http://local.antnest.clcw.com.cn/Application/Admin/Public/Images/favicon.png">

        <link rel="stylesheet" href="http://local.antnest.clcw.com.cn/Application/Admin/Public/Css/amazeui.min.css"/>
  <style>
    .header {
      text-align: center;
    }
    .header h1 {
      font-size: 200%;
      color: #333;
      margin-top: 30px;
    }
    .header p {
      font-size: 14px;
    }
  </style>
</head>
<body>
<div class="header">
  <div class="am-g">
    <h1>Ant-Nest 蚁巢服务平台</h1>
    <p><br/></p>
  </div>
  <hr />
</div>
<div class="am-g">
  <div class="am-u-lg-6 am-u-md-8 am-u-sm-centered">
    <h3>登录</h3>
    <hr>
    <div class="am-btn-group ">
      <p class="am-text-warning"><?php echo ($msg); ?> </p>

    </div>

    <form class="am-form" id="frm_requester" name="frm_requester" method='post' action="/Admin/Admin/login">
      <label for="email">用户名:</label>
      <input type="text" name="user_name" id="email" value="">
      <br>
      <label for="password">密码:</label>
      <input type="password" name="pwd" id="password" value="">
      <br>
      <label for="remember-me">
        <input id="remember-me" type="checkbox">
        记住密码
      </label>
      <br />
      <div class="am-cf">
        <input type="submit" name="" value="登 录" class="am-btn am-btn-primary am-btn-sm am-fl">
      </div>
    </form>
    <hr>
    <p>© 2016 clcw, Inc. www.clcw.com.cn</p>
  </div>
</div>
</body>
</html>