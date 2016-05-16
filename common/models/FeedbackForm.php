<?php

/**
 * ContactForm class.
 * ContactForm is the data structure for keeping
 * contact form data. It is used by the 'contact' action of 'SiteController'.
 */
class FeedBackForm extends CFormModel
{
	public $mobile_number;
	public $session;
	public $title;
	public $content;

	/**
	 * Declares the validation rules.
	 */
	public function rules()
	{
		return array(
				// name, email, subject and body are required
				array('mobile_number, title', 'required'),
				// email has to be a valid email address
		);
	}


	/**
	 * Declares customized attribute labels.
	 * If not declared here, an attribute would have a label that is
	 * the same as its name with the first letter in upper case.
	 */
	public function attributeLabels()
	{
		return array(
				'verifyCode'=>'Verification Code',
		);
	}

	public function postFeedback($accessType, $subscriber){
		$response = $this->sendSubscriberFeedback($subscriber, $this->title, $this->content);
		if($response == 1){
			Yii::app()->user->setFlash('responseToUser', 'Lỗi xảy trên hệ thống, xin vui lòng thử lại!');
			return false;
		}else{
			Yii::app()->user->setFlash('responseToUser', "Nội dung phản hồi đã được lưu lại. Cám ơn bạn đã góp ý!");
			return true;
		}
	}
	
	private function sendSubscriberFeedback($subscriber, $title, $content) {
		if($subscriber == NULL) {
			return 1;
		}
		$feedback = new SubscriberFeedback();
		$feedback->subscriber_id = $subscriber->id;
		$feedback->title = $title;
		$feedback->content = $content;
		$feedback->create_date = new CDbExpression("NOW()");
		$feedback->status = 1;
		$feedback->is_responsed = 0;
		if(!$feedback->save()) {
			return 1;
		}
		return 0;
	}
}