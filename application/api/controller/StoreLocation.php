<?php

    namespace app\api\controller;
    use app\common\controller\Api;
    use think\Db;
    use think\Config;
    use think\Exception;

    class Pages extends Api
    {
        protected $noNeedLogin = ['*'];
        protected $noNeedRight = ['*'];

        public function index(){
            
        }
    }
?>