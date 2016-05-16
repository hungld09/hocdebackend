<?php $this->renderPartial('_use_service_menu'); ?>
<?php $this->renderPartial('_filter_menu', array('error' => isset($error) ? $error : '')); ?>

<table class='tbl_style'>
    <thead>
    <tr>
        <th>Thời gian giao dịch</th>
        <th>Loại giao dịch</th>
        <th>Gói cước</th>
        <th>Tình trạng</th>
        <th>Kênh</th>
        <th>Ứng dụng</th>
        <th>Tài khoản/CT</th>
        <th>User IP</th>
        <th>Cước phí</th>
    </tr>
    </thead>
    <?php
    if (isset($search)):
    foreach ($model as $m):
        ?>
        <tr>
            <td align='center'><span><?php $date = new DateTime($m->create_date); echo $date->format('d/m/Y H:i:s') ?></span></td>
            <td align='center'><span><?php echo $m->purchase_type == 1 ? 'Đăng ký' : 'Gia hạn' ?></span></td>
            <td align='center'><span><?php echo $m->service_id == 4 ? 'NGÀY' : ($m->service_id == 5 ? 'TUẦN' : ($m->service_id == 6 ? 'VTV' : 'PHIM')) ?></span></td>
            <td align='center'><span><?php echo $m->status ==  1 ? 'Thành công' : 'Thất bại' ?></span></td>
            <td align='center'><span><?php echo $m->channel_type ?></span></td>
<!--            <td align='center'><span>--><?php //echo $m->event_id ?><!--</span></td>-->
            <td align='center'><span><?php echo $m->getApplication() ?></span></td>
            <td align='center'><span><?php echo $m->getVnpUsername() ?></span></td>
            <td align='center'><span><?php echo $m->getVnpUserIp() ?></span></td>
            <td align='right'><span><?php echo number_format($m->cost) ?></span></td>
        </tr>
    <?php
    endforeach;
    ?>

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