<?php
namespace app\admin\controller;
use think\Controller;
class Trophy extends Controller
{
    public function lists(){
    	$trophy = model('trophy');
		$trophy_lists = $trophy->select()->toArray();
 		$this->assign('trophy_lists',$trophy_lists);
 		return $this->fetch();
    }
    public function edit(){
    	$id = $_GET['id'];
    	$trophy = model('trophy');
		$trophy_info= $trophy->where(array('id'=>$id))->find()->toArray();
    	$this->assign('trophy_info',$trophy_info);
    	return $this->fetch();
    }
    public function doEdit(){
    	$id = $_POST['trophy_id'];
    	$image = upload('trophy_img');
    	if($image){
    		$data = array(
	    		'trophy_name' => $_POST['trophy_name'],
	    		'trophy_price' => $_POST['trophy_price'],
	    		'trophy_probability' => $_POST['trophy_probability'],
	    		'trophy_stock' => $_POST['trophy_stock'],
	    		'trophy_img' =>$image,
	    		);
	    	$trophy = model('trophy');
			$res= $trophy->where(array('id'=>$id))->update($data);
	    	if($res){
	    		$this->success('更新成功','/admin/Trophy/lists');
	    	}else{
	    		$this->error('更新失败','/admin/Trophy/lists');
	    	}
    	}	
    }
}