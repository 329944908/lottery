<?php
namespace app\admin\controller;
use think\Controller;
use think\Db;
class Order extends Controller
{
	public function lists(){
    	$order = model('order');
		$order_lists = $order->select()->toArray();
		foreach ($order_lists as $key => $value) {
			$trophy = $order->trophy()->where('id',$value['trophy_id'])->find()->toArray();
			$user = $order->user()->where('id',$value['user_id'])->find()->toArray();
			$order_lists[$key]['user_name'] =$user['name'];
			$order_lists[$key]['trophy_name'] =$trophy['trophy_name'];
		}
		$this->assign('order_lists',$order_lists);
		return $this->fetch();
    }
    public function send(){
    	$order_id = $_GET['id'];
    	$order = model('order');
    	$res = $order->where(array('id'=>$order_id))->setField('status', 1);
    	if($res){
    		$this->success('发货成功','/admin/Order/lists');
    	}else{
    		$this->error('发货失败，请重试','/admin/Order/lists');
    	}
    }
}