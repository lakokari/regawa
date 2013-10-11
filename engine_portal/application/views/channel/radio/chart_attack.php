<style>
    ul.chart_list {
        list-style-type: none;
        padding: 0px;
        margin: 0px;
        font-size: 11px;
    }
    ul.chart_list li{
        border-bottom : 1px solid #fff;
        padding-top : 2px;
        padding-bottom : 2px;
    }

    ul.chart_list li a{
        color : #151515;
        text-decoration : none;
    }

    ul.chart_list li a:hover{
        color : #151515;
        text-decoration : underline;
    }    
    #monthly_rod {display : none;}
</style>
<div style="font-size: 18px; width: auto; height: auto; padding: 5px;">
    <a href="javascript:ca_weekly_menu();" style="font-weight : bold;" id="ca_weekly_menu">Weekly Chart</a> | 
    <a href="javascript:ca_monthly_menu();" style="" id="ca_monthly_menu">Monthly Chart</a>
</div>

<div class="rod_list_scrol" style="border : none; height: 290px;">
    <div id="weekly_rod">
        <?php
            foreach ($chart_lastweeks as $chart_lastweek) {
                ?>
                <div class="container-rounded-list-rod-playthumb">
                <table>
                <tr>
                    <td valign=top align=center width=10%>
                        <div class="thumb_rod_container">
                            <div class="thumb_image">
                                <img src="<?php echo $chart_lastweek->attachment; ?>">
                            </div>
                            <a href="javascript:void(0);" onclick='javascript:loadRODPlayer("Radio On Demand > Weekly Chart > <?php echo cleanString($chart_lastweek->title); ?>","<?php echo $chart_lastweek->file; ?>","<?php echo $chart_lastweek->attachment; ?>");'>
                                <div class="icon_play_rod"></div>
                            </a>
                        </div>
                    </td>
                    <td valign=top width=90%>
                        <div class="title_rod_list"><a href="javascript:void(0);" onclick='javascript:loadRODPlayer("Radio On Demand > Weekly Chart > <?php echo cleanString($chart_lastweek->title); ?>","<?php echo $chart_lastweek->file; ?>","<?php echo $chart_lastweek->attachment; ?>");'><?php echo $chart_lastweek->title; ?></a></div>
                        <p style="font-size: 9px; margin-left: 10px;"><?php echo number_format($chart_lastweek->play_count, 0, ',', '.'); ?> played</p>
                    </td>
                </tr>
                </table>
                </div>
                <?php
            }
            ?>
    </div>
    <div id="monthly_rod">
        <?php
            foreach ($chart_lastmonths as $chart_lastmonth) {
                ?>
                <div class="container-rounded-list-rod-playthumb">
                <table>
                <tr>
                    <td valign=top align=center width=10%>
                        <div class="thumb_rod_container">
                            <div class="thumb_image">
                                <img src="<?php echo $chart_lastmonth->attachment; ?>">
                            </div>
                            <a href="javascript:void(0);" onclick='javascript:loadRODPlayer("Radio On Demand > Monthly Chart > <?php echo cleanString($chart_lastmonth->title); ?>","<?php echo $chart_lastmonth->file; ?>","<?php echo $chart_lastmonth->attachment; ?>");'>
                                <div class="icon_play_rod"></div>
                            </a>
                        </div>
                    </td>
                    <td valign=top width=90%>
                        <div class="title_rod_list"><a href="javascript:void(0);" onclick='javascript:loadRODPlayer("Radio On Demand > Weekly Chart > <?php echo cleanString($chart_lastmonth->title); ?>","<?php echo $chart_lastmonth->file; ?>","<?php echo $chart_lastmonth->attachment; ?>");'><?php echo $chart_lastmonth->title; ?></a></div>
                        <p style="font-size: 9px; margin-left: 10px;"><?php echo number_format($chart_lastmonth->play_count, 0, ',', '.'); ?> played</p>
                    </td>
                </tr>
                </table>
                </div>
                <?php
            }
            ?>
    </div>
    
</div>

<script>
    function ca_weekly_menu() {
        $('#ca_weekly_menu').attr("style", "font-weight : bold;");
        $('#ca_monthly_menu').attr("style", "font-weight : normal;");
        $('#weekly_rod').show();
        $('#monthly_rod').hide();
    }
    function ca_monthly_menu() {
        $('#ca_monthly_menu').attr("style", "font-weight : bold;");
        $('#ca_weekly_menu').attr("style", "font-weight : normal;");
        $('#monthly_rod').show();
        $('#weekly_rod').hide();
    }
</script>