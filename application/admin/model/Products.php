<?php

namespace app\admin\model;

use think\Model;
// use app\admin\model\contents\Type;
// use app\admin\model\contents\Categories;


class Products extends Model
{

    
    // 表名
    protected $name = 'products';
    
    // 自动写入时间戳字段
    protected $autoWriteTimestamp = 'integer';

    // 定义时间戳字段名
    protected $createTime = 'createtime';
    protected $updateTime = 'updatetime';
    protected $deleteTime = false;
   

    // 追加属性
    protected $append = [
        'status_text'
    ];
    

    
    public function getStatusList()
    {
        return ['0' => __('Status 0'), '1' => __('Status 1')];
    }


    public function getStatusTextAttr($value, $data)
    {
        $value = $value ? $value : (isset($data['status']) ? $data['status'] : '');
        $list = $this->getStatusList();
        return isset($list[$value]) ? $list[$value] : '';
    }


    public function categories()
    {
        return $this->belongsTo('\\app\\admin\\model\\contents\\Categories', 'categories_id')->setEagerlyType(0);
    }

    public function type()
    {
        return $this->belongsTo('\\app\\admin\\model\\contents\\Type', 'type_id')->setEagerlyType(0);
    }



}
