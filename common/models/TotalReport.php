<?php

/**
 * This is the model class for table "total_report".
 *
 * The followings are the available columns in table 'total_report':
 * @property integer $id
 * @property string $create_date
 * @property integer $tong_so_tb_dang_kich_hoat
 * @property integer $tong_so_tb_bi_huy
 * @property integer $so_tb_huy_phim30
 * @property integer $so_tb_huy_phim7
 * @property integer $so_tb_huy_phim
 * @property integer $tong_so_tb_huy_dv
 * @property integer $so_tb_gia_han_tc_phim30
 * @property integer $so_tb_gia_han_tc_phim7
 * @property integer $so_tb_gia_han_tc_phim
 * @property integer $tong_so_tb_gia_han_tc
 * @property integer $so_tb_truy_thu_tc_phim30
 * @property integer $so_tb_truy_thu_tc_phim7
 * @property integer $so_tb_truy_thu_tc_phim
 * @property integer $tong_so_tb_truy_thu_tc
 * @property integer $so_tb_can_truy_thu_phim30
 * @property integer $so_tb_can_truy_thu_phim7
 * @property integer $so_tb_can_truy_thu_phim
 * @property integer $tong_so_tb_can_truy_thu
 * @property integer $so_tb_can_gia_han_phim30
 * @property integer $so_tb_can_gia_han_phim7
 * @property integer $so_tb_can_gia_han_phim
 * @property integer $tong_so_tb_can_gia_han
 * @property integer $so_tb_luy_ke_phim30
 * @property integer $so_tb_luy_ke_phim7
 * @property integer $so_tb_luy_ke_phim
 * @property integer $tong_so_tb_luy_ke
 * @property integer $so_luot_dk_tb_phim30
 * @property integer $so_luot_dk_tb_phim7
 * @property integer $so_luot_dk_tb_phim
 * @property integer $so_luot_dk_tb_moi
 * @property integer $tong_so_tb_huy_dv_trong_ngay
 * @property integer $tong_so_tb_dk_moi_trong_ngay
 * @property integer $tong_so_tb_phat_sinh_cuoc
 * @property integer $tong_doanh_thu_dich_vu
 * @property integer $doanh_thu_truy_thu_phim30
 * @property integer $doanh_thu_truy_thu_phim7
 * @property integer $doanh_thu_truy_thu_phim
 * @property integer $tong_doanh_thu_truy_thu
 * @property integer $doanh_thu_gia_han_phim30
 * @property integer $doanh_thu_gia_han_phim7
 * @property integer $doanh_thu_gia_han_phim
 * @property integer $tong_doanh_thu_gia_han
 * @property integer $doanh_thu_dk_phim30
 * @property integer $doanh_thu_dk_phim7
 * @property integer $doanh_thu_dk_phim
 * @property integer $tong_doanh_thu_dk_moi
 * @property integer $doanh_thu_gui_tang_goi_cuoc
 * @property integer $doanh_thu_gui_tang_phim
 * @property integer $doanh_thu_download
 * @property integer $doanh_thu_xem
 * @property integer $so_tb_gui_tang_goi_cuoc
 * @property integer $so_tb_gui_tang_phim
 * @property integer $so_luot_gui_tang_goi_cuoc
 * @property integer $so_luot_gui_tang_phim
 * @property integer $so_tb_xem_mat_phi
 * @property integer $so_luot_xem_mat_phi
 * @property integer $so_tb_chua_dk_xem_free
 * @property integer $so_luot_xem_free_cua_tb_chua_dk
 * @property integer $so_tb_dk_xem_free
 * @property integer $so_tb_no_cuoc_xem_free
 * @property integer $so_luot_xem_free_cua_tb_no_cuoc
 * @property integer $so_luot_xem_free
 * @property integer $so_luot_xem
 * @property integer $tong_so_tb_chua_dk_truy_cap
 * @property integer $tong_so_tb_dk_truy_cap
 * @property integer $tong_so_luot_truy_cap_cua_tb_chua_dk
 * @property integer $tong_so_luot_truy_cap_cua_tb_dk
 * @property integer $tong_so_tb_truy_cap
 * @property integer $tong_so_luot_truy_cap
 * @property integer $so_tb_dk_qua_sms
 * @property integer $so_tb_dk_qua_app
 * @property integer $so_tb_dk_qua_wap
 * @property integer $so_tb_dk_qua_app
 * @property integer $so_tb_huy_qua_sms
 * @property integer $so_tb_huy_qua_wap
 * @property integer $so_tb_huy_qua_app
 * @property integer $so_tb_bi_huy_phim30
 * @property integer $so_tb_bi_huy_phim7
 * @property integer $so_tb_bi_huy_phim
 * @property integer $so_tb_dk_ctkm_phim
 * @property integer $so_tb_dk_ctkm_phim7
 * @property integer $so_tb_dk_ctkm_phim30
 * 
 */
