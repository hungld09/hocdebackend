<?php

/**
 * This is the model class for table "vod_category".
 *
 * The followings are the available columns in table 'vod_category':
 * @property integer $id
 * @property string $code_name
 * @property string $display_name
 * @property string $display_name_ascii
 * @property string $description
 * @property string $description_ascii
 * @property integer $status
 * @property string $status_log
 * @property integer $order_number
 * @property integer $parent_id
 * @property string $path
 * @property integer $level
 * @property integer $child_count
 * @property string $image_url
 * @property string $tags
 * @property string $tags_ascii
 * @property string $create_date
 * @property string $modify_date
 * @property string $create_user_id
 * @property string $modify_user_id
 *
 * The followings are the available model relations:
 * @property AppUser $createUser
 * @property AppUser $modifyUser
 * @property VodCategory $parent
 * @property VodCategory[] $vodCategories
 * @property VodCategoryAssetMapping[] $vodCategoryAssetMappings
 * @property VodSearchHistory[] $vodSearchHistories
 */
class VodCategory extends CActiveRecord
{
	public $path_name;
	public $page;
	public $packages;
	public $children='';

	const VOD_CAT_STATUS_ACTIVE = 1;
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return VodCategory the static model class
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
		return 'vod_category';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
				array('code_name, display_name', 'required'),
				array('status, order_number, parent_id, level, child_count', 'numerical', 'integerOnly'=>true),
				array('code_name, display_name, display_name_ascii, path', 'length', 'max'=>200),
				array('image_url, tags, tags_ascii', 'length', 'max'=>500),
				array('create_user_id, modify_user_id', 'length', 'max'=>11),
				array('description, description_ascii, status_log, create_date, modify_date', 'safe'),
				// The following rule is used by search().
				// Please remove those attributes that should not be searched.
				array('id, code_name, display_name, display_name_ascii, description, description_ascii, status, status_log, order_number, parent_id, path, level, child_count, image_url, tags, tags_ascii, create_date, modify_date, create_user_id, modify_user_id', 'safe', 'on'=>'search'),
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
				'createUser' => array(self::BELONGS_TO, 'AppUser', 'create_user_id'),
				'modifyUser' => array(self::BELONGS_TO, 'AppUser', 'modify_user_id'),
				'parent' => array(self::BELONGS_TO, 'VodCategory', 'parent_id'),
				'vodCategories' => array(self::HAS_MANY, 'VodCategory', 'parent_id'),
				'vodCategoryAssetMappings' => array(self::HAS_MANY, 'VodCategoryAssetMapping', 'vod_category_id'),
				'vodSearchHistories' => array(self::HAS_MANY, 'VodSearchHistory', 'vod_category_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
				'id' => 'ID',
				'code_name' => 'Code Name',
				'display_name' => 'Display Name',
				'display_name_ascii' => 'Display Name Ascii',
				'description' => 'Description',
				'description_ascii' => 'Description Ascii',
				'status' => 'Status',
				'status_log' => 'Status Log',
				'order_number' => 'Order Number',
				'parent_id' => 'Parent',
				'path' => 'Path',
				'level' => 'Level',
				'child_count' => 'Child Count',
				'image_url' => 'Image Url',
				'tags' => 'Tags',
				'tags_ascii' => 'Tags Ascii',
				'create_date' => 'Create Date',
				'modify_date' => 'Modify Date',
				'create_user_id' => 'Create User',
				'modify_user_id' => 'Modify User',
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
		$criteria->compare('code_name',$this->code_name,true);
		$criteria->compare('display_name',$this->display_name,true);
		$criteria->compare('display_name_ascii',$this->display_name_ascii,true);
		$criteria->compare('description',$this->description,true);
		$criteria->compare('description_ascii',$this->description_ascii,true);
		$criteria->compare('status',$this->status);
		$criteria->compare('status_log',$this->status_log,true);
		$criteria->compare('order_number',$this->order_number);
		$criteria->compare('parent_id',$this->parent_id);
		$criteria->compare('path',$this->path,true);
		$criteria->compare('level',$this->level);
		$criteria->compare('child_count',$this->child_count);
		$criteria->compare('image_url',$this->image_url,true);
		$criteria->compare('tags',$this->tags,true);
		$criteria->compare('tags_ascii',$this->tags_ascii,true);
		$criteria->compare('create_date',$this->create_date,true);
		$criteria->compare('modify_date',$this->modify_date,true);
		$criteria->compare('create_user_id',$this->create_user_id,true);
		$criteria->compare('modify_user_id',$this->modify_user_id,true);

		return new CActiveDataProvider($this, array(
				'criteria'=>$criteria,
		));
	}

