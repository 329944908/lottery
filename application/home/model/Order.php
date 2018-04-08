<?php
namespace app\home\model;
use think\Model;

class Order extends Model
{
	 protected $resultSetType = 'collection';
	 public function trophy()
    {
        return $this->belongsTo('Trophy','id')->field('trophy_name');
    }
}