<!-- slide panel item-->
<script src="<?php echo config_item('assets_wow'); ?>js/jquery.swipeplanes-1.2.js"></script>
<link href="<?php echo config_item('assets_wow'); ?>css/style_slide_item_twitter_feed.css" rel="stylesheet" type="text/css" />




<div class="content-container">
    
    <div class="margin-container" style="margin-top: 80px;">
        <!--<div class="banner-container left">
            Banner Space160x600
        </div>
        <div class="banner-container right">
            Banner Space160x600
        </div>-->
        <a href="<?php echo base_url();?>wow/channel/upload" class="upload-button-red"></a>
        
        <div class="left-sidebar">
                            <img style="display: block;margin: auto;" src="http://devel.uzone.co.id/assets/new_wow/css/img/logo-your-project.png">
                        
        </div>
        <div class="right-sidebar">
            <div class="statik-title-big">UZone Wow // <?php echo $content;?> </div>
            <div class="underline-red thin"></div>
            <div class="statik-content">
                <?php if($content == 'About'){ ?>
                    <p>Bangga Menjadi Bagian dari Era Digital Bersama Uzone!!</p>

                    <p>Ingin menemukan talenta baru yang mampu berprestasi? Atau justru kamu talenta yang kita cari?</p>

                    <p>Saatnya menjadi bagian dari sebuah era digital dimana kamu bisa membuktikan ide kreatif dan kemampuan kamu sebagai penulis, gamer handal, musisi dan vokalis berbakat, hingga pembuat film dan aplikasi untuk bisa dikenal di Indonesia bahkan mata dunia dengan bergabung di Uzone, -wadahnya ide-ide kreatif anak bangsa.</p>

                    <p>Dengan WOW Channel dari Uzone, kamu bisa sharing karya atau ide kreatif kamu dalam bentuk digital berupa video, yang nantinya bisa membawa kamu mendapatkan peluang untuk bisa unjuk diri diberagam kompetisi dari Uzone.</p>

                    <p>Di WOW Channel kita tak hanya membuka kesempatan bagi generasi muda Indonesia untuk membuktikan karyanya namun juga mengajak komunitas yang memiliki ide dan harapan untuk mencari talenta baru untuk bergabung dalam Community Partner Uzone.</p>

                    <p>Ayo anak Indonesia, buktikan talenta kamu. Segera upload karya kamu disini dan siap terkenal dengan karyamu yang membanggakan!</p>
                <?php } else { ?>
                    Frequently Asked Question. Lorem ipsum dolor sit amet, consectetuer adipiscing elit, sed diam nonummy nibh euismod tincidunt ut laoreet dolore magna aliquam erat volutpat. Ut wisi enim ad minim veniam, quis nostrud exerci tation ullamcorper suscipit lobortis nisl ut aliquip ex ea commodo consequat. Duis autem vel eum iriure dolor in hendrerit in vulputate velit esse molestie consequat, vel illum dolore eu feugiat nulla facilisis at vero eros et accumsan et iusto odio dignissim qui blandit praesent luptatum zzril delenit augue duis dolore te feugait nulla facilisi. Nam liber tempor cum soluta nobis eleifend option congue nihil imperdiet doming id quod mazim placerat facer possim assum. Typi non habent claritatem insitam; est usus legentis in iis qui facit eorum claritatem. Investigationes demonstraverunt lectores legere me lius quod ii legunt saepius. Claritas est etiam processus dynamicus, qui sequitur mutationem consuetudium lectorum. Mirum est notare quam littera gothica, quam nunc putamus parum claram, anteposuerit litterarum formas humanitatis per seacula quarta decima et quinta decima. Eodem modo typi, qui nunc nobis videntur parum clari, fiant sollemnes in futurum.
                <?php } ?>
			</div>
        </div>
    </div>
    </div>
</div>

<?php if (isset($page))$this->load->view('channel/wow/page/footer'); ?>