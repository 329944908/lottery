<?php
namespace app\admin\model;
use think\Model;
class Order extends Model
{
	protected $resultSetType = 'collection';
	 //自定义初始化
    protected function initialize()
    {
        //需要调用`Model`的`initialize`方法
        parent::initialize();
        //TODO:自定义的初始化
    }
       public function user()
    {
        return $this->belongsTo('User','id')->field('name');
    }
      public function trophy()
    {
        return $this->belongsTo('Trophy','id')->field('trophy_name');
    }
}