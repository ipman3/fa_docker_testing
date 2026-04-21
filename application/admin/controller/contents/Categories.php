<?php

namespace app\admin\controller\contents;

use app\common\controller\Backend;

/**
 * 
 *
 * @icon fa fa-circle-o
 */
class Categories extends Backend
{

    /**
     * Categories模型对象
     * @var \app\admin\model\contents\Categories
     */
    protected $model = null;
    protected $relationSearch = true;
    protected $selectpageFields = 'id,title';
    protected $searchFields = 'id,title';
    

    public function _initialize()
    {
        parent::_initialize();
        $this->model = new \app\admin\model\contents\Categories;
        $this->view->assign("statusList", $this->model->getStatusList());
    }


    public function index(){
        $this->request->filter(['strip_tags', 'trim']);
        if ($this->request->isAjax())
        {

            if ($this->request->request('keyField')) {
                return $this->selectpage();
            }
            list($where, $sort, $order, $offset, $limit) = $this->buildparams();
            $list = $this->model
                ->with(["type"])
                ->where($where)
                ->order($sort, $order)
                ->paginate($limit);

            $result = array("total" => $list->total(), "rows" => $list->items());


            return json($result);
        }
        return $this->view->fetch();
    }


    public function data_source(){
        $this->request->filter(['strip_tags', 'trim']);
        if ($this->request->isAjax())
        {
            if ($this->request->request('keyField')) {
                return $this->selectpage();
            }
            $list = $this->model
                    ->with(["type"])
                    ->where($where)
                    ->order($sort, $order)
                    ->paginate($limit);
            $result = array("total" => $list->total(), "rows" => $list->items());

            return json($result);
        }
        
    }


    /**
     * 默认生成的控制器所继承的父类中有index/add/edit/del/multi五个基础方法、destroy/restore/recyclebin三个回收站方法
     * 因此在当前控制器中可不用编写增删改查的代码,除非需要自己控制这部分逻辑
     * 需要将application/admin/library/traits/Backend.php中对应的方法复制到当前控制器,然后进行修改
     */


}
