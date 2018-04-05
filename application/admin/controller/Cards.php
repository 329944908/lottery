<?php
namespace app\admin\controller;
use think\Controller;
class Cards extends Controller
{
	public function add(){
		return $this->fetch();
	}
	public function doAdd(){
		$num = $_POST['num'];
		$data =array();
		for ($i=0; $i <$num ; $i++) {
			$cards =array(
				'cardNumber' =>generate_number(),
				'cardPassword'=>generate_password(),
			); 
			$data[] = $cards;
		}
		$card=model('Cards');
		foreach ($data as $key => $value) {
			$res = $card->insert($value);
		}
		if($res){
			$this->success('卡密生成成功','/admin/Cards/lists');
		}else{

		}
	}
	public function lists(){
		$card=model('Cards');
		$data = $card->select()->toArray();
		$this->assign('data',$data);
		return $this->fetch();
	}

}