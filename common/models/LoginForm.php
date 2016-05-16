<?php

/**
 * LoginForm class.
 * LoginForm is the data structure for keeping
 * user login form data. It is used by the 'login' action of 'SiteController'.
 */
class LoginForm extends CFormModel
{
	public $username;
	public $email;
	public $password;
	public $verifyCode;
	
	private $_identity;

	/**
	 * Declares the validation rules.
	 * The rules state that username and password are required,
	 * and password needs to be authenticated.
	 */
	public function rules()
	{
		return array(
				// username and password are required when login by Mobile
				array('username, password', 'required', 'on' => 'loginByMobile, captchaRequired'),
				array('email, password', 'required', 'on' => 'loginByEmail'),
				// password needs to be authenticated
				array('username', 'validateNumber', 'on' => 'loginByMobile, captchaRequired'),
				array('email', 'email', 'on' => 'loginByEmail'),
				array('verifyCode','required','on'=>'captchaRequired', 'message' => "Mã xác nhận không đúng"),
				array('verifyCode', 'CaptchaExtendedValidator', 'allowEmpty'=>!CCaptcha::checkRequirements(), 'on' => 'captchaRequired', 'message' => "Mã xác nhận không đúng"),
		);
	}

	public function getLastError(){
		$errs = $this->getErrors();
		$err =  array_pop($errs);
		return $err[0];
	}
	
	/**
	 * Declares attribute labels.
	 */
	public function attributeLabels()
	{
		return array(
				'username'=>'Số điện thoại',
				'password'=>'Mật khẩu'
		);
	}

	public function validateNumber($attribute,$params){
		if(!$this->hasErrors())
		{
			$valid_id = CUtils::validatorMobile($this->username);
			if($valid_id == ''){
				$this->addError('username','Số điện thoại không hợp lệ, vui lòng chọn thuê bao của Viettel và thử lại.');
			}
			$this->username = $valid_id;
				
		}
	}


	/**
	 * Logs in the user using the given username and password in the model.
	 * @return boolean whether login is successful
	 */
	public function loginByMobile()
	{
		$subscriber = $this->username == '' ? null : Subscriber::model()->findByAttributes(array('subscriber_number' => $this->username));
		if($this->_identity===null)
		{
			$this->_identity=new UserIdentity($this->username,$this->password);
			$this->_identity->authenticate(1, $subscriber);
		}
		if($this->_identity->errorCode===UserIdentity::ERROR_NONE)
		{
			$duration= 3600*24; // 1 day
			Yii::app()->user->login($this->_identity,$duration);
			Yii::app()->user->setState('session', strval($this->_identity->session_id));
			Yii::app()->user->setFlash('responseToUser', $this->_identity->errorMessage);
			Yii::app()->user->setReturnUrl('/');
			return true;
		}
		else{
			Yii::app()->user->setFlash('responseToUser', $this->_identity->errorMessage);
			return false;
		}
	}

}
