    <?php
    /**
     * 密码明文加密
     * 
     * @param  string $password 
     * 
     * @return string
     */
    function generatePassword($password='') {
        $str = '';
        if ($password) {
            // $strMiddle = hash('md5', $password);
            // $salt = C('PASSWORD_SALT');
            // $str = hash('sha256', $strMiddle . $salt);
            $str = hash('md5', $password);
        }
        return $str;
    }

    /**
     * 随机生成账号名称
     *
     * @param int $len
     *  
     * @return mix
     */
    function generateAccountName( $length = 8 ) {
        $chars = 'abcdefghijklmnopqrstuvwxyz0123456789_';
        $res = 'clcw_';
        for ( $i = 0; $i < $length; $i++ )
        {
            // 这里提供两种字符获取方式
            // 第一种是使用substr 截取$chars中的任意一位字符；
            // 第二种是取字符数组$chars 的任意元素
            // $res .= substr($chars, mt_rand(0, strlen($chars) - 1), 1);
            $res .= $chars[ mt_rand(0, strlen($chars) - 1) ];
        }
        return $res;
    }

    /**
     * 随机生成账号邮箱
     *
     * @param int $len
     *  
     * @return mix
     */
    function generateEmail( $length = 10 ) {
        $res = '';
        $chars = 'abcdefghijklmnopqrstuvwxyz012345678_';
        $strEmail = '';
        for ( $i = 0; $i < $length; $i++ )
        {
            // 这里提供两种字符获取方式
            // 第一种是使用substr 截取$chars中的任意一位字符
            // 第二种是取字符数组$chars 的任意元素
            // $password .= substr($chars, mt_rand(0, strlen($chars) - 1), 1);
            $strEmail .= $chars[ mt_rand(0, strlen($chars) - 1) ];
        }
        $res = $strEmail . '@clcw.com';
        return $res;
    }

    /**
     * 随机生成账号手机号
     *
     * @param int $len
     *  
     * @return mix
     */
    function generateMobile() {
        $chars = '0123456789';
        $strMobile = '5';
        for ( $i = 0; $i < 11; $i++ )
        {
            $strMobile .= $chars[ mt_rand(0, strlen($chars) - 1) ];
        }
        return $strMobile;
    }


    