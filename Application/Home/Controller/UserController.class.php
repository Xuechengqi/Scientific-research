<?php
namespace Home\Controller;
//用户控制器
class UserController extends CommonController{
	//通过构造方法限制用户必须登录
	public function __construct(){
		parent::__construct();
		//指定不需要检查登录的方法列表
		$allow_action = array('login','getVerify','register');
		if($this->userinfo === false && !in_array(ACTION_NAME,$allow_action)){
			$this->error('请先登录。',U('User/login'));
		}
	}
	//会员中心首页
	public function index(){
		$User = D('User');
		$userid = (int)SESSION()['userinfo']['id'];
		$username = SESSION()['userinfo']['name'];
		if(SESSION() != null){
			$where = array('id'=>$userid,'username'=>$username);
			$field = 'username,phone,email,avatar';
		}
		$data = $User->getInfo($where,$field);
		$this->assign('user',$data);
		$this->display();
	}
	//用户注册
	public function register(){
		if(IS_POST){
			if(false === $this->checkVerify(I('post.verify'))){
				$this->error('验证码错误',U('User/register'));
			}
			$User = D('User');
			//判断用户名是否已经存在
			if($User->where(array('username'=>I('post.username')))->getField('id')){
				$this->error('注册失败：用户名已经存在。');
			}
			if(!$User->create()){
				//创建数据对象
				$this->error('注册失败：'.$User->getError(),U('User/register'));
			}
			$username = $User->username;
			if(!$id = $User->add()){//添加数据并取出新用户ID
				$this->error('注册失败：保存到数据库失败。',U('User/register'));
			}
			//注册成功后自动登录
			session('userinfo',array('id'=>$id,'name'=>$username));
			$this->redirect('Index/index');
		}
		$this->display();
	}
	//用户登录
	public function login(){
		if(IS_POST){
			if(false===$this->checkVerify(I('post.verify'))){
				$this->error('验证码错误',U('User/login'));
			}
			$User = D('User');//实例化模型
			if(!$User->create()){
				$this->error('登录失败：'.$User->getError(),U('User/login'));
			}
			if($userinfo = $User->checkLogin()){//检查用户名密码
				//登录成功，将登录信息保存到session
				session('userinfo',$userinfo);
				$this->redirect('Index/index');
			}
			$this->error('登录失败：用户名或密码错误。',U('User/login'));
		}
		$this->display();
	}
	//生成验证码
	public function getVerify(){
		$Verify = new \Think\Verify();
		$Verify->entry();
	}
	//检查验证码
	private function checkVerify($code,$id=''){
		$Verify = new \Think\Verify();
		return $Verify->check($code,$id);
	}
	//退出系统
	public function logout(){
		session(null);//清空前台所有会话
		$this->redirect('Index/index');
	}
	//展示我的二手物品
	public function goods(){
		$p = I('get.p/d',0);
		$Goods = D('Goods');
		$User = D('User');
		$userid = (int)SESSION()['userinfo']['id'];
		$field = 'username,avatar';
		$where = array('id'=>$userid);
		$user = $User->getInfo($where,$field);
		$data['goods'] = $Goods->getMyGoods($userid,$p);
		//防止空页被访问
		if(empty($data['goods']['data']) && $p > 0){
			$this->redirect('User/goods');
		}
		$data['p'] = $p;
		$this->user = $user;
		$this->assign($data);
		$this->display();
	}
	//物品列表快捷修改
	public function change(){
		//阻止直接访问
		if(!IS_POST) $this->error('操作失败：未选择物品');
		//获取参数
		$cid = I('get.cid/d',0);
		$p = I('get.p/d',0);
		$id = I('post.id/d',0);
		$field = I('post.field');
		$status = I('post.status');
		//生成跳转地址
		$jump = U('User/goods',array('cid'=>$cid,'p'=>$p));
		$Goods = M('Goods');
		if($field!='on_sale'){
			$this->error('操作失败：非法字段');
		}
		if($status!='yes' && $status!='no'){
			$this->error('操作失败：非法状态值');
		}
		//检查表单令牌
		if(!$Goods->autoCheckToken($_POST)){
			$this->error('表单已过期，请重新提交',$jump);
		}
		if(false === $Goods->where(array('id'=>$id,'recycle'=>'no'))->save(array($field=>$status))){
			$this->error('操作失败：数据库保存失败',$jump);
		}
		redirect($jump);
	}
	//删除物品（并不是放入回收站,真正的删除数据）
	public function del(){
		//阻止直接访问
		if(!IS_POST) $this->error('删除失败：未选择物品');
		//获取参数
		$p = I('get.p/d',0);
		$id = I('post.id/d',0);
		//生成跳转地址
		$jump = U('User/goods',array('p'=>$p));
		$Goods = D('Goods');
		//检查表单令牌
		if(!$Goods->autoCheckToken($_POST)){
			$this->error('表单已过期，请重新提交',$jump);
		}
		//准备where条件
		$where = array('id'=>$id);
		//删除物品图片
		$Goods->delThumbFile($where);
		//删除物品数据
		$Goods->where($where)->delete();
		redirect($jump);
	}
	//物品修改
	public function editGoods(){
		//获取参数
		$id = I('get.id/d',0);
		$p = I('get.p/d',0);
		$cid = I('get.cid/d',0,'abs');
		$Category = D('Category');
		$Goods = D('Goods');
		$User = D('User');
		$userid = (int)SESSION()['userinfo']['id'];
		$field = 'username,avatar';
		$where = array('id'=>$userid);
		$user = $User->getInfo($where,$field);
		$where = array('id'=>$id,'recycle'=>'no');
		if(IS_POST){
			if(!$Goods->create(null,2)){
				$this->error('修改物品信息失败：'.$Goods->getError());
			}
			$Goods->category_id = $cid;
			$Goods->desc = I('post.desc','','htmlpurifier');
			if(isset($_FILES['thumb']) && $_FILES['thumb']['error'] === 0){
				$rst = $Goods->uploadThumb('thumb');
				if(!$rst['flag']){
					$this->error('上传图片失败：'.$rst['error']);
				}
				$Goods->thumb = $rst['path'];
				$Goods->delThumbFile($where);
			}
			if(false === $Goods->where($where)->save()){
				$this->error('修改物品信息失败！');
			}
			if(isset($_POST['return'])) $this->redirect('User/goods',array('cid'=>$cid,'p'=>$p));
			$this->assign('success',true);
		}
		//查询物品数据
		$data['goods'] = $Goods->getGoods($where);
		if(!$data['goods']){
			$this->error('修改失败：物品不存在。');
		}
		$data['category'] = $Category->getList();
		$data['cid'] = $cid;
		$data['id'] = $id;
		$data['p'] = $p;
		$this->user = $user;
		$this->assign($data);
		$this->display();
	}
	//物品添加
	public function add(){
		$userid = (int)SESSION()['userinfo']['id'];
		$cid = I('get.cid/d',0);
		if($cid < 0) $cid = 0;
		$Category = D('Category');
		$Goods = D('Goods');
		$User = D('User');
		$field = 'username,avatar';
		$where = array('id'=>$userid);
		$user = $User->getInfo($where,$field);
		if(IS_POST){
			if(!$Goods->create()){
				$this->error('添加物品失败：'.$Goods->getError());
			}
			//处理特殊字段
			$Goods->category_id = $cid;
			$Goods->thumb = '';
			$Goods->desc = I('post.desc','','htmlpurifier');
			$Goods->seller_id = $userid;
			if(!empty($_FILES['thumb']['tmp_name'])){
				$rst = $Goods->uploadThumb('thumb');
				if(!$rst['flag']){
					$this->error('上传图片失败：'.$rst['error']);
				}
				$Goods->thumb = $rst['path'];
			}
			if(!$Goods->add()){
				$this->error('添加物品失败！');
			}
			//添加物品成功
			if(isset($_POST['return']))
				$this->redirect('User/goods');
			$this->assign('success',true);
		}
		$data['category'] = $Category->getList();
		$data['cid'] = $cid;
		$this->user = $user;
		$this->assign($data);
		$this->display();
	}
	//修改个人信息
	public function info(){
		$userid = (int)SESSION()['userinfo']['id'];
		$User = D('User');
		$where = array('id'=>$userid);
		if(IS_POST){
			if(!$User->create(null,2)){
				$this->error('修改个人信息失败：'.$User->getError());
			}
			$User->phone = I('post.phone');
			$User->email = I('post.email');
			if(isset($_FILES['avatar']) && $_FILES['avatar']['error'] === 0){
				$rst = $User->uploadAvatar($userid,'avatar');
				if(!$rst['flag']){
					$this->error('上传头像失败：'.$rst['error']);
				}
				$User->avatar = $rst['path'];
				$User->delAvatarFile($where);
			}
			if(false === $User->where($where)->save()){
				$this->error('修改个人信息失败！');
			}
			$this->assign('success',true);
		}
		$field = 'username,phone,email,avatar';
		$data = $User->getInfo($where,$field);
		$this->assign('user',$data);
		$this->display();
	}
	//修改密码
	public function changePwd(){
		if(IS_POST){
			$User = D('User');
			if(!$User->create(null,2)){
				$this->error('修改密码失败：'.$User->getError());
			}
			$User->id = SESSION()['userinfo']['id'];
			$User->username = SESSION()['userinfo']['name'];
			$where = array('id'=>$User->id,'username'=>$User->username);
			$oldPwd = $_POST['oldPwd'];
			if(!$User->checkpwd($where,$oldPwd)){
				$this->error('密码不正确，请确认您的旧密码。');
			}
			$User->password = $_POST['password'];
			if(false === $User->where($where)->save()){
				$this->error('修改密码失败！');
			}
			$this->assign('success',true);
			session(null);
		}
		$this->display();
	}
}
?>