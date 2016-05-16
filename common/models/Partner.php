<?php

/**
 * This is the model class for table "partner".
 *
 * The followings are the available columns in table 'partner':
 * @property integer $id
 * @property string $display_name
 * @property string $sms_code
 * @property string $create_date
 * @property string $modify_date
 * @property string $note
 *
 * The followings are the available model relations:
 * @property ServiceSubscriberMapping[] $serviceSubscriberMappings
 */
class Partner extends CActiveRecord
{
    /**
     * Returns the static model of the specified AR class.
     * @param string $className active record class name.
     * @return Partner the static model class
     */
    public static function model($className=__CLASS__)
    {
        return parent::model($className);
    }

    /**
     * @return string the associated database table name
     */
    public function tableName()
    {
        return 'partner';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules()
    {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('sms_code', 'required'),
            array('display_name', 'length', 'max'=>100),
            array('sms_code', 'length', 'max'=>10),
            array('note', 'length', 'max'=>300),
            array('create_date, modify_date', 'safe'),
            // The following rule is used by search().
            // Please remove those attributes that should not be searched.
            array('id, cost, display_name, sms_code, create_date, modify_date, note', 'safe', 'on'=>'search'),
        );
    }

    /**
     * @return array relational rules.
     */
    public function relations()
    {
        // NOTE: you may need to adjust the relation name and the related
        // class name for the relations automatically generated below.
        return array(
            'serviceSubscriberMappings' => array(self::HAS_MANY, 'ServiceSubscriberMapping', 'partner_id'),
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels()
    {
        return array(
            'id' => 'ID',
            'display_name' => 'Display Name',
            'sms_code' => 'Sms Code',
            'create_date' => 'Create Date',
            'modify_date' => 'Modify Date',
            'note' => 'Note',
        );
    }

    /**
     * Retrieves a list of models based on the current search/filter conditions.
     * @return CActiveDataProvider the data provider that can return the models based on the search/filter conditions.
     */
    public function search()
    {
        // Warning: Please modify the following code to remove attributes that
        // should not be searched.

        $criteria=new CDbCriteria;

        $criteria->compare('id',$this->id);
        $criteria->compare('display_name',$this->display_name,true);
        $criteria->compare('sms_code',$this->sms_code,true);
        $criteria->compare('create_date',$this->create_date,true);
        $criteria->compare('modify_date',$this->modify_date,true);
        $criteria->compare('note',$this->note,true);

        return new CActiveDataProvider($this, array(
            'criteria'=>$criteria,
        ));
    }
	public static function lstPartner(){
		$result = array();
		$lstPartner = Partner::model()->findAllBySql("select * from partner");
		foreach ($lstPartner as $partner){
			$_item = array($partner->id=>$partner->display_name);
			$result += $_item;
		}
		return $result;
	}
}