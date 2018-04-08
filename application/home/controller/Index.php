<?php
namespace app\home\controller;
use think\Controller;
use think\Db;
class Index extends Controller
{
    public function index()
    {
    	if(isset($_SESSION['me'])){
    		$user = model('user');
    		//获取当前登录用户的抽奖次数
    		$times = $user->where('id',$_SESSION['me']['id'])->value('times');
    		$user_data = $_SESSION['me'];
    		$this->assign('user_data',$user_data); 
    		$this->assign('times',$times);
    	}
    	$trophy = model('trophy');
		$trophy_arr = $trophy->select()->toArray();
		foreach ($trophy_arr as $key => $value) {
			$images[$key] = 'http://lottery.com/uploads/'.$value['trophy_img']; 
		}
		$this->assign('images',$images);
        return $this->fetch();
    }
    public function chance(){
    	//判断用户是否登录
    	if(isset($_SESSION['me'])){
    		$data['is_login'] = 1;
    		$user = model('user');
    		//获取当前登录用户的抽奖次数
    		$times = $user->where('id',$_SESSION['me']['id'])->value('times');
    		if($times>=1){
	    		$trophy = model('trophy');
				$prize_arr = $trophy->select()->toArray();
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
				$data['prize_site'] = $prize_site+1;//前端奖项从-1开始
				$data['prize_id'] = $prize_id;
				$new_time = $times-1;
				if($new_time<0){
					$new_time = 0;
				}
				if($res['trophy_price']!=0){
					$new_trophy_stock = $res['trophy_stock']-1;
					$status1 = $trophy->where('id',$res['id'])->setField('trophy_stock', "{$new_trophy_stock}");
					if($status1){
						$order = model('order');
						$order_data['user_id'] = $_SESSION['me']['id'];
						$order_data['trophy_id'] = $res['id'];
						$order_data['order_num'] = mt_rand(1000,9999).$order_data['user_id'].$order_data['trophy_id'].time();
						$status3 = $order->insert($order_data);
						if(!$status3){
							$new_time = $new_time+1;
						}
					}
				} 
				$status2 = $user->where('id',$_SESSION['me']['id'])->setField('times', "{$new_time}");	
    		}else{
    			$data['times'] = 0;
    		}
    	}else{
    		$data['is_login'] = 0;
    	}
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
