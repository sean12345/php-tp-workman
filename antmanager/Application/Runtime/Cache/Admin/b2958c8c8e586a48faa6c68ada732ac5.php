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
<?php
 if(C('LAYOUT_ON')) { echo ''; } ?>

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
    
  </div>
  <hr />
</div>
<div class="am-g">
  <div class="am-u-lg-6 am-u-md-8 am-u-sm-centered">
    <h3><?php echo ($msg); ?></h3>
    <hr>
        <div class="system-message">
                <?php if(isset($message)) {?>
                <p class="success">
                        <?php echo($message); ?>
                </p>
                <?php }else{?>
                <p class="error">
                        <?php echo($error); ?>
                </p>
                <?php }?>
                <p class="detail"></p>
                <p class="jump">
                        页面自动 <a id="href" href="<?php echo($jumpUrl); ?>">跳转</a> 等待时间： <b id="wait">
                                <?php echo($waitSecond); ?>
                        </b>
                </p>
        </div>
  </div>
</div>
<script type="text/javascript">
    (function(){
        var wait = document.getElementById('wait'),href = document.getElementById('href').href;
        var interval = setInterval(function(){
             var time = --wait.innerHTML;
             if(time <= 0) {
                     location.href = href;
                     clearInterval(interval);
             };
        }, 1000);
    })();
</script>
</body>
</html>