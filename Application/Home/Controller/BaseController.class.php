<?php

namespace Home\Controller;

use Think\Controller;

/**
 * Class BaseController
 * @package Home\Controller
 * 定义一个基础控制器
 */
class BaseController extends Controller
{
    public function __construct()
    {
        parent::__construct();
        //加入登陆拦截 MODULE_NAME,CONTROLLER_NAME,ACTION_NAME
        //dump(CONTROLLER_NAME);die;
        $user = $this->getUser();
        if(!$user){
            $uri = CONTROLLER_NAME.'/'.ACTION_NAME;
            if(!in_array($uri, ['User/login','User/logout','User/register']) ){
                //如果不是上述几个ｕｒｌ，则进行登陆判断
                $this->redirect('User/login');
            }
        }else{
            S('user',(array)json_decode(base64_decode($user)));
            //TODO 可以在这里加上延长登陆时间和校验登陆ip的功能．
        }

    }

    public function getUser(){
        if(!isset($_COOKIE['info'])) return false;
        else
            return $_COOKIE['info'];
    }
}