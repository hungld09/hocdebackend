<?php

/**
 * This is the model class for table "banner".
 *
 * The followings are the available columns in table 'banner':
 * @property integer $id
 * @property string $url
 * @property string $title
 * @property integer $width
 * @property integer $height
 * @property integer $file_size
 * @property string $format
 * @property string $create_user_id
 * @property string $create_date
 * @property integer $status
 * @property integer $image_type
 * @property integer $image_size_type
 * @property integer $orientation
 * @property integer $time
 * @property string $content
 * @property integer $type
 * @property integer $count_click
 */
class Banner extends CActiveRecord
{
    const ORIENTATION_PORTRAIT = 1;
    const ORIENTATION_LANDSCAPE = 2;
    const url_save_banner = 'http://backend.vfilm.vn';
    //const url_save_banner = 'http://localhost/namviet_ifilmbackend/backend/www';
    const banner = 1;
    const popup = 2;
    public $picture;
    /**
     * Returns the static model of the specified AR class.
     * @param string $className active record class name.
     * @return Banner the static model class
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
        return 'banner';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules()
    {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('url', 'required'),
            array('width, height, file_size, status, image_type, image_size_type, orientation, time, type, count_click', 'numerical', 'integerOnly'=>true),
            array('url', 'length', 'max'=>500),
            array('title', 'length', 'max'=>300),
            array('format', 'length', 'max'=>40),
            array('content', 'length', 'max'=>500),
            array('create_user_id', 'length', 'max'=>11),
            array('create_date', 'safe'),
            // The following rule is used by search().
            // Please remove those attributes that should not be searched.
            array('id, url, title, width, height, file_size, format, create_user_id, create_date, status, image_type, image_size_type, orientation, time, content, type, count_click', 'safe', 'on'=>'search'),
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
            'url' => 'Link',
            'title' => 'Title',
            'width' => 'Width',
            'height' => 'Height',
            'file_size' => 'File Size',
            'format' => 'Format',
            'create_user_id' => 'Create User',
            'create_date' => 'Create Date',
            'status' => 'Status',
            'image_type' => 'Image Type',
            'image_size_type' => 'Image Size Type',
            'orientation' => 'Orientation',
            'time' => 'Tỉ lệ hiện thị (%)',
            'content' => $this->type==1?'Banner':'Nội dung',
            'type' => 'Type',
            'count_click' => 'Lượt click',
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
        $criteria->compare('url',$this->url,true);
        $criteria->compare('title',$this->title,true);
        $criteria->compare('width',$this->width);
        $criteria->compare('height',$this->height);
        $criteria->compare('file_size',$this->file_size);
        $criteria->compare('format',$this->format,true);
        $criteria->compare('create_user_id',$this->create_user_id,true);
        $criteria->compare('create_date',$this->create_date,true);
        $criteria->compare('status',$this->status);
        $criteria->compare('image_type',$this->image_type);
        $criteria->compare('image_size_type',$this->image_size_type);
        $criteria->compare('orientation',$this->orientation);
        $criteria->compare('time',$this->time);
        $criteria->compare('content',$this->content);
        $criteria->compare('type',$this->type);
        $criteria->compare('count_click',$this->count_click);

        return new CActiveDataProvider($this, array(
            'criteria'=>$criteria,
        ));
    }

    public function getListBanner() {
        $criteria=new CDbCriteria;
        $criteria->compare('type',1);
//		$criteria->compare('status',1);
        $model = new CActiveDataProvider($this, array(
            'criteria'=>$criteria,
        ));

        return $model;
    }

    public function getListPopup() {
        $criteria=new CDbCriteria;
        $criteria->compare('type',2);
//		$criteria->compare('status',1);
        $model = new CActiveDataProvider($this, array(
            'criteria'=>$criteria,
        ));

        return $model;
    }

    public function getBanner() {
        if(strpos($this->content, 'http') === false) {
            $result = self::url_save_banner.'/banner/'.$this->content;
        }
        else {
            $result = $this->content;
        }
        return $result;
    }

    public function getPopup() {
        if(strpos($this->content, 'http') === false) {
            $result = self::url_save_banner.'/popup/'.$this->content;
        }
        else {
            $result = $this->content;
        }
        return $result;
    }


    public function getStatus() {
        if($this->status){
            $result = CHtml::image(Yii::app()->baseUrl.'/images/spacer.gif','',array('class'=>'activeImage','id'=>'active_'.$this->id,'onclick'=>'changeActive('.$this->id.');'));
        }
        else {
            $result = CHtml::image(Yii::app()->getBaseUrl(true).'/images/spacer.gif','',array('class'=>'inactiveImage','id'=>'active_'.$this->id,'onclick'=>'changeActive('.$this->id.');'));
        }
        return $result;
    }

    public function getWidth() {
        $width = 0;
        $imageSize = getimagesize(Yii::getPathOfAlias('www').'/banner/'.$this->content);
        if(count($imageSize) > 0) {
            $width = $imageSize[0];
        }
        return $width;
    }

    public function getHeight() {
        $height = 0;
        $imageSize = getimagesize(Yii::getPathOfAlias('www').'/banner/'.$this->content);
        if(count($imageSize) > 0) {
            $height = $imageSize[1];
        }
        return $height;
    }

    public function getImageSize() { //return array: index 0 : width, index 1 : height
        $imageSize = getimagesize(Yii::getPathOfAlias('www').'/banner/'.$this->content);
        return $imageSize;
    }

    public function getPopupImageSize() { //return array: index 0 : width, index 1 : height
        $imageSize = getimagesize(Yii::getPathOfAlias('www').'/popup/'.$this->content);
        return $imageSize;
    }
}
