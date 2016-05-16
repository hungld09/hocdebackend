<?php 
// $this->breadcrumbs = array(
// 	'Rights'=>Rights::getBaseUrl(),
// 	Rights::t('core', 'Assignments')=>array('assignment/view'),
// 	$model->getName(),
// );
?>

<div id="userAssignments">

	<h2>
		<?php
			if(User::getRoleLevel(Yii::app()->user->id) > 2) { 
				echo Rights::t('core', 'Phân quyền cho ":username" (mỗi user chỉ có 1 vai trò)', array(
					':username'=>$model->getName()));
			}
			else {
				echo Rights::t('core', 'Phân quyền cho ":username"', array(
					':username'=>$model->getName()));
			}
		 ?>
	</h2>

	<div class="assignments span-12 first">

		<?php $this->widget('zii.widgets.grid.CGridView', array(
				'dataProvider'=>$dataProvider,
				'template'=>'{items}',
				'hideHeader'=>true,
				'emptyText'=>Rights::t('core', 'This user has not been assigned any items.'),
				'htmlOptions'=>array('class'=>'grid-view user-assignment-table mini'),
				'columns'=>array(
						array(
								'name'=>'name',
								'header'=>Rights::t('core', 'Name'),
								'type'=>'raw',
								'htmlOptions'=>array('class'=>'name-column'),
								'value'=>'$data->getNameText()',
						),
						//     			array(
						//     				'name'=>'type',
						//     				'header'=>Rights::t('core', 'Type'),
						//     				'type'=>'raw',
						//     				'htmlOptions'=>array('class'=>'type-column'),
						//     				'value'=>'$data->getTypeText()',
						//     			),
						array(
    				'header'=>'&nbsp;',
    				'type'=>'raw',
    				'htmlOptions'=>array('class'=>'actions-column'),
    				'value'=>'$data->getRevokeAssignmentLink()',
    			),
				)
		)); ?>

	</div>

	<div class="add-assignment span-11 last">

		<h3>
			<?php echo Rights::t('core', 'Vai trò'); ?>
		</h3>

		<?php if( $formModel!==null ): ?>

		<div class="form">

			<?php 
			// 					print_r($assignSelectOptions);
				$assignSelectOptions1 = array();
				/*check DEPLOY_STATUS*/
				if(DEPLOY_STATUS == 1) { //neu chay that == 1 thi chi show Roles trong dropdownlist (tuong ung voi record co type = 2 trong table AuthItem). Ngoai ra chi hien thi cac role co level thap hon
					$userRole = User::getRole($model->id);
					if($userRole !== NULL) { //doan nay de xu ly: moi user chi co 1 role. Da co role roi thi ko co item nao trong danh sach role, phai revoke di moi assign dc
// 						print_r($userRole->level); exit;
					}
					else {
						$currentLevel = User::getRoleLevel(Yii::app()->user->id);
						// 						print_r($assignSelectOptions); exit;
						foreach($assignSelectOptions as $option) {
							if(array_key_exists('Roles', $assignSelectOptions)) {
								$arrRole = $assignSelectOptions['Roles'];
								foreach($arrRole as $key=>$roleDesc) {
// 									print_r($roleDesc); exit;
									$role = AuthItem::model()->findByAttributes(array("description" => $roleDesc));
									if($role->level < $currentLevel) {
										$assignSelectOptions1[$key] = $roleDesc;
									}
								}
							}
							break; //chi lay phan Roles thoi. Phan Tasks, Operation chi dung khi developing
						}
					}
				}
				else {
					$assignSelectOptions1 = $assignSelectOptions;
				}
				$this->renderPartial('_form', array(
					'model'=>$formModel,
					'itemnameSelectOptions'=>$assignSelectOptions1,
					'deploy_status' => $deploy_status,
				));
				?>

		</div>

		<?php else: ?>

		<p class="info">
			<?php echo Rights::t('core', 'No assignments available to be assigned to this user.'); ?>

			<?php endif; ?>
	
	</div>

</div>
