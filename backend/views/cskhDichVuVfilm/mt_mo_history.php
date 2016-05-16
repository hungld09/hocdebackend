<?php $this->renderPartial('_use_service_menu'); ?>
<?php $this->renderPartial('_filter_menu', array('error' => isset($error) ? $error : '')); ?>
<table class="tbl_style">
    <thead>
    <tr>
        <th>Thời gian hệ thống nhận MO</th>
        <th>Nội dung MO</th>
        <th>Trạng thái</th>
        <th>Cước phí MO</th>
        <th>Đầu số nhận MO</th>
        <th>Thời gian gửi MT</th>
        <th>Nội dung MT</th>
        <th>Gói cước</th>
        <th>Trạng thái</th>
        <th>Cước phí MT</th>
        <th>Đầu số gửi MT</th>
    </tr>
    </thead>
    <tbody>
    <?php
    if (isset($search)):
    foreach ($model as $m):
        ?>
        <tr>
            <td align='center'><span><?php $received_time = new DateTime($m->received_time); echo $m->type == 'MO' ? $received_time->format('d/m/Y H:i:s') : '' ?></span></td>
            <td align='center'><span><?php echo $m->type == 'MO' ? $m->message : '' ?></span></td>
            <td align='center'><span><?php echo $m->type == 'MO' ? $m->mo_status : '' ?></span></td>
            <td align='center'><span></span></td>
            <td align='center'><span><?php echo $m->type == 'MO' ? 1579 : '' ?></span></td>
            <td align='center'><span><?php $sending_time = new DateTime($m->sending_time); echo $m->type == 'MT' ? $sending_time->format('d/m/Y H:i:s') : '' ?></span></td>
            <td align='center'><span><?php echo $m->type == 'MT' ? $m->message : '' ?></span></span></td>
            <td align='center'><span></span></td>
            <td align='center'><span><?php echo $m->type == 'MT' ? $m->mt_status : '' ?></span></td>
            <td align='center'><span></span></td>
            <td align='center'><span><?php echo $m->type == 'MT' ? 1579 : '' ?></span></span></td>
        </tr>
    <?php
    endforeach;
    ?>
    </tbody>
</table>

<div class="paginator" style="float: right">
    <?php
    // the pagination widget with some options to mess
    $this->widget('CLinkPager', array(
        'currentPage' => $pages->getCurrentPage(),
        'itemCount' => $item_count,
        'pageSize' => $page_size,
        'maxButtonCount' => 9,
        //'nextPageLabel'=>'My text >',
        'header' => '',
        'htmlOptions' => array('class' => ''),
    ));
    endif;
    ?>
    <div class="clearfix"></div>
</div>
<div class="clearfix"></div>