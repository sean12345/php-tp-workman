<?php
return array(
            'DB_TYPE'    =>  'mysql',     // 数据库类型
            'LOAD_EXT_CONFIG' => array(
                                                                'error_code',
                                                                'db',
                                                                ),

            // 添加新账号时，默认新账号密码
            'DEFAULAT_USER_PWD' => '123456',

            // 来拍车踢下线
            'LAIPAICHE_KICK_USER' => 'http://www.lpaiche.com/Account/kick_user',
            
            // 校验手机验证码
            'VER_CODE_URL'      =>   'http://'.$_SERVER['HTTP_HOST'].'/sms/api/verify',
            'APPKEY'            =>   'AK2016.API.1000',
            'SECRETKEY'         =>   'ax1033erttt655ee',

);