<?php
namespace app\home\controller;
use think\Controller;
class Order extends Controller
{
	public function lists(){
		$order =model('order');
		$user_id = $_GET['id'];
		$data = $order->where(array('user_id'=>$user_id))->select()->toArray();
		if($data){
			foreach ($data as $key => $value) {
				$trophy = $order->trophy()->where('id',$value['trophy_id'])->find()->toArray();
				$data[$key]['trophy_name'] =$trophy['trophy_name'];
			}
		}
		$this->assign('data',$data);	
		return $this->fetch();	
	}
}