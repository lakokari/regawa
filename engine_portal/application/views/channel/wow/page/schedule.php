<script src="<?php echo config_item('assets_wow'); ?>js/jquery.swipeplanes-1.2.js"></script>
<div class="content-container">
    <style>
        /*schedule style*/
        .schedule-wrap {
            width: 900px;
        }

        .schedule-wrap .left-col {
            width: 200px;
            float: left;
        }

        .schedule-wrap .right-col {
            width: 675px;
            float: left;

            position: relative;
        }

        .title-wrap-cell {
            margin-bottom: 15px;
        }
        .title-wrap {
            margin-top: 65px;
            font-size: 16px;
        }
        .title-cell {
            display: block;
            color: #fff;
            font-weight: bold;                    
        }

        .title-schedule-cell {

        }

        .table-bg {

        }
        .month-title {
            float: left;
            font-size: 23px;
            font-weight: bold;
        }
        .month-title-wrap {
            width: 100%;
            height: 30px;
        }
        .month-week-wrap {
            border-top: 1px solid #F2F3FF;
            height: 35px;
        }

        .month-week-wrap li {
            list-style-type: none;
            float: left;
            text-align: center;
        }
        .col-tb-bg {
            float: left;
            border-right: 1px solid #F2F3FF;
        }
        .col-tb-bg:first-child {
            border-left: none;
        } 
        .col-tb-bg:last-child {
            border-right: none;
        }                 
        .square-line {
            position: absolute;
            width: 100%;
            height: auto;
            top: 70px;
        }
        .row-chart {
            display: block;
            height: 40px;
        }
        .chart-line-empty, .chart-line {
            height: 20px;
            float: left;
        }
        .chart-line {
            background-color: red;
            
        }
        .left-sidebar {
            width: 365px;
        }
    </style>
    <div class="left-sidebar">
	<a href="http://www.uzone.co.id/wow/channel/project?event=3">
        <img style="display: block;margin: auto;" src="<?php echo config_item('assets_wow');?>css/img/wow-10-second-banner-new.png" width="250px">
	</a>
    </div>            
    <div class="right-sidebar">
        <div class="schedule-wrap">
            <div class="left-col">
                <div class="title-wrap">
                    <?php
                    $data_schedule = $this->schedule->getDataDummy();
                    foreach ($data_schedule as $data) {
                        ?>
                        <div class="title-wrap-cell">
                            <span class="title-cell"><?php echo $data['title']; ?></span>
                            <?php 
                            if ($data['end_date'] == $data['start_date'])  {
                                echo '<span class="title-schedule-cell">'.date('d M Y', strtotime($data['start_date'])).'</span>';
                            } else {
                                echo '<span class="title-schedule-cell">'.date('d M', strtotime($data['start_date'])).' - '.date('d M Y', strtotime($data['end_date'])).'</span>';
                            }
                               
                            ?>
                            
                        </div>
                        <?php
                    }
                    ?>
                </div>
            </div>
            <div class="right-col">
                <div class="month-title-wrap">
                    <?php
                    $jml = $this->schedule->getMonthLength();
                    $monthName = $this->schedule->tableData('header');
                    $colsWidth = $this->schedule->tableData('col-month');

                    for ($i = 0; $i < $jml; $i++) {
                        ?>                        

                        <div class="month-title" style="width:<?php echo $colsWidth[$i]; ?>px;">
                            <?php echo strtoupper($monthName[$i]); ?>
                        </div>    

                    <?php } ?>
                </div>     
                <div class="table-bg">

                    <?php
                    for ($i = 0; $i < $jml; $i++) {
                        ?>
                        <div class="col-tb-bg" style="width:<?php echo $colsWidth[$i]; ?>px;">
                            <div class="month-week-wrap">
                                <?php $this->schedule->renderWeekHeader(); ?>
                            </div>
                            <?php $this->schedule->renderTableSpace(); ?>
                        </div>    
                        <?php
                    }
                    ?> 

                </div>
                <div class="square-line">
                    <?php
                    $jmlData = $this->schedule->tableData('jml-data');
                    for ($i = 0; $i < $jmlData; $i++) {
                        $this->schedule->renderChart($i);
                    }
                    ?> 
                </div>                    
            </div>                
        </div>
    </div>
    <?php
    if (isset($page))
        $this->load->view('channel/wow/page/footer'); ?>