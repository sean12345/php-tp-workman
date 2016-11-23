<?php
/**
 * 车主信息采集原表
 *
 * @category Model
 * @version v1.0
 * @license (http://www.clcw.com.cn/licenses/LICENSE-2.0)
 * @copyright (c) 2016-2026 http://www.clcw.com.cn All rights reserved.
 */
namespace Common\Model\Aums;

use Base\Model\BaseModel;

class CommonModel extends BaseModel {
    protected $connection = 'DB_AUMS';
    protected $tablePrefix = 'au_';

    public function test() {
        return $this->connection;
    }


}

