<div class="view">

	<b><?php echo CHtml::encode($data->getAttributeLabel('id')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->id),array('view','id'=>$data->id)); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('code_name')); ?>:</b>
	<?php echo CHtml::encode($data->code_name); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('display_name')); ?>:</b>
	<?php echo CHtml::encode($data->display_name); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('display_name_ascii')); ?>:</b>
	<?php echo CHtml::encode($data->display_name_ascii); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('original_title')); ?>:</b>
	<?php echo CHtml::encode($data->original_title); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('tags')); ?>:</b>
	<?php echo CHtml::encode($data->tags); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('actors')); ?>:</b>
	<?php echo CHtml::encode($data->actors); ?>
	<br />

	<?php /*
	<b><?php echo CHtml::encode($data->getAttributeLabel('director')); ?>:</b>
	<?php echo CHtml::encode($data->director); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('release_date')); ?>:</b>
	<?php echo CHtml::encode($data->release_date); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('imdb_url')); ?>:</b>
	<?php echo CHtml::encode($data->imdb_url); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('imdb_rating')); ?>:</b>
	<?php echo CHtml::encode($data->imdb_rating); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('short_description')); ?>:</b>
	<?php echo CHtml::encode($data->short_description); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('description')); ?>:</b>
	<?php echo CHtml::encode($data->description); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('view_count')); ?>:</b>
	<?php echo CHtml::encode($data->view_count); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('like_count')); ?>:</b>
	<?php echo CHtml::encode($data->like_count); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('dislike_count')); ?>:</b>
	<?php echo CHtml::encode($data->dislike_count); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('rating')); ?>:</b>
	<?php echo CHtml::encode($data->rating); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('rating_count')); ?>:</b>
	<?php echo CHtml::encode($data->rating_count); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('comment_count')); ?>:</b>
	<?php echo CHtml::encode($data->comment_count); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('favorite_count')); ?>:</b>
	<?php echo CHtml::encode($data->favorite_count); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('is_series')); ?>:</b>
	<?php echo CHtml::encode($data->is_series); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('episode_count')); ?>:</b>
	<?php echo CHtml::encode($data->episode_count); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('duration')); ?>:</b>
	<?php echo CHtml::encode($data->duration); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('is_multibitrate')); ?>:</b>
	<?php echo CHtml::encode($data->is_multibitrate); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('vod_stream_count')); ?>:</b>
	<?php echo CHtml::encode($data->vod_stream_count); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('is_free')); ?>:</b>
	<?php echo CHtml::encode($data->is_free); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('price')); ?>:</b>
	<?php echo CHtml::encode($data->price); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('price_download')); ?>:</b>
	<?php echo CHtml::encode($data->price_download); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('price_gift')); ?>:</b>
	<?php echo CHtml::encode($data->price_gift); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('image_count')); ?>:</b>
	<?php echo CHtml::encode($data->image_count); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('expiry_date')); ?>:</b>
	<?php echo CHtml::encode($data->expiry_date); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('status')); ?>:</b>
	<?php echo CHtml::encode($data->status); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('create_date')); ?>:</b>
	<?php echo CHtml::encode($data->create_date); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('modify_date')); ?>:</b>
	<?php echo CHtml::encode($data->modify_date); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('create_user_id')); ?>:</b>
	<?php echo CHtml::encode($data->create_user_id); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('modify_user_id')); ?>:</b>
	<?php echo CHtml::encode($data->modify_user_id); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('honor')); ?>:</b>
	<?php echo CHtml::encode($data->honor); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('content_provider_id')); ?>:</b>
	<?php echo CHtml::encode($data->content_provider_id); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('using_duration')); ?>:</b>
	<?php echo CHtml::encode($data->using_duration); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('approve_date')); ?>:</b>
	<?php echo CHtml::encode($data->approve_date); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('order_number')); ?>:</b>
	<?php echo CHtml::encode($data->order_number); ?>
	<br />

	*/ ?>

</div>