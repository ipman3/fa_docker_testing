<?php

namespace app\admin\controller\contents;

use app\common\controller\Backend;
use fast\Tree;
use think\Config;

/**
 * 
 *
 * @icon fa fa-circle-o
 */
class Pages extends Backend
{

    /**
     * Pages模型对象
     * @var \app\admin\model\contents\Pages
     */
    protected $model = null;
    protected $pageList = [];

    public function _initialize()
    {
        parent::_initialize();
        $this->model = new \app\admin\model\contents\Pages;
        $this->tree = Tree::instance();
        $this->tree->init(collection($this->model->where('parent_id = 0')->order('id desc')->select())->toArray(), 'parent_id');
        $this->pageList = $this->tree->getTreeList($this->tree->getTreeArray(0), 'title');
        $this->view->assign("pageList", $this->pageList);
        $this->view->assign("statusList", $this->model->getStatusList());
        // var_dump($this->pageList);
    }




    public function index(){
        
        $this->request->filter(['strip_tags']);
        if ($this->request->isAjax()) {

            

            list($where, $sort, $order, $offset, $limit) = $this->buildparams();
            $total = $this->model
                ->where($where)
                ->count();
        
            $this->tree->init(collection($this->model->where($where)->order($sort, $order)->select())->toArray(), 'parent_id');
            $list = $this->tree->getTreeList($this->tree->getTreeArray(0), 'title');

            $result = array("total" => $total, "rows" => $list);

            return json($result);
        }



        return $this->view->fetch();
    
    }


    public function edit($ids = null)
    {
        $row = $this->model->get($ids);
        if (!$row) {
            $this->error(__('No Results were found'));
        }
        if ($this->request->isPost()) {
            return parent::edit($ids);
        }
        $this->assign('row', $row);
        return $this->view->fetch();
    }


    public function addtext(){
        if ($this->request->isPost()) {
            try {
                $params = $this->request->post("row/a");
                if ($params) {
                    $data = array(
                        "title" => $params['title'],
                        "content" => $params['content'],
                        "parent_id" => $params['parent_id'],
                        "sub_content_type" => 'text',
                        "status" => '1',
                        "createtime" => time(),
                    );
                    $this->model->save($data);
                    $this->success(__('success'));
                }
            } catch (\think\Exception $e) {
                $this->error($e->getMessage());
            }
            $this->error(__('Parameter %s can not be empty', ''));
        }

        return $this->view->fetch();
    }
    
    public function addimage(){
        if ($this->request->isPost()) {
            try {
                $params = $this->request->post("row/a");
                if ($params) {
                    $data = array(
                        "title" => $params['title'],
                        "content" => Config::get('site.imageUrl').$params['content'],
                        "parent_id" => $params['parent_id'],
                        "sub_content_type" => 'image',
                        "status" => '1',
                        "createtime" => time(),
                    );
                    $this->model->save($data);
                    $this->success(__('success'));
                }
            } catch (\think\Exception $e) {
                $this->error($e->getMessage());
            }
            $this->error(__('Parameter %s can not be empty', ''));
        }

        return $this->view->fetch();
    }

    public function addeditor(){
        if ($this->request->isPost()) {
            try {
                $params = $this->request->post("row/a");
                if ($params) {
                    $data = array(
                        "title" => $params['title'],
                        "content" => $params['content'],
                        "parent_id" => $params['parent_id'],
                        "sub_content_type" => 'text',
                        "status" => '1',
                        "createtime" => time(),
                    );
                    $this->model->save($data);
                    $this->success(__('success'));
                }
            } catch (\think\Exception $e) {
                $this->error($e->getMessage());
            }
            $this->error(__('Parameter %s can not be empty', ''));
        }

        return $this->view->fetch();
    }


    /**
     * 默认生成的控制器所继承的父类中有index/add/edit/del/multi五个基础方法、destroy/restore/recyclebin三个回收站方法
     * 因此在当前控制器中可不用编写增删改查的代码,除非需要自己控制这部分逻辑
     * 需要将application/admin/library/traits/Backend.php中对应的方法复制到当前控制器,然后进行修改
     */


}
