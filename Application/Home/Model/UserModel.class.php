<?php
namespace Home\Model;
use Think\Model;
class UserModel extends Model{
	protected $insertFields = 'username,password';
	protected $updateFields = 'phone,email,avatar,password';
	protected $_validate = array(
		//注册时验证(1表示self::MODEL_INSERT,0表示存在字段就验证，2表示值不为空时验证，3全部情况下验证)
		array('username','2,20','用户名位数不合法（2~20位）',1,'length',1),
		array('username','/^[\w\x{4e00}-\x{9fa5}]+$/u','用户名只能是汉字、字母、数字、下划线。',1,'regex',1),
		array('password','6,20','密码位数不合法（6~20位）',0,'length',0),
		array('password','/^\w+$/','密码只能是字母、数字、下划线。',0,'regex',0),
	);
	//密码加密函数
	private function password($pwd,$salt){
		return md5(md5($pwd).$salt);
	}
	//插入数据前的回调方法
	protected function _before_insert(&$data,$option){
		$data['salt'] = substr(uniqid(),-6);
		$data['password'] = $this->password($data['password'],$data['salt']);
	}
	//判断用户名和密码
	public function checkLogin(){
		//表单提交的数据
		$username = $this->data['username'];
		$password = $this->data['password'];

		$data = $this->field('id,password,salt')->where(array('username'=>$username))->find();
		if($data && $data['password'] == $this->password($password,$data['salt'])){
			return array('id'=>$data['id'],'name'=>$username);
		}
		return false;
	}
	//查找用户信息
	public function getInfo($where,$field){
		$data = $this->field($field)->where($where)->find();
		return $data;
	}
	//上传头像
	public function uploadAvatar($save,$upfile){
		//准备上传目录
		$file['temp'] = './Public/Uploads/temp/';
		file_exists($file['temp']) or mkdir($file['temp'],0777,true);
		$Upload = new \Think\Upload(array(
			'exts' =>array('jpg','jpeg','png'),
			'rootPath' => $file['temp'],
			'autoSub' => false,
		));
		if(false===($rst = $Upload->uploadOne($_FILES[$upfile]))){
			return array('flag'=>false,'error'=>$Upload->getError());
		}
		$file['name'] = $rst['savename'];
		$file['save'] = $save.'/';
		$file['path'] = './Public/Uploads/headimg/'.$file['save'];
		file_exists($file['path']) or mkdir($file['path'],0777,true);
		$Image = new \Think\Image();
		$Image->open($file['temp'].$file['name']);
		$Image->thumb(100,100,2)->save($file['path'].$file['name']);
		unlink($file['temp'].$file['name']);
		return array('flag'=>true,'path'=>$file['save'].$file['name']);
	}
	//删除用户头像
	public function delAvatarFile($where){
		$thumb = $this->where($where)->getField('avatar');
		if(!$thumb) return;
		$path = './Public/Uploads/headimg/$thumb';
		if(is_file($path)) unlink($path);
	}
	//判断用户密码
	public function checkpwd($where,$oldPwd){
		$data = $this->field('id,password,salt')->where($where)->find();
		if($data && $data['password'] == $this->password($oldPwd,$data['salt'])){
			return array('id'=>$data['id']);
		}
		return false;
	}
	//
	protected function _before_update(&$data,$option){
		$data['salt'] = substr(uniqid(),-6);
		$data['password'] = $this->password($data['password'],$data['salt']);
	}
}
?>