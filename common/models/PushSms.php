<?php

/**
 * This is the model class for table "push_sms".
 *
 * The followings are the available columns in table 'push_sms':
 * @property integer $id
 * @property integer $subscriber_id
 * @property integer $sms_id
 * @property string $create_date
 * @property string $modify_date
 */
class PushSms extends CActiveRecord
{
    /**
     * @return string the associated database table name
     */
    public function tableName()
    {
        return 'push_sms';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules()
    {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('subscriber_id, create_date', 'required'),
            array('subscriber_id, sms_id', 'numerical', 'integerOnly'=>true),
            array('modify_date', 'safe'),
            // The following rule is used by search().
            // @todo Please remove those attributes that should not be searched.
            array('id, subscriber_id, sms_id, create_date, modify_date', 'safe', 'on'=>'search'),
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
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels()
    {
        return array(
            'id' => 'ID',
            'subscriber_id' => 'Subscriber',
            'sms_id' => 'Sms',
            'create_date' => 'Create Date',
            'modify_date' => 'Modify Date',
        );
    }

    /**
     * Retrieves a list of models based on the current search/filter conditions.
     *
     * Typical usecase:
     * - Initialize the model fields with values from filter form.
     * - Execute this method to get CActiveDataProvider instance which will filter
     * models according to data in model fields.
     * - Pass data provider to CGridView, CListView or any similar widget.
     *
     * @return CActiveDataProvider the data provider that can return the models
     * based on the search/filter conditions.
     */
    public function search()
    {
        // @todo Please modify the following code to remove attributes that should not be searched.

        $criteria=new CDbCriteria;

        $criteria->compare('id',$this->id);
        $criteria->compare('subscriber_id',$this->subscriber_id);
        $criteria->compare('sms_id',$this->sms_id);
        $criteria->compare('create_date',$this->create_date,true);
        $criteria->compare('modify_date',$this->modify_date,true);

        return new CActiveDataProvider($this, array(
            'criteria'=>$criteria,
        ));
    }

    /**
     * Returns the static model of the specified AR class.
     * Please note that you should have this exact method in all your CActiveRecord descendants!
     * @param string $className active record class name.
     * @return PushSms the static model class
     */
    public static function model($className=__CLASS__)
    {
        return parent::model($className);
    }
}