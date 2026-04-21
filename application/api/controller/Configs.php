<?php


namespace app\api\controller;
use app\common\controller\Api;
use think\Db;
use think\Config;
use think\Exception;

/**
*Created by KH, Lihong
*/
class Configs extends Api
{
    protected $noNeedLogin = ['*'];
    protected $noNeedRight = ['*'];

    /**
    * Index function
    */
    public function index(){
        try {

            foreach (Config::get('site.phoneNumber') as $key => $value) {
                $p['key'] = $key;
                $p['value'] = $value;
                $phones[]= $p;
            }

            foreach (Config::get('site.social_link') as $key => $value) {
                $p['key'] = $key;
                $p['value'] = $value;
                $socialLink[]= $p;
            }

            $data['sitename'] = Config::get('site.sitename');
            $data['email'] = Config::get('site.email');
            $data['phoneNumber'] = $phones;
            $data['social_link'] = $socialLink;
            $data['address'] = Config::get('site.address');
            $data['logo'] =  Config::get('site.imageUrl').Config::get('site.logo');
            $this->success(__('success'),  $data);
        } catch (Exception $e) {
            $this->error(__('error'), $e->getMessage());
        }
    }
}