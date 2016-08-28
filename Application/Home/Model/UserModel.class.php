<?php
namespace Home\Model;
use Think\Model;
class UserModel extends Model{
	protected $insertFields = 'username,password';
	protected $updateFields = 'phone,email';
	protected $_validate = array(
		//注册时验证(1表示self::MODEL_INSERT)
		array('username','2,20','用户名位数不合法（2~20位）',1,'length',1),
		array('username','/^[\w\x{4e00}-\x{9fa5}]+$/u','用户名只能是汉字、字母、数字、下划线。',1,'regex',1),
		array('password','6,20','密码位数不合法（6~20位）',1,'length',1),
		array('password','/^\w+$/','密码只能是字母、数字、下划线。',1,'regex',1),
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
}
?>