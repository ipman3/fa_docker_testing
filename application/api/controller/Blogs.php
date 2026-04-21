<?php


namespace app\api\controller;
use app\common\controller\Api;
use think\Db;
use think\Config;
use think\Exception;

/**
*Created by KH, Lihong
*/
class Blogs extends Api
{
    protected $noNeedLogin = ['*'];
    protected $noNeedRight = ['*'];

    /**
    * Index function
    */
    public function index(){
        try {
            $data = Db::name("blogs")->where("status", 1)->select();
            $this->success(__('success'),  $data);
        } catch (Exception $e) {
            $this->error(__('error'), $e->getMessage());
        }
    }

    public function detail(){
        try {
            $id = $this->request->post('id','', 'trim,strip_tags,htmlspecialchars');
            $data = Db::name('blogs')->where('id', $id)->find();
            $this->success(__('success'),  $data);
        } catch (Exception $e) {
            $this->error(__('error'), $e->getMessage());
        }
    }
}