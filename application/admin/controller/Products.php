<?php

namespace app\admin\controller;

use app\common\controller\Backend;

/**
 * 
 *
 * @icon fa fa-circle-o
 */
class Products extends Backend
{

    /**
     * Products模型对象
     * @var \app\admin\model\Products
     */
    protected $model = null;
    protected $relationSearch = true;

    public function _initialize()
    {
        parent::_initialize();
        $this->model = new \app\admin\model\Products;
        $this->view->assign("statusList", $this->model->getStatusList());
    }


    public function index(){
        if ($this->request->isAjax())
        {
            list($where, $sort, $order, $offset, $limit) = $this->buildparams();

            $count = $this->model
                    ->with(["categories","type"])
                    ->where($where)
                    ->order($sort, $order)
                    ->limit($offset, $limit)
                    ->count();

            $list = $this->model
                    ->with(["categories","type"])
                    ->where($where)
                    ->order($sort, $order)
                    ->limit($offset, $limit)
                    ->select();
            $result = array("total" => $count, "rows" => $list);

            return json($result);
        }
        return $this->view->fetch();
    }



    /**
     * 默认生成的控制器所继承的父类中有index/add/edit/del/multi五个基础方法、destroy/restore/recyclebin三个回收站方法
     * 因此在当前控制器中可不用编写增删改查的代码,除非需要自己控制这部分逻辑
     * 需要将application/admin/library/traits/Backend.php中对应的方法复制到当前控制器,然后进行修改
     */


}
