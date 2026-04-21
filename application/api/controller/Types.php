<?php

namespace app\api\controller;
use app\common\controller\Api;
use think\Db;
use think\Config;
use think\Exception;

/**
*Created by KH, Tangkoan
*/
class Types extends Api
{
    protected $noNeedLogin = ['*'];
    protected $noNeedRight = ['*'];

    /**
    * Index function
    */
    public function SelectType(){
        try{
            $type_id = $this->request->post('type_id');
            $parent_data = Db::name("products")->where('status', 1)->where('type_id', $type_id)->Select();

            // data = {
            //     products = [],
            //     types = [],
            //     categories = [],
            // }
            $this->success(__("Success"), $parent_data);
        }catch (Exception $e) {
            $this->error(__('error'), $e->getMessage());
        }
    }
    
}