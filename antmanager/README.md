****************************************************************************
## git 使用方法
```
git config --list
git config --global user.name '用户名' 
git config --global user.email 'email地址'

git clone ssh://git@192.168.1.103:10122/ants-army/ant-nest.git antnest.clcw.com.cn

```

****************************************************************************
## ant-nest 服务部署
```
＠webserver: Nginx
@php: php5-fpm
@wiki: http://local.doc.antnest.clcw.com.cn/wiki/doku.php
@api: http://local.antnest.clcw.com.cn/v1/[module]/api
@test: http://local.antnest.clcw.com.cn/[module]/test
@doc: http://local.antnest.clcw.com.cn/[module]/doc
@pub: http://local.antnest.clcw.com.cn/[module]/pub
```
****************************************************************************
## api配置方法
```


server
{
listen 80;
server_name local.antnest.clcw.com.cn;
index index.php index.html index.htm;
access_log /var/log/nginx/local.antnest.clcw.log;
root /home/vagrant/www/ant_nest;


location /
{

    if (-f $request_filename) {
           expires max;
           break;
    }


    if (!-e $request_filename){
        rewrite ^/index.php(.*)$ /index.php?s=$1 last;
        rewrite ^(.*)$ /index.php?s=$1 last;
        break;
    }
}

location ~ .*\.(php|php5)?$
{
    # fastcgi_pass 127.0.0.1:9000;
    fastcgi_pass unix:/var/run/php5-fpm.sock;
    fastcgi_index index.php;
    include fastcgi_params;
}

        location ~ .*\.(gif|jpg|jpeg|png|bmp|swf)$
        {
         if (-f $request_filename) {
          expires -1s;
          break;
          }
        }

location ~ /\.ht{
    deny all;
}

}
```

****************************************************************************
## 项目配置文件调整
****************************************************************************
```
1. 修改Application\Common\Conf\config.php
    1.1 修改APP_SUB_DOMAIN_RULES 域名部署映射配置，
    1.2 修改数据库连接配置
```

****************************************************************************
## 项目运行方式
****************************************************************************
```
1. 控制台任务服务启动方式
    （demo: #php cli.php [Module]/[Controller]/[Action]
  
```

****************************************************************************
## php服务配置
****************************************************************************
```
#sudo apt-get install php5-fpm php5-cgi php5-mysql php5-curl php5-gd php5-idn php-pear php5-imagick php5-imap php5-mcrypt php5-memcache php5-mhash php5-ming php5-ps php5-pspell php5-recode php5-snmp php5 sqlite php5-tidy php5-xmlrpc php5-xsl php5-json php5-suhosin php5-common php-apc php5-dev libpcre3-dev
```