	public function getListedForJUI() {

		$returnarray = array('0'.$this->id=>$this->path_name);
		if($this->vodCategories) foreach($this->vodCategories as $child)
		if ($child->status!=2){
			for ($i = 0; $i < $child->level; $i++)
				$child->path_name .= "----| ";
			$child->path_name .= $child->display_name;
			$returnarray = array_merge($returnarray, $child->getListedForJUI());
			 
		}
		return $returnarray;
	}

	public function getListed($id=null) {
		$returnarray=array();
		if ($id!=$this->id) {
			$returnarray = array($this);
			if($this->vodCategories) {
				foreach($this->vodCategories as $child) {
					if ($child->status!=2){
						for ($i=0;$i<$child->level;$i++)
							$child->path_name .= "----| ";
						$child->path_name .= $child->display_name;
						$returnarray = array_merge($returnarray,$child->getListed($id));

					}
				}
			}
		}
		return $returnarray;
	}

	public function getListSub($id=null) { // get sub categories, not merge $this
		$returnarray=array();
		if ($id!=$this->id) {
			$returnarray = array();
			if($this->vodCategories) {
				foreach($this->vodCategories as $child) {
					if ($child->status!=2){
						for ($i=0;$i<$child->level;$i++)
							$child->path_name .= "----| ";
						$child->path_name .= $child->display_name;
						$returnarray = array_merge($returnarray,$child->getListed($id));

					}
				}
			}
		}
		return $returnarray;
	}
	 
	public function getCategoryCount() {
		if ($this->parent_id == NULL) {
			$count = count(VodCategory::model()->findAllByAttributes(array('level'=>0)));
		} else $count = count($this->parent->vodCategories);
		 
		return $count;
	}
	 
	public function getPathName() {
		$item = $this;
		$path = $item->display_name;
		while ($item->level!=0) {
			$item = $item->parent;
			$path = $item->display_name.'/'.$path;
		}
		return $path;
	}
	 
	/**
	 * lay tat ca cac categories con cua category co id = $_cat_id
	 * @param boolean $_recursive = false neu chi tim trong 1 level tiep theo, = true nếu goi de quy
	 * @param integer $_cat_id, = null neu la toan bo category tree
	 * @return type array
	 */
	public static function getSubCategories($_cat_id=null, $_recursive=false) {
		$res = array();
		if (($_cat_id)) {
			$model = VodCategory::model()->findByPk($_cat_id);
			/* @var $model VodCategory */
			if ($model === null)
				throw new CHttpException(404, "The requested Vod Category (#$_cat_id) does not exist.");

			//Thuc: them 'order'=>'order_number ASC' trong ham relations
			$chidren = $model->vodCategories;
			if ($chidren) {
				foreach ($chidren as $child) {
					if($child->status!=1) {
						continue;
					}
					/* @var $child VodCategory */
					for ($i = 0; $i < $child->level; $i++) {
						$child->path .= "|___ ";
					}
					$child->path .= $child->display_name;
					$res = array_merge($res, array($child));
					if ($_recursive) {
						$res = array_merge($res, VodCategory::getSubCategories($child->id,$_recursive));
					}
				}
			}
		}
		else {
			$_root_cats = VodCategory::model()->findAllByAttributes(array("level"=>0),array('order'=>'order_number ASC'));
			if (!is_null($_root_cats)) {
				foreach ($_root_cats as $_root_cat) {
					/* @var $_root_cat VodCategory */
					if($_root_cat->status!=1) {
						continue;
					}
					$_root_cat->path = $_root_cat->display_name;
					$res = array_merge($res, array($_root_cat));
					if ($_recursive) {
						$res = array_merge($res, VodCategory::getSubCategories($_root_cat->id,$_recursive));
					}
				}
			}
		}
		 
		return $res;
	}
	 
	public static function _categoriesToJSON($data) {
		$_parentNode = array();
		foreach($data as $node) {
			/* @var $node VodCategory */
			if ($node->status==1) {
				$categoryNode = array();
				$categoryNode['id'] = CHtml::encode(($node->id));
				$categoryNode['create_date'] = $node->create_date;
				$categoryNode['name'] = CHtml::encode(($node->display_name));
				$categoryNode['description'] = ($node->description);
				//             	$categoryNode['image'] = CHtml::encode(($node->image_url1));
				 
				//             	$_parentNode['category'] = $categoryNode;
				$categoryNode['category'] = self::_categoriesToJSON(VodCategory::getSubCategories($node->id,false));
				$_parentNode[] = $categoryNode;
			}
		}
		return $_parentNode;
	}
}
