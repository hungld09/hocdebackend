<?php $this->renderPartial('_use_service_menu'); ?>
<?php $this->renderPartial('_filter_menu', array('error' => isset($error) ? $error : '')); ?>
<table class="tbl_style">
    <thead>
    <tr>
        <th>Thời gian bắt đầu</th>
        <th>Thời gian kết thúc</th>
        <th>Gói cước</th>
        <th>Thao tác KH</th>
        <th>Hệ thống phản hồi</th>
        <th>Kênh</th>
        <th>Đầu số DV</th>
        <th>Thời điểm</th>
        <th>Xem phim</th>
    </tr>
    </thead>
    <tbody>
    <?php
    if (isset($search)):
    foreach ($model as $m):
        ?>
        <tr>
            <td align='center'><span><?php $date = new DateTime($m->create_date); echo $date->format('d/m/Y H:i:s') ?></span></td>
            <td align='center'><span>
                    <?php
                    $sub_day = $m->service_id == 4 ? 1 : $m->service_id = 5 ? 7 : 30;
                    $date->modify("+ $sub_day day");
                    echo $date->format('d/m/Y H:i:s')
                    ?>
                </span></td>
            <td align='center'><span><?php echo $m->service_id == 4 ? 'NGÀY' : ($m->service_id == 5 ? 'TUẦN' : ($m->service_id == 6 ? 'VTV' : 'PHIM')) ?></span></td>
            <td align='center'><span>
                    <?php
                    switch ($m->using_type){
                        case 0:
                            echo 'Mua dịch vụ';
                            break;
                        case 1:
                            echo 'Mua để xem';
                            break;
                        case 2:
                            echo 'Mua để download';
                            break;
                        case 3:
                            echo 'Mua để tặng';
                            break;
                        default:
                            break;
                    }
                    ?>
            </span></td>
            <td align='center'><span><?php echo $m->status == 1 ? 'Thành công' : 'Thất bại' ?></span></td>
            <td align='center'><span><?php echo $m->channel_type ?></span></td>
            <td align='center'><span>1579</span></td>
            <td align='center'><span>1579</span></td>
            <td align='center'><span>1579</span></td>
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