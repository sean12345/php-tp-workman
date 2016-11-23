Ant-Nest 蚁巢项目部署
==============
#cd Sh/

1. 停止短信发送服务 (推荐在控制台操作)
        #sh sms_task_stop.sh

2. 屏蔽服务报警定时任务
        #crontab -e
        >*/5  * * * *   root    php  ./ant_nest/cli.php Monitor/ServerMon/run

3. git 仓库获取最新代码

4. 执行config_set.sh文件，调整配置项和清理Runtime目录
        #sh config_set.sh

5. 启动短信发送服务 (推荐在控制台操作)
        #sh sms_task_start.sh

6. 开启服务报警定时任务
        #crontab -e
        >*/5  * * * *   root    php  ./ant_nest/cli.php Monitor/ServerMon/run

        如果未添加任务，执行monitor_cron_add.sh
        #sh monitor_cron_add.sh

7. 部署完毕

