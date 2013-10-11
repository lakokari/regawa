<style>
    #click {
        width: 48px;
    }
    .cs-style-4 figcaption {
        z-index: 99;
    }
    .caption-thumb {
        position: absolute;
        bottom: 0px;
        left: 0px;
        z-index: 1000;
        width: 150px;
        height: 30px;
        background: rgba(0,0,0,0.6);
        font-size: 25px;
        color: #fff;
        text-align: center;
    }
    
    /* untuk remove effect hover image */
    .no-touch .cs-style-4 figure:hover img,
    .cs-style-4 figure.cs-hover img {
        -webkit-transform: translateX(0%);
        -moz-transform: translateX(0%);
        -ms-transform: translateX(0%);
        transform: translateX(0%);
    }
    
    .grid figure.persegi img {
        max-width: 100%;
        width: auto;
        height: 112px;
    }
    .grid figure.portrait img {
        max-width: 100%;
        width: auto;
        height: 112px;
    }
    .grid figure.uzone img {
        max-width: 100%;
        width: auto;
        height: 118px;
    }
    
    .grid li {
        display: inline-block;
        width: 150px;
        margin: 0;
        padding: 5px;
        text-align: left;
        position: relative;
        background: #fff;
    }
</style>

<div id='panel'>
    <ul class="grid cs-style-4">
        <li>
            <figure class="persegi">
                <div><a href="<?php echo base_url(); ?>music/channel">
                        <div class="caption-thumb">Music</div>
                        <table align="center">
                            <tr>
                                <td>
                                    <div class="cycle-slideshow" id="rand-music">
                                        <?php foreach($random_images['music'] as $image): ?>
                                        <img src="<?php echo $image;?>" alt="img05" />
                                        <?php endforeach; ?>
                                    </div>
                                </td>
                            </tr>
                        </table></a></div>
            </figure>
        </li>
        <li>
            <figure class="persegi">
                <div><a href="<?php echo base_url(); ?>radio/channel">
                        <div class="caption-thumb">Radio</div>
                        <table align="center">
                            <tr>
                                <td>
                                    <div class="cycle-slideshow" id="rand-radio">
                                        <?php foreach($random_images['radio'] as $image): ?>
                                        <img src="<?php echo $image;?>" alt="img06" />
                                        <?php endforeach; ?>
                                    </div>
                                </td>
                            </tr>
                        </table></a></div> 
                                               
            </figure>
        </li>
        <li>
            <figure class="portrait">
                <div><a href="<?php echo base_url(); ?>movie/channel">
                        <div class="caption-thumb">Movie</div>
                        <table align="center">
                            <tr>
                                <td>
                                    <div class="cycle-slideshow" id="rand-movie">
                                        <?php foreach($random_images['movie'] as $image): ?>
                                        <img src="<?php echo $image;?>" alt="img02" />
                                        <?php endforeach; ?>
                                    </div>
                                </td>
                            </tr>
                        </table></a></div>
            </figure>
        </li>
        <li>
            <figure class="persegi">
                <div><a href="<?php echo base_url(); ?>games/channel">
                        <div class="caption-thumb">Games</div>
                        <table align="center">
                            <tr>
                                <td>
                                    <div class="cycle-slideshow" id="rand-games">
                                        <?php foreach($random_images['games'] as $image): ?>
                                        <img src="<?php echo $image;?>" alt="img03" />
                                        <?php endforeach; ?>
                                    </div>
                                </td>
                            </tr>
                        </table></a></div>
            </figure>
        </li>
        <li>
            <figure class="uzone">
                <div><a href="<?php echo base_url(); ?>">
                        <img src="<?php echo config_item('image_url'); ?>uzone.png" alt="img01"></a></div>
            </figure>
        </li>
        <li>
            <figure class="persegi">
                <div><a href="<?php echo base_url(); ?>tv/channel">
                        <div class="caption-thumb">TV</div>
                        <table align="center">
                            <tr>
                                <td>
                                    <div class="cycle-slideshow" id="rand-tv">
                                        <?php foreach($random_images['tv'] as $image): ?>
                                        <img src="<?php echo $image;?>" alt="img04" />
                                        <?php endforeach; ?>
                                    </div>
                                </td>
                            </tr>
                        </table></a></div>
            </figure>
        </li>
        <li>
            <figure class="portrait">
                <div><a href="<?php echo base_url(); ?>book/channel">
                        <div class="caption-thumb">Book</div>
                        <table align="center">
                            <tr>
                                <td>
                                    <div class="cycle-slideshow" id="rand-book">
                                        <?php foreach($random_images['book'] as $image): ?>
                                        <img src="<?php echo $image;?>" alt="img02" />
                                        <?php endforeach; ?>
                                    </div>
                                </td>
                            </tr>
                       </table></a></div>
            </figure>
        </li>
        <li>
            <figure class="persegi">
                <div><a href="<?php echo base_url(); ?>apps/channel">
                        <div class="caption-thumb">Apps</div>
                        <table align="center">
                            <tr>
                                <td>
                                    <div class="cycle-slideshow" id="rand-apps">
                                        <?php foreach($random_images['apps'] as $image): ?>
                                        <img src="<?php echo $image;?>" alt="img06" />
                                        <?php endforeach; ?>
                                    </div>
                                </td>
                            </tr>
                       </table>
                        </a></div>
            </figure>
        </li>

        <li>
            <figure class="persegi">
                <div><a href="<?php echo base_url(); ?>wow/channel">
                        <div class="caption-thumb">WOW</div>
                        <table align="center">
                            <tr>
                                <td>
                                    <div class="cycle-slideshow" id="rand-wow">
                                        <?php foreach($random_images['wow'] as $image): ?>
                                        <img src="<?php echo $image;?>" alt="img03" />
                                        <?php endforeach; ?>
                                    </div>
                                </td>
                            </tr>
                       </table>
                    </a>
                </div>
            </figure>
        </li>
    </ul>
</div>
<div id='click'><img src="<?php echo config_item('assets_url'); ?>img/button-click-here-home.png"></div>




<!-- load image rotator -->
<script type="text/javascript" src="<?php echo config_item('assets_url');?>js/jquery.cycle2.min.js" />
<script>
    $(document).ready(function(){
        $('#random-music').cycle();
        $('#random-movie').cycle();
        $('#random-tv').cycle();
        $('#random-book').cycle();
        $('#random-apps').cycle();
        $('#random-games').cycle();
        $('#random-wow').cycle();
        $('#random-radio').cycle();
    });
</script>
