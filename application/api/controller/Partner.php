<?php 


namespace app\api\controller;
use app\common\controller\Api;
use think\Db;
use think\Config;
use think\Exception;

/**
*Created by KH, Lihong
*/
class Partner extends Api
{
    protected $noNeedLogin = ['*'];
    protected $noNeedRight = ['*'];

    /**
    * Index function
    */
    public function index(){
        try {
            $data = Db::name("partner")->where("status", 1)->select();
            $this->success(__('success'),  $data);
        } catch (Exception $e) {
            $this->error(__('error'), $e->getMessage());
        }
    }
}