<?php
namespace app\home\controller;
use think\Controller;
use think\Session;
class User extends Controller
{
    public function index()
    {
        return 'index';
    }
    public function reg()
    {
        return $this->fetch();
    }
    public function doReg()
    {
        $email = $_POST['email'];
        $password = $_POST['password'];
        $user = model('user');
        $data =([
            'email'=>$email,
            'password'=>$password,
            ]);
        $res = $user->insert($data);
        if($res){
            $this->success('','/home/User/login'); 
        }else{
            $this->error('注册失败','/home/User/reg'); 
        }
    }
    public function login()
    {
        return $this->fetch();
    }
    public function doLogin()
    {
        $email = $_GET['email'];
        $password = $_GET['password'];
        $user = model('user');
        $data = $user->where(array('email'=>$email))->find();
        if($data){
            $data = $data->toArray();
            if($data['password']==$password){
                unset($data['password']);
                $_SESSION['me'] = $data;
                $this->success('','/home/Index/index'); 
            }else{
                $this->error('密码错误','/home/User/login'); 
            }
        }else{
            $this->error('该用户不存在','/home/User/reg'); 
        }
    }
    public function logout()
    {
        $res = Session::clear('me');
        $this->success('注销成功','/home/Index/index');   
    }
    public function recharge(){
        $id = $_GET['id'];
        $user = model('user');
        $user_id = $user->where(array('id'=>$id))->value('id');
        $this->assign('user_id',$user_id);
        return $this->fetch();
    }
    public function doRecharge(){
        $user_id = $_GET['user_id'];
        $cardNumber = $_GET['cardNumber'];
        $cardPassword = $_GET['cardPassword'];
        $card = model('cards');
        $data = $card->where(array('cardNumber'=>$cardNumber))->find()->toArray();
        if($data){
            if($data['status']==1){
                if($data['cardPassword']==$cardPassword){
                    $user = model('user');
                    $res = $user->where(array('id'=>$user_id))->setInc('times');
                    if($res){
                        $card->where(array('cardNumber'=>$cardNumber))->setField('status', 0); 
                        $this->success('充值成功','/home/Index/index');   
                    }else{
                        $this->error('充值失败','/home/Index/index');  
                    }
                }else{
                    $this->error('密码错误','/home/Index/index'); 
                }  
            }else{
                $this->error('该充值卡已失效','/home/Index/index'); 
            }
        }else{
            $this->error('请输入有效的充值卡','/home/Index/index'); 
        }
    }
}