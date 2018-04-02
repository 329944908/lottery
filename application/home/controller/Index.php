<?php
namespace app\home\controller;
use think\Controller;
use think\Db;
class Index extends Controller
{
    public function index()
    {
        return $this->fetch();
    }
    public function chance(){
		 //prize表示奖项内容，v表示中奖几率(若数组中七个奖项的v的总和为100，如果v的值为1，则代表中奖几率为1%，依此类推)
    	$trophy = model('trophy');
		$prize_arr = $trophy->select()->toArray();
		// $prize_arr = array(
		//     '0' => array('id' => 1, 'prize' => '一等奖', 'v' => 5),
		//     '1' => array('id' => 2, 'prize' => '二等奖', 'v' => 5),
		//     '2' => array('id' => 3, 'prize' => '三等奖', 'v' => 5),
		//     '3' => array('id' => 4, 'prize' => '四等奖', 'v' => 5),
		//     '4' => array('id' => 5, 'prize' => '五等奖', 'v' => 5),
		//     '5' => array('id' => 6, 'prize' => '六等奖', 'v' => 5),
		//     '6' => array('id' => 7, 'prize' => '七等奖', 'v' => 5),
		//     '7' => array('id' => 8, 'prize' => '八等奖', 'v' => 5),
		//     '8' => array('id' => 9, 'prize' => '九等奖', 'v' => 5),
		//     '9' => array('id' => 10, 'prize' => '十等奖', 'v' => 5),
		//     '10' => array('id' => 11, 'prize' => '十一等奖', 'v' => 25),
		//     '11' => array('id' => 12, 'prize' => '十二等奖', 'v' => 25),
		// );
		foreach ($prize_arr as $k=>$v) {
		    $arr[$v['id']] = $v['trophy_probability'];

		}

		$prize_id = $this->getRand($arr); //根据概率获取奖项id 
		foreach($prize_arr as $k=>$v){ //获取前端奖项位置
		    if($v['id'] == $prize_id){
		     $prize_site = $k;
		     break;
		    }
		}
		$res = $prize_arr[$prize_id - 1]; //中奖项 

		$data['prize_name'] = $res['trophy_name'];
		$data['prize_site'] = $prize_site;//前端奖项从-1开始
		$data['prize_id'] = $prize_id;
		echo json_encode($data);
    }
    function getRand($proArr) {
	    $data = '';
	    $proSum = array_sum($proArr); //概率数组的总概率精度 

	    foreach ($proArr as $k => $v) { //概率数组循环
	        $randNum = mt_rand(1, $proSum);
	        if ($randNum <= $v) {
	            $data = $k;
	            break;
	        } else {
	            $proSum -= $v;
	        }
	    }
	    unset($proArr);
	    return $data;
	}
	public function a(){
		$trophy = model('trophy');
		// 查询单个数据
		$data = $trophy->select()->toArray();
		var_dump($data);
	}

}
