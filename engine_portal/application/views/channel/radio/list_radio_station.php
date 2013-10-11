<style>
    .link_radio_station a {
        color : #d31821;
        text-decoration: none;
    }
    .link_radio_station a:hover {
        color : #d31821;
        text-decoration: underline;
    }
</style>
<br />
<div class="uz-title-container">Popular Local Radio</div>
<div id="myslider1" class="myslider1">
    <div id="myslider-content">
        <?php
        foreach ($listRadio_all as $radio) {
            echo "<div class='slide1 container-item'>";
            if ($radio->radio_image != "" AND $radio->radio_image != null AND $radio->radio_image != 'logo_mqfm_radio.png') {
                echo "<a title='Click to Live Streaming' onclick=\"loadRODPlayer('LIVE STREAMING > " . $radio->radio_name . "','" . $radio->live_stream . "','" . config_item('image_url'). $radio->radio_image . "')\" href='javascript:void(0);' class='album-name'>";
                echo "<img src='" .$radio->radio_image . "' class='rounded' width='80' height='80'/></a> ";
            } else {
                echo "<img src='" . config_item('assets_url') . "css/img/icon_radio.jpg' class='rounded' width='120' height='120'/> ";
            }
            echo"<br /><div  class='link_radio_station'><a title='Click to Live Streaming' onclick=\"loadRODPlayer('LIVE STREAMING > " . $radio->radio_name . "','" . $radio->live_stream . "','" . $radio->radio_image . "')\" href='javascript:void(0);' class='album-name'>" . $radio->radio_name . "</a></div></div>";
        }
        ?>

    </div>
</div>