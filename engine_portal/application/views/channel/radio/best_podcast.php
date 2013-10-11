<style>
    #best_podcast_barat {display : none;}
</style>

<div style="font-size: 18px; width: auto; height: auto; padding: 5px;">
    <a href="javascript:bp_indo_menu();" style="font-weight : bold;" id="bp_indo_menu">Indonesia</a> | 
    <a href="javascript:bp_barat_menu();" style="" id="bp_barat_menu">Barat</a>
</div>

<div class="rod_list_scrol" style="border : none; height: 290px;">
    <div id="best_podcast_indo">
            <?php
            foreach ($bestpodcast_indonesia as $bestpodcast_indonesia) {
                ?>
                <div class="container-rounded-list-rod-playthumb">
                <table>
                <tr>
                    <td valign=top align=center width=10%>
                        <div class="thumb_rod_container">
                            <div class="thumb_image">
                                <img src="<?php echo $bestpodcast_indonesia->attachment; ?>">
                            </div>
                            <a href="javascript:void(0);" onclick='javascript:loadRODPlayer("Radio On Demand > Best Podcast Indonesia > <?php echo cleanString($bestpodcast_indonesia->title); ?>","<?php echo $bestpodcast_indonesia->file; ?>","<?php echo $bestpodcast_indonesia->attachment; ?>");'>
                                <div class="icon_play_rod"></div>
                            </a>
                        </div>
                    </td>
                    <td valign=top width=90%>
                        <div class="title_rod_list"><a href="javascript:void(0);" onclick='javascript:loadRODPlayer("Radio On Demand > Best Podcast Indonesia > <?php echo cleanString($bestpodcast_indonesia->title); ?>","<?php echo $bestpodcast_indonesia->file; ?>","<?php echo $bestpodcast_indonesia->attachment; ?>");'><?php echo $bestpodcast_indonesia->title; ?></a></div>
                        <p style="font-size: 9px; margin-left: 10px;"><?php echo number_format($bestpodcast_indonesia->play_count, 0, ',', '.'); ?> played</p>
                    </td>
                </tr>
                </table>
                </div>
                <?php
            }
            ?>
        
    </div>
    <div id="best_podcast_barat">
        <?php
        foreach ($bestpodcast_barat as $bestpodcast_barat) {
            ?>
            <div class="container-rounded-list-rod-playthumb">
            <table>
            <tr>
                <td valign=top align=center width=10%>
                    <div class="thumb_rod_container">
                            <div class="thumb_image">
                                <img src="<?php echo $bestpodcast_barat->attachment; ?>">
                            </div>
                            <a href="javascript:void(0);" onclick='javascript:loadRODPlayer("Radio On Demand > Best Podcast Indonesia > <?php echo cleanString($bestpodcast_barat->title); ?>","<?php echo $bestpodcast_barat->file; ?>","<?php echo $bestpodcast_barat->attachment; ?>");'>
                                <div class="icon_play_rod"></div>
                            </a>
                        </div>
                </td>
                <td valign=top width=90%>
                    <div class="title_rod_list"><a href="javascript:void(0);" onclick='javascript:loadRODPlayer("Radio On Demand > Best Podcast Indonesia > <?php echo cleanString($bestpodcast_barat->title); ?>","<?php echo $bestpodcast_barat->file; ?>","<?php echo $bestpodcast_barat->attachment; ?>");'><?php echo $bestpodcast_barat->title; ?></a></div>
                    <p style="font-size: 9px; margin-left: 10px;"><?php echo number_format($bestpodcast_barat->play_count, 0, ',', '.'); ?> played</p>
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
    function bp_indo_menu() {
        $('#bp_indo_menu').attr("style", "font-weight : bold;");
        $('#bp_barat_menu').attr("style", "font-weight : normal;");
        $('#best_podcast_indo').show();
        $('#best_podcast_barat').hide();
    }
    function bp_barat_menu() {
        $('#bp_barat_menu').attr("style", "font-weight : bold;");
        $('#bp_indo_menu').attr("style", "font-weight : normal;");
        $('#best_podcast_barat').show();
        $('#best_podcast_indo').hide();
    }
</script>