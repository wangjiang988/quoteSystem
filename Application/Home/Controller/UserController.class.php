<?php
namespace Home\Controller;


use Home\Model\AdminModel;

class UserController extends BaseController
{
    public $model;

    public function __construct()
    {
        parent::__construct();
        if(!isset($this->model) && !is_object($this->model)) $this->model = new AdminModel();
    }

    /**
     * 用户列表首页
     */
    public function index()
    {
        $this->display();
    }

    /**
     * 创建用户
     */
    public function create()
    {
        $data = I('post.');
        if($this->model->create($data)){
            // 增加或者更改其中的属性
            $this->model->add();
        }
         else{
             exit( $this->model->getError());
        }
    }
    /**
     * 禁用用户
     */
    public function forbiden()
    {

    }
    /**
     * 删除用户
     */
    public function delete(){

    }

    /**
     * 登陆首页
     */
    public function login()
    {

        if(IS_POST){
            $data = I('post.');
            $admin = new AdminModel();
            $user = $admin->where('status=1 and name=\''.$data['username'].'\'')->find();
            if($user){
                //用户存在,检查密码
                $pwd = $data['password'];
                if(md5(md5($pwd)) == $user['password']){
                    //登陆成功,将用户信息记录在cookie中
                    cookie('info',base64_encode(json_encode(array('username'=>$data['username'],'nickname'=>$user['nickname']))));
                    @header('Location:/Index/index/');
//                    echo "登陆成功";die;
                }else{
                    echo"密码错误";die;
                }
            }else{
                //用户不存在
                echo "用户不存在";die;
            }
        }
        $this->display();
    }

    
    /**
     * 登出
     */
    public function logout()
    {
        cookie("info",null);
        @header('Location:/User/login');exit;
    }
}