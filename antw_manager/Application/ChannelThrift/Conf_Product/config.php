<?php
return array(
            'APPKEY'                            =>      'AK2016.API.1000',
            'SECRETKEY'                       =>      'ax1033erttt655ee',
            'WARN_MOBILES'               =>      array(
                                                                         '15029911786', // 刘旭良
                                                                         '13552528384', // 宋爱民
                                                                       ),
            'MONITOR_SERVERS'          =>      array(
                                                                          array(
                                                                                          'ip' => '127.0.0.1',
                                                                                          'port' => '10021',
                                                                                          'title' => 'AN短信通知任务服务',
                                                                                          'desc' => '蚁巢短信通知任务服务运行异常！',
                                                                                  ),
                                                                          array(
                                                                                          'ip' => '127.0.0.1',
                                                                                          'port' => '10022',
                                                                                          'title' => 'AN短信验证码发送任务服务',
                                                                                          'desc' => '蚁巢短信验证码发送任务服务运行异常！',
                                                                                  ),
                                                                       ),
            'SERVER_WARN_EXPIRE'      =>      60*60*5, // 服务报警短信，5个小时内不重复发送

);