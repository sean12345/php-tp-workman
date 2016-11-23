<?php
/**
 * 任务描述表
 *
 * @category Model
 * @version v1.0
 * @license (http://www.clcw.com.cn/licenses/LICENSE-2.0)
 * @copyright (c) 2016-2026 http://www.clcw.com.cn All rights reserved.
 */
namespace Common\Model\AntNest;

class TaskServiceModel extends CommonModel {
    // protected $tablePrefix = 'ant_';
    protected $trueTableName = 'ant_task_service';
    protected $connection = 'DB_ANT_NEST';

    const STATUS_WAIT = 0;
    const STATUS_PENDING = 1;
    const STATUS_PAUSE = 2;
    const STATUS_SUCCESS = 3;
    const STATUS_FAILD = 4;

    /* 自动验证规则 */
    protected $_validate = array(

    );

    /* 用户模型自动完成 */
    protected $_auto = array(
        array('status', self::STATUS_WAIT, self::MODEL_INSERT, 'string'),        
        array('updatetime','dateNow', self::MODEL_UPDATE, 'function'), // 对updatetime字段在更新的时候写入当前时间
    );

    //'数据表字段'=>'表单字段'
    protected $_map = array(
    );

    protected $fields = array(
        'task_id' , //  任务ID
        'group_id', // '任务分组ID',
        'pid', // '进程号',
        'user_id', // '创建人ID',
        'title', // '任务标题',
        'status', // '验车处理结果(0:待处理, 1:处理中, 2:暂停中, 3:处理成功 4:处理失败)',
        'processed', // '已完成任务量(%)',
        'task_url', // '任务启动地址',
        'desc', // '任务描述',
        'remark', // '备注',
        'starttime', // '任务开始时间',
        'endtime', // '任务结束时间',
        'createtime', // '创建时间',
        'updatetime', // '更新时间',
        '_pk'=>'task_id',
        '_type'=>array(
            'group_id'=>'int',
            'pid'=>'int',
        ),
    );

    protected $_scope = array(
        /*待处理任务*/
        'wait_process' => array(
            'where' => array('status' => self::STATUS_WAIT,),
        ),
    );

    public function test() {
        return $this->connection;
    }


}