class TotalReport extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return TotalReport the static model class
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
		return 'total_report';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('tong_so_tb_dang_kich_hoat, tong_so_tb_bi_huy, so_tb_huy_phim30, so_tb_huy_phim7, so_tb_huy_phim, tong_so_tb_huy_dv, so_tb_gia_han_tc_phim30, so_tb_gia_han_tc_phim7, so_tb_gia_han_tc_phim, tong_so_tb_gia_han_tc, so_tb_truy_thu_tc_phim30, so_tb_truy_thu_tc_phim7, so_tb_truy_thu_tc_phim, tong_so_tb_truy_thu_tc, so_tb_can_truy_thu_phim30, so_tb_can_truy_thu_phim7, so_tb_can_truy_thu_phim, tong_so_tb_can_truy_thu, so_tb_can_gia_han_phim30, so_tb_can_gia_han_phim7, so_tb_can_gia_han_phim, tong_so_tb_can_gia_han, so_tb_luy_ke_phim30, so_tb_luy_ke_phim7, so_tb_luy_ke_phim, tong_so_tb_luy_ke, so_luot_dk_tb_phim30, so_luot_dk_tb_phim7, so_luot_dk_tb_phim, so_luot_dk_tb_moi, tong_so_tb_huy_dv_trong_ngay, tong_so_tb_dk_moi_trong_ngay, tong_so_tb_phat_sinh_cuoc, tong_doanh_thu_dich_vu, doanh_thu_truy_thu_phim30, doanh_thu_truy_thu_phim7, doanh_thu_truy_thu_phim, tong_doanh_thu_truy_thu, doanh_thu_gia_han_phim30, doanh_thu_gia_han_phim7, doanh_thu_gia_han_phim, tong_doanh_thu_gia_han, doanh_thu_dk_phim30, doanh_thu_dk_phim7, doanh_thu_dk_phim, tong_doanh_thu_dk_moi, doanh_thu_gui_tang_goi_cuoc, doanh_thu_gui_tang_phim, doanh_thu_download, doanh_thu_xem, so_tb_gui_tang_goi_cuoc, so_tb_gui_tang_phim, so_luot_gui_tang_goi_cuoc, so_luot_gui_tang_phim, so_tb_xem_mat_phi, so_luot_xem_mat_phi, so_tb_chua_dk_xem_free, so_luot_xem_free_cua_tb_chua_dk, so_tb_dk_xem_free, so_tb_no_cuoc_xem_free, so_luot_xem_free_cua_tb_no_cuoc, so_luot_xem_free, so_luot_xem, tong_so_tb_chua_dk_truy_cap, tong_so_tb_dk_truy_cap, tong_so_luot_truy_cap_cua_tb_chua_dk, tong_so_luot_truy_cap_cua_tb_dk, tong_so_tb_truy_cap, tong_so_luot_truy_cap, so_tb_dk_qua_sms, so_tb_dk_qua_wap, so_tb_dk_qua_app, so_tb_huy_qua_sms, so_tb_huy_qua_wap, so_tb_huy_qua_app, so_tb_bi_huy_phim30, so_tb_bi_huy_phim7, so_tb_bi_huy_phim, so_tb_dk_ctkm_phim, so_tb_dk_ctkm_phim7, so_tb_dk_ctkm_phim30', 'numerical', 'integerOnly'=>true),
			array('create_date', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, create_date, tong_so_tb_dang_kich_hoat, tong_so_tb_bi_huy, so_tb_huy_phim30, so_tb_huy_phim7, so_tb_huy_phim, tong_so_tb_huy_dv, so_tb_gia_han_tc_phim30, so_tb_gia_han_tc_phim7, so_tb_gia_han_tc_phim, tong_so_tb_gia_han_tc, so_tb_truy_thu_tc_phim30, so_tb_truy_thu_tc_phim7, so_tb_truy_thu_tc_phim, tong_so_tb_truy_thu_tc, so_tb_can_truy_thu_phim30, so_tb_can_truy_thu_phim7, so_tb_can_truy_thu_phim, tong_so_tb_can_truy_thu, so_tb_can_gia_han_phim30, so_tb_can_gia_han_phim7, so_tb_can_gia_han_phim, tong_so_tb_can_gia_han, so_tb_luy_ke_phim30, so_tb_luy_ke_phim7, so_tb_luy_ke_phim, tong_so_tb_luy_ke, so_luot_dk_tb_phim30, so_luot_dk_tb_phim7, so_luot_dk_tb_phim, so_luot_dk_tb_moi, tong_so_tb_huy_dv_trong_ngay, tong_so_tb_dk_moi_trong_ngay, tong_so_tb_phat_sinh_cuoc, tong_doanh_thu_dich_vu, doanh_thu_truy_thu_phim30, doanh_thu_truy_thu_phim7, doanh_thu_truy_thu_phim, tong_doanh_thu_truy_thu, doanh_thu_gia_han_phim30, doanh_thu_gia_han_phim7, doanh_thu_gia_han_phim, tong_doanh_thu_gia_han, doanh_thu_dk_phim30, doanh_thu_dk_phim7, doanh_thu_dk_phim, tong_doanh_thu_dk_moi, doanh_thu_gui_tang_goi_cuoc, doanh_thu_gui_tang_phim, doanh_thu_download, doanh_thu_xem, so_tb_gui_tang_goi_cuoc, so_tb_gui_tang_phim, so_luot_gui_tang_goi_cuoc, so_luot_gui_tang_phim, so_tb_xem_mat_phi, so_luot_xem_mat_phi, so_tb_chua_dk_xem_free, so_luot_xem_free_cua_tb_chua_dk, so_tb_dk_xem_free, so_tb_no_cuoc_xem_free, so_luot_xem_free_cua_tb_no_cuoc, so_luot_xem_free, so_luot_xem, tong_so_tb_chua_dk_truy_cap, tong_so_tb_dk_truy_cap, tong_so_luot_truy_cap_cua_tb_chua_dk, tong_so_luot_truy_cap_cua_tb_dk, tong_so_tb_truy_cap, tong_so_luot_truy_cap, so_tb_dk_qua_sms, so_tb_dk_qua_wap, so_tb_huy_qua_sms, so_tb_huy_qua_wap, so_tb_bi_huy_phim30, so_tb_bi_huy_phim7, so_tb_bi_huy_phim', 'safe', 'on'=>'search'),
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
			'create_date' => 'Create Date',
			'tong_so_tb_dang_kich_hoat' => 'Tong So Tb Dang Kich Hoat',
			'tong_so_tb_bi_huy' => 'Tong So Tb Bi Huy',
			'so_tb_huy_phim30' => 'So Tb Huy Phim30',
			'so_tb_huy_phim7' => 'So Tb Huy Phim7',
			'so_tb_huy_phim' => 'So Tb Huy Phim',
			'tong_so_tb_huy_dv' => 'Tong So Tb Huy Dv',
			'so_tb_gia_han_tc_phim30' => 'So Tb Gia Han Tc Phim30',
			'so_tb_gia_han_tc_phim7' => 'So Tb Gia Han Tc Phim7',
			'so_tb_gia_han_tc_phim' => 'So Tb Gia Han Tc Phim',
			'tong_so_tb_gia_han_tc' => 'Tong So Tb Gia Han Tc',
			'so_tb_truy_thu_tc_phim30' => 'So Tb Truy Thu Tc Phim30',
			'so_tb_truy_thu_tc_phim7' => 'So Tb Truy Thu Tc Phim7',
			'so_tb_truy_thu_tc_phim' => 'So Tb Truy Thu Tc Phim',
			'tong_so_tb_truy_thu_tc' => 'Tong So Tb Truy Thu Tc',
			'so_tb_can_truy_thu_phim30' => 'So Tb Can Truy Thu Phim30',
			'so_tb_can_truy_thu_phim7' => 'So Tb Can Truy Thu Phim7',
			'so_tb_can_truy_thu_phim' => 'So Tb Can Truy Thu Phim',
			'tong_so_tb_can_truy_thu' => 'Tong So Tb Can Truy Thu',
			'so_tb_can_gia_han_phim30' => 'So Tb Can Gia Han Phim30',
			'so_tb_can_gia_han_phim7' => 'So Tb Can Gia Han Phim7',
			'so_tb_can_gia_han_phim' => 'So Tb Can Gia Han Phim',
			'tong_so_tb_can_gia_han' => 'Tong So Tb Can Gia Han',
			'so_tb_luy_ke_phim30' => 'So Tb Luy Ke Phim30',
			'so_tb_luy_ke_phim7' => 'So Tb Luy Ke Phim7',
			'so_tb_luy_ke_phim' => 'So Tb Luy Ke Phim',
			'tong_so_tb_luy_ke' => 'Tong So Tb Luy Ke',
			'so_luot_dk_tb_phim30' => 'So Luot Dk Tb Phim30',
			'so_luot_dk_tb_phim7' => 'So Luot Dk Tb Phim7',
			'so_luot_dk_tb_phim' => 'So Luot Dk Tb Phim',
			'so_luot_dk_tb_moi' => 'So Luot Dk Tb Moi',
			'tong_so_tb_huy_dv_trong_ngay' => 'Tong So Tb Huy Dv Trong Ngay',
			'tong_so_tb_dk_moi_trong_ngay' => 'Tong So Tb Dk Moi Trong Ngay',
			'tong_so_tb_phat_sinh_cuoc' => 'Tong So Tb Phat Sinh Cuoc',
			'tong_doanh_thu_dich_vu' => 'Tong Doanh Thu Dich Vu',
			'doanh_thu_truy_thu_phim30' => 'Doanh Thu Truy Thu Phim30',
			'doanh_thu_truy_thu_phim7' => 'Doanh Thu Truy Thu Phim7',
			'doanh_thu_truy_thu_phim' => 'Doanh Thu Truy Thu Phim',
			'tong_doanh_thu_truy_thu' => 'Tong Doanh Thu Truy Thu',
			'doanh_thu_gia_han_phim30' => 'Doanh Thu Gia Han Phim30',
			'doanh_thu_gia_han_phim7' => 'Doanh Thu Gia Han Phim7',
			'doanh_thu_gia_han_phim' => 'Doanh Thu Gia Han Phim',
			'tong_doanh_thu_gia_han' => 'Tong Doanh Thu Gia Han',
			'doanh_thu_dk_phim30' => 'Doanh Thu Dk Phim30',
			'doanh_thu_dk_phim7' => 'Doanh Thu Dk Phim7',
			'doanh_thu_dk_phim' => 'Doanh Thu Dk Phim',
			'tong_doanh_thu_dk_moi' => 'Tong Doanh Thu Dk Moi',
			'doanh_thu_gui_tang_goi_cuoc' => 'Doanh Thu Gui Tang Goi Cuoc',
			'doanh_thu_gui_tang_phim' => 'Doanh Thu Gui Tang Phim',
			'doanh_thu_download' => 'Doanh Thu Download',
			'doanh_thu_xem' => 'Doanh Thu Xem',
			'so_tb_gui_tang_goi_cuoc' => 'So Tb Gui Tang Goi Cuoc',
			'so_tb_gui_tang_phim' => 'So Tb Gui Tang Phim',
			'so_luot_gui_tang_goi_cuoc' => 'So Luot Gui Tang Goi Cuoc',
			'so_luot_gui_tang_phim' => 'So Luot Gui Tang Phim',
			'so_tb_xem_mat_phi' => 'So Tb Xem Mat Phi',
			'so_luot_xem_mat_phi' => 'So Luot Xem Mat Phi',
			'so_tb_chua_dk_xem_free' => 'So Tb Chua Dk Xem Free',
			'so_luot_xem_free_cua_tb_chua_dk' => 'So Luot Xem Free Cua Tb Chua Dk',
			'so_tb_dk_xem_free' => 'So Tb Dk Xem Free',
			'so_tb_no_cuoc_xem_free' => 'So Tb No Cuoc Xem Free',
			'so_luot_xem_free_cua_tb_no_cuoc' => 'So Luot Xem Free Cua Tb No Cuoc',
			'so_luot_xem_free' => 'So Luot Xem Free',
			'so_luot_xem' => 'So Luot Xem',
			'tong_so_tb_chua_dk_truy_cap' => 'Tong So Tb Chua Dk Truy Cap',
			'tong_so_tb_dk_truy_cap' => 'Tong So Tb Dk Truy Cap',
			'tong_so_luot_truy_cap_cua_tb_chua_dk' => 'Tong So Luot Truy Cap Cua Tb Chua Dk',
			'tong_so_luot_truy_cap_cua_tb_dk' => 'Tong So Luot Truy Cap Cua Tb Dk',
			'tong_so_tb_truy_cap' => 'Tong So Tb Truy Cap',
			'tong_so_luot_truy_cap' => 'Tong So Luot Truy Cap',
			'so_tb_dk_qua_sms' => 'So Tb Dk Qua Sms',
			'so_tb_dk_qua_wap' => 'So Tb Dk Qua Wap',
			'so_tb_huy_qua_sms' => 'So Tb Huy Qua Sms',
			'so_tb_huy_qua_wap' => 'So Tb Huy Qua Wap',
			'so_tb_bi_huy_phim30' => 'So Tb Bi Huy Phim30',
			'so_tb_bi_huy_phim7' => 'So Tb Bi Huy Phim7',
			'so_tb_bi_huy_phim' => 'So Tb Bi Huy Phim',
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
		$criteria->compare('create_date',$this->create_date,true);
		$criteria->compare('tong_so_tb_dang_kich_hoat',$this->tong_so_tb_dang_kich_hoat);
		$criteria->compare('tong_so_tb_bi_huy',$this->tong_so_tb_bi_huy);
		$criteria->compare('so_tb_huy_phim30',$this->so_tb_huy_phim30);
		$criteria->compare('so_tb_huy_phim7',$this->so_tb_huy_phim7);
		$criteria->compare('so_tb_huy_phim',$this->so_tb_huy_phim);
		$criteria->compare('tong_so_tb_huy_dv',$this->tong_so_tb_huy_dv);
		$criteria->compare('so_tb_gia_han_tc_phim30',$this->so_tb_gia_han_tc_phim30);
		$criteria->compare('so_tb_gia_han_tc_phim7',$this->so_tb_gia_han_tc_phim7);
		$criteria->compare('so_tb_gia_han_tc_phim',$this->so_tb_gia_han_tc_phim);
		$criteria->compare('tong_so_tb_gia_han_tc',$this->tong_so_tb_gia_han_tc);
		$criteria->compare('so_tb_truy_thu_tc_phim30',$this->so_tb_truy_thu_tc_phim30);
		$criteria->compare('so_tb_truy_thu_tc_phim7',$this->so_tb_truy_thu_tc_phim7);
		$criteria->compare('so_tb_truy_thu_tc_phim',$this->so_tb_truy_thu_tc_phim);
		$criteria->compare('tong_so_tb_truy_thu_tc',$this->tong_so_tb_truy_thu_tc);
		$criteria->compare('so_tb_can_truy_thu_phim30',$this->so_tb_can_truy_thu_phim30);
		$criteria->compare('so_tb_can_truy_thu_phim7',$this->so_tb_can_truy_thu_phim7);
		$criteria->compare('so_tb_can_truy_thu_phim',$this->so_tb_can_truy_thu_phim);
		$criteria->compare('tong_so_tb_can_truy_thu',$this->tong_so_tb_can_truy_thu);
		$criteria->compare('so_tb_can_gia_han_phim30',$this->so_tb_can_gia_han_phim30);
		$criteria->compare('so_tb_can_gia_han_phim7',$this->so_tb_can_gia_han_phim7);
		$criteria->compare('so_tb_can_gia_han_phim',$this->so_tb_can_gia_han_phim);
		$criteria->compare('tong_so_tb_can_gia_han',$this->tong_so_tb_can_gia_han);
		$criteria->compare('so_tb_luy_ke_phim30',$this->so_tb_luy_ke_phim30);
		$criteria->compare('so_tb_luy_ke_phim7',$this->so_tb_luy_ke_phim7);
		$criteria->compare('so_tb_luy_ke_phim',$this->so_tb_luy_ke_phim);
		$criteria->compare('tong_so_tb_luy_ke',$this->tong_so_tb_luy_ke);
		$criteria->compare('so_luot_dk_tb_phim30',$this->so_luot_dk_tb_phim30);
		$criteria->compare('so_luot_dk_tb_phim7',$this->so_luot_dk_tb_phim7);
		$criteria->compare('so_luot_dk_tb_phim',$this->so_luot_dk_tb_phim);
		$criteria->compare('so_luot_dk_tb_moi',$this->so_luot_dk_tb_moi);
		$criteria->compare('tong_so_tb_huy_dv_trong_ngay',$this->tong_so_tb_huy_dv_trong_ngay);
		$criteria->compare('tong_so_tb_dk_moi_trong_ngay',$this->tong_so_tb_dk_moi_trong_ngay);
		$criteria->compare('tong_so_tb_phat_sinh_cuoc',$this->tong_so_tb_phat_sinh_cuoc);
		$criteria->compare('tong_doanh_thu_dich_vu',$this->tong_doanh_thu_dich_vu);
		$criteria->compare('doanh_thu_truy_thu_phim30',$this->doanh_thu_truy_thu_phim30);
		$criteria->compare('doanh_thu_truy_thu_phim7',$this->doanh_thu_truy_thu_phim7);
		$criteria->compare('doanh_thu_truy_thu_phim',$this->doanh_thu_truy_thu_phim);
		$criteria->compare('tong_doanh_thu_truy_thu',$this->tong_doanh_thu_truy_thu);
		$criteria->compare('doanh_thu_gia_han_phim30',$this->doanh_thu_gia_han_phim30);
		$criteria->compare('doanh_thu_gia_han_phim7',$this->doanh_thu_gia_han_phim7);
		$criteria->compare('doanh_thu_gia_han_phim',$this->doanh_thu_gia_han_phim);
		$criteria->compare('tong_doanh_thu_gia_han',$this->tong_doanh_thu_gia_han);
		$criteria->compare('doanh_thu_dk_phim30',$this->doanh_thu_dk_phim30);
		$criteria->compare('doanh_thu_dk_phim7',$this->doanh_thu_dk_phim7);
		$criteria->compare('doanh_thu_dk_phim',$this->doanh_thu_dk_phim);
		$criteria->compare('tong_doanh_thu_dk_moi',$this->tong_doanh_thu_dk_moi);
		$criteria->compare('doanh_thu_gui_tang_goi_cuoc',$this->doanh_thu_gui_tang_goi_cuoc);
		$criteria->compare('doanh_thu_gui_tang_phim',$this->doanh_thu_gui_tang_phim);
		$criteria->compare('doanh_thu_download',$this->doanh_thu_download);
		$criteria->compare('doanh_thu_xem',$this->doanh_thu_xem);
		$criteria->compare('so_tb_gui_tang_goi_cuoc',$this->so_tb_gui_tang_goi_cuoc);
		$criteria->compare('so_tb_gui_tang_phim',$this->so_tb_gui_tang_phim);
		$criteria->compare('so_luot_gui_tang_goi_cuoc',$this->so_luot_gui_tang_goi_cuoc);
		$criteria->compare('so_luot_gui_tang_phim',$this->so_luot_gui_tang_phim);
		$criteria->compare('so_tb_xem_mat_phi',$this->so_tb_xem_mat_phi);
		$criteria->compare('so_luot_xem_mat_phi',$this->so_luot_xem_mat_phi);
		$criteria->compare('so_tb_chua_dk_xem_free',$this->so_tb_chua_dk_xem_free);
		$criteria->compare('so_luot_xem_free_cua_tb_chua_dk',$this->so_luot_xem_free_cua_tb_chua_dk);
		$criteria->compare('so_tb_dk_xem_free',$this->so_tb_dk_xem_free);
		$criteria->compare('so_tb_no_cuoc_xem_free',$this->so_tb_no_cuoc_xem_free);
		$criteria->compare('so_luot_xem_free_cua_tb_no_cuoc',$this->so_luot_xem_free_cua_tb_no_cuoc);
		$criteria->compare('so_luot_xem_free',$this->so_luot_xem_free);
		$criteria->compare('so_luot_xem',$this->so_luot_xem);
		$criteria->compare('tong_so_tb_chua_dk_truy_cap',$this->tong_so_tb_chua_dk_truy_cap);
		$criteria->compare('tong_so_tb_dk_truy_cap',$this->tong_so_tb_dk_truy_cap);
		$criteria->compare('tong_so_luot_truy_cap_cua_tb_chua_dk',$this->tong_so_luot_truy_cap_cua_tb_chua_dk);
		$criteria->compare('tong_so_luot_truy_cap_cua_tb_dk',$this->tong_so_luot_truy_cap_cua_tb_dk);
		$criteria->compare('tong_so_tb_truy_cap',$this->tong_so_tb_truy_cap);
		$criteria->compare('tong_so_luot_truy_cap',$this->tong_so_luot_truy_cap);
		$criteria->compare('so_tb_dk_qua_sms',$this->so_tb_dk_qua_sms);
		$criteria->compare('so_tb_dk_qua_wap',$this->so_tb_dk_qua_wap);
		$criteria->compare('so_tb_huy_qua_sms',$this->so_tb_huy_qua_sms);
		$criteria->compare('so_tb_huy_qua_wap',$this->so_tb_huy_qua_wap);
		$criteria->compare('so_tb_bi_huy_phim30',$this->so_tb_bi_huy_phim30);
		$criteria->compare('so_tb_bi_huy_phim7',$this->so_tb_bi_huy_phim7);
		$criteria->compare('so_tb_bi_huy_phim',$this->so_tb_bi_huy_phim);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
	public static function getReport_tk_thue_bao($startDate, $endDate){
		$startDate = CUtils::getStartDate($startDate);
		$endDate = CUtils::getEndDate($endDate);
		$sqlString ="select * from total_report where create_date between '$startDate' AND '$endDate' ";
		$totalReport = TotalReport::model()->findAllBySql($sqlString, array());
		return $totalReport;
	}
}