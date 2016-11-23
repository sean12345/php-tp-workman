<?php
/**
 * Redis操作
 */
namespace Common\Org;

class PhpRedis
{
    private $redis = null;

    public function __construct($dbindex=false){
        $redis = new \Redis();
        $res = $redis->connect(C('REDIS_HOST'), C('REDIS_PORT'), 1 );
        $this->redis = $redis;
        if($dbindex){
            $this->select($dbindex);
        }
    }

    public function ping()
    {
       return $this->redis->ping();
    }

    public function select($num){
        return $this->redis->select($num);
    }

    public function set($key,$vale,$expire=false){

        $this->redis->set($key,$vale);

        if($expire){
            $this->redis->expire($key,$expire);    
        }

    }

    public function get($key){
        return $this->redis->get($key);
    }

    public function del($key){
        return $this->redis->delete($key);
    }

    public function getRedis(){
        return $this->redis;
    }

    public function lock($key){        
        return $this->redis->setNx($key,1)?true:false;
    }
    public function lock_wait($key){
        $r = $this->lock($key);
        if(!$r){
            for ($i=0; $i <5 ; $i++) { 
                usleep(rand(500,1000));
                $r = $this->lock($key);
                if($r)
                   break;
               $i++;
            }
        }
        return $r;
    }

    public function unlock($key){
        $this->redis->delete($key);
    }

    public function incr($key){
        $this->redis->incr($key);
    }

    public function lLen($key)
    {
        return $this->redis->lLen($key);
    }

    public function lPush($key,$value)
    {
        return $this->redis->lPush($key,$value);
    }

    public function lPop($key)
    {
        return $this->redis->lPop($key);
    }

    public function rPush($key,$value)
    {
        return $this->redis->rPush($key,$value);
    }

    public function rPop($key)
    {
        return $this->redis->rPop($key);
    }

    public function lRange($key, $start=0, $stop=0)
    {
        return $this->redis->lRange($key, $start, $stop);
    }

}