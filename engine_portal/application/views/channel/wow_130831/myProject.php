<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<title>UZone - WoW Competition</title>

<link href="<?php echo config_item('assets_wow'); ?>style.css" rel="stylesheet" type="text/css" />
<link href="<?php echo config_item('assets_wow'); ?>custom.css" rel="stylesheet" type="text/css" />
<script src="<?php echo config_item('assets_wow'); ?>js/popup/jquery-1.9.1.js"></script>
<script src="js/popup/jquery.bpopup.min.js"></script>
<script type="text/javascript" src="<?php echo config_item('assets_wow'); ?>js/jquery.tinycarousel.js"></script>
<script type="text/javascript" src="<?php echo config_item('assets_wow'); ?>js/website.js"></script>


<script type="text/javascript">
sfHover = function() {
    var sfEls = document.getElementById("navbar").getElementsByTagName("li");
    for (var i=0; i<sfEls.length; i++) {
        sfEls[i].onmouseover=function() {
            this.className+=" hover";
        }
        sfEls[i].onmouseout=function() {
            this.className=this.className.replace(new RegExp(" hover\\b"), "");
        }
    }
}
if (window.attachEvent) window.attachEvent("onload", sfHover);
</script>
<script type="text/javascript">         
    $(document).ready(function(){               
                
        $('#slider-code').tinycarousel({ pager: true });
        
    });
</script>
</head>
<body>
<div id="content">
    <div id="header">
        <div class="logo">
            <span class="main"><img src="<?php echo config_item('assets_wow'); ?>images/logo.png" /></span>
            <span class="sub"><a href="<?php echo base_url(); ?>wow/channel"><img src="<?php echo config_item('assets_wow'); ?>images/logo_wow.png" /></a></span>
        </div>
        <div class="welcome">
            <?php if($this->user_m->is_loggedin()) { ?>
                <span>Welcome, <a href="<?php echo base_url(); ?>wow/channel" class="profile"><?php echo $this->session->userdata('username'); ?></a></span>
            <?php } else { ?>
                <span>Welcome, <a href="#" class="profile">Guest</a></span>
            <?php } ?>
        </div>
    </div>
    
</div>
<script type='text/javascript'>//<![CDATA[ 
$(window).load(function(){
    // Semicolon (;) to ensure closing of earlier scripting
    // Encapsulation
    // $ is assigned to jQuery
    ;(function($) {

         // DOM Ready
        $(function() {

            // Binding a click event
            // From jQuery v.1.7.0 use .on() instead of .bind()
            $('#my-button').bind('click', function(e) {

                // Prevents the default action to be triggered. 
                e.preventDefault();

                // Triggering bPopup when click event is fired
                $('#element_upload').bPopup({
                    modalClose: false,
                    opacity: 0.8,
                    positionStyle: 'fixed' //'fixed' or 'absolute'
                });

            });

        });

    })(jQuery);


/*================================================================================
 * @name: bPopup - if you can't get it up, use bPopup
 * @author: (c)Bjoern Klinggaard (twitter@bklinggaard)
 * @demo: http://dinbror.dk/bpopup
 * @version: 0.9.0.min
 ================================================================================*/
 (function(b){b.fn.bPopup=function(u,C){function v(){a.modal&&b('<div class="b-modal '+d+'"></div>').css({backgroundColor:a.modalColor,position:"fixed",top:0,right:0,bottom:0,left:0,opacity:0,zIndex:a.zIndex+l}).each(function(){a.appending&&b(this).appendTo(a.appendTo)}).fadeTo(a.speed,a.opacity);A();c.data("bPopup",a).data("id",d).css({left:"slideIn"===a.transition?-1*(h+g):m(!(!a.follow[0]&&n||f)),position:a.positionStyle||"absolute",top:"slideDown"===a.transition?-1*(j+g):p(!(!a.follow[1]&&q||f)),"z-index":a.zIndex+l+1}).each(function(){a.appending&&b(this).appendTo(a.appendTo)});D(!0)}function r(){a.modal&&b(".b-modal."+c.data("id")).fadeTo(a.speed,0,function(){b(this).remove()});D();return!1}function E(s){var b=s.width(),d=s.height();a.contentContainer.css({height:d,width:b});d<=c.height()&&(d=c.height());b<=c.width()&&(b=c.width());t=c.outerHeight(!0);g=c.outerWidth(!0);a.contentContainer.css({height:"auto",width:"auto"});A();c.dequeue().animate({left:m(!(!a.follow[0]&&n||f)),top:p(!(!a.follow[1]&&q||f)),height:d,width:b},250,function(){s.show();w=B()})}function D(b){switch(a.transition){case "slideIn":c.show().animate({left:b?m(!(!a.follow[0]&&n||f)):-1*(h+g)},a.speed,a.easing,function(){x(b)});break;case "slideDown":c.show().animate({top:b?p(!(!a.follow[1]&&q||f)):-1*(j+t)},a.speed,a.easing,function(){x(b)});break;default:b?c.fadeIn(a.speed,function(){x(b)}):c.stop().fadeOut(a.speed,a.easing,function(){x(b)})}}function x(s){s?(e.data("bPopup",l),c.delegate("."+a.closeClass,"click."+d,r),a.modalClose&&b(".b-modal."+d).css("cursor","pointer").bind("click",r),!F&&(a.follow[0]||a.follow[1])&&e.bind("scroll."+d,function(){w&&c.dequeue().animate({left:a.follow[0]?m(!f):"auto",top:a.follow[1]?p(!f):"auto"},a.followSpeed,a.followEasing)}).bind("resize."+d,function(){if(w=B())A(),c.dequeue().each(function(){f?b(this).css({left:h,top:j}):b(this).animate({left:a.follow[0]?m(!0):"auto",top:a.follow[1]?p(!0):"auto"},a.followSpeed,a.followEasing)})}),a.escClose&&y.bind("keydown."+d,function(a){27==a.which&&r()}),k(C)):(a.scrollBar||b("html").css("overflow","auto"),b(".bModal."+d).unbind("click"),y.unbind("keydown."+d),e.unbind("."+d).data("bPopup",0<e.data("bPopup")-1?e.data("bPopup")-1:null),c.undelegate("."+a.closeClass,"click."+d,r).data("bPopup",null).hide(),k(a.onClose),a.loadUrl&&(a.contentContainer.empty(),c.css({height:"auto",width:"auto"})))}function m(a){return a?h+y.scrollLeft():h}function p(a){return a?j+y.scrollTop():j}function k(a){b.isFunction(a)&&a.call(c)}function A(){var b;q?b=a.position[1]:(b=((window.innerHeight||e.height())-t)/2-a.amsl,b=b<z?z:b);j=b;h=n?a.position[0]:((window.innerWidth||e.width())-g)/2;w=B()}function B(){return(window.innerHeight||e.height())>c.outerHeight(!0)+z&&(window.innerWidth||e.width())>c.outerWidth(!0)+z}b.isFunction(u)&&(C=u,u=null);var a=b.extend({},b.fn.bPopup.defaults,u);a.scrollBar||b("html").css("overflow","hidden");var c=this,y=b(document),e=b(window),F=/OS 6(_\d)+/i.test(navigator.userAgent),z=20,l=0,d,w,q,n,f,j,h,t,g;c.close=function(){a=this.data("bPopup");d="__b-popup"+e.data("bPopup")+"__";r()};return c.each(function(){if(!b(this).data("bPopup"))if(k(a.onOpen),l=(e.data("bPopup")||0)+1,d="__b-popup"+l+"__",q="auto"!==a.position[1],n="auto"!==a.position[0],f="fixed"===a.positionStyle,t=c.outerHeight(!0),g=c.outerWidth(!0),a.loadUrl)switch(a.contentContainer=b(a.contentContainer||c),a.content){case "iframe":b('<iframe class="b-iframe" scrolling="no" frameborder="0"></iframe>').attr("src",a.loadUrl).appendTo(a.contentContainer);k(a.loadCallback);t=c.outerHeight(!0);g=c.outerWidth(!0);v();break;case "image":v();b("<img />").load(function(){k(a.loadCallback);E(b(this))}).attr("src",a.loadUrl).hide().appendTo(a.contentContainer);break;default:v(),b('<div class="b-ajax-wrapper"></div>').load(a.loadUrl,a.loadData,function(){k(a.loadCallback);E(b(this))}).hide().appendTo(a.contentContainer)}else v()})};b.fn.bPopup.defaults={amsl:50,appending:!0,appendTo:"body",closeClass:"b-close",content:"ajax",contentContainer:!1,easing:"swing",escClose:!0,follow:[!0,!0],followEasing:"swing",followSpeed:500,loadCallback:!1,loadData:!1,loadUrl:!1,modal:!0,modalClose:!0,modalColor:"#000",onClose:!1,onOpen:!1,opacity:0.7,position:["auto","auto"],positionStyle:"absolute",scrollBar:!0,speed:250,transition:"fadeIn",zIndex:9997}})(jQuery);
});//]]>  

</script>  
    <!-- MENU -->
<div id="content">
    <div id="menu">
    	<ul id="navbar">
            <li><a href="#">What's Wow?</a>
                <ul>
                    <?php foreach($categories_wow as $cat_wow): ?>
                        <?php if($cat_wow->display_order >= 1){ ?>
                            <?php if($cat_wow->content == NULL){ ?>
                                <li><a href="<?php echo base_url('wow/channel').'/gallery/'.$cat_wow->category_id; ?>" data="<?php echo $cat_wow->id; ?>"><?php echo $cat_wow->title; ?></a></li>
                            <?php } else { ?>
                                <li><a href="<?php echo base_url('wow/read').'/index/'.$cat_wow->id; ?>" data="<?php echo $cat_wow->id; ?>"><?php echo $cat_wow->title; ?></a></li>
                            <?php } ?>
                        <?php } ?>
                    <?php endforeach; ?>
                </ul>
            </li>
            <li><a href="#">10 Seconds Movie</a>
                <ul>
                    <?php foreach($categories_10s as $cat_10s): ?>
                        <?php if($cat_10s->display_order >= 1){ ?>
                            <?php if($cat_10s->content == NULL){ ?>
                                <li><a href="<?php echo base_url('wow/channel').'/gallery/'.$cat_10s->category_id; ?>" data="<?php echo $cat_10s->id; ?>"><?php echo $cat_10s->title; ?></a></li>
                            <?php } else { ?>
                                <li><a href="<?php echo base_url('wow/read').'/index/'.$cat_10s->id; ?>" data="<?php echo $cat_10s->id; ?>"><?php echo $cat_10s->title; ?></a></li>
                            <?php } ?>
                        <?php } ?>
                    <?php endforeach; ?>
                </ul>
            </li>
            <li><a href="#">Digital Idol</a>
                <ul>
                    <?php foreach($categories_di as $cat_di): ?>
                        <?php if($cat_di->display_order >= 1){ ?>
                            <?php if($cat_di->content == NULL){ ?>
                                <li><a href="<?php echo base_url('wow/channel').'/gallery/'.$cat_di->category_id; ?>" data="<?php echo $cat_di->id; ?>"><?php echo $cat_di->title; ?></a></li>
                            <?php } else { ?>
                                <li><a href="<?php echo base_url('wow/read').'/index/'.$cat_di->id; ?>" data="<?php echo $cat_di->id; ?>"><?php echo $cat_di->title; ?></a></li>
                            <?php } ?>
                        <?php } ?>
                    <?php endforeach; ?>
                </ul>
            </li>
        </ul>
        
        <div >
            <button id="my-button"><img src="<?php echo config_item('assets_wow'); ?>images/upload_btn.png" /></button>
        </div>
        <div id="element_upload">
            <a class="b-close">x</a>
            <h1 id="wow-wizard-title" class="pop-up-title">Upload Video</h1>
            <div class="container" id="upload-wizard" style="height: 250px;">
                <?php echo $this->load->view('channel/wow/upload/step-1', $wizard_events, TRUE); ?>
            </div>
        </div>
    </div>
    <!-- END of MENU -->
</div>    
<!-- CONTENT BOTTOM -->
<div class="page">
    <div class="content-container">
            
        <div class="right-container">
            <div class="full-width-container">
                <div class="title-big-container red"> My Gallery</div>
            </div>
            <div class="full-width-container">
                <!--<div class="title-gallery">Recent Uploads</div>
                <div class="showall-gallery"><a href="#">Show All</a></div>-->
            </div>
            <?php foreach ($items as $item):?>
            <div class="gallery-container">
                
                <div class="gallery-thumb-container" title="Play video" onclick="playVideo('<?php echo $item->id;?>','<?php echo $item->item_url;?>','<?php echo $item->item_thumbnail;?>');">
                    <img src="<?php echo $item->item_thumbnail;?>" />
                </div>
                <div class="gallery-tittle-container"><?php echo $item->item_name;?></div>
                <div class="gallery-description-container"><?php echo $item->item_description;?></div>
                
            </div>
            <?php endforeach;?>
        </div>
    </div>
</div>

<div class="content-container">
    <div id="footer">
        <div class="copy">Copyright &copy; 2013 <strong>UZone</strong> - All rights reserved.</div>
        <div class="logotelkom"><img src="<?php echo config_item('assets_wow'); ?>images/bytelkom.png" /></div>
    </div>
</div>

<div id="element_to_pop_up">
    <a class="b-close">x</a>
    <div id="wow-player">WOW VIDEO</div>
</div>

<!-- END of CONTENT BOTTOM -->

<!-- SIDR -->
<?php $this->load->view('channel/wow/slide_menu_panel'); ?>
<!-- END SIDR -->

<script src="<?php echo config_item("assets_url"); ?>jwplayer/jwplayer.js"></script>
<script type="text/javascript">jwplayer.key="6aMwqeMz0opU9trgteTwz6bLsKUOzlGvNCg64g==";</script>
<script>
    var wow_event_selected = 0;
    $(document).ready(function() {
        $('.tombol-panel-one').sidr({
            name: 'sidr-right',
            side: 'right',
            body: ''
        });
        
        $('.tombol-panel').sidr({
            name: 'sidr-right',
            side: 'right',
            body: ''
        });
        
        $('.tombol-panel-one').click(function(){
            $('.container-panel').show();
        });

        /**** WOW WIZARD **************/
        $('a.wow-event').click(function(){
            wow_event_selected = $(this).attr('data');

            //Load another step to pop up
            $('div#upload-wizard').load('<?php echo site_url('wow/upload/wizard_loadform'); ?>/'+wow_event_selected, function(){
                $('h1#wow-wizard-title').html('Upload Your Files');
            });
        });
		
		$('.tombol-panel-one').show();
        $('.tombol-panel').show();
    });
	
	function playVideo(id, video_url, img_url){
		var container = document.getElementById('wow-player');
        container.innerHTML= '';
        
        jwplayer('wow-player').setup({
            file: video_url,
            image: img_url,
            autostart: true,
            'modes': [
                {type: 'flash', src: "jwplayer.flash.swf"},
                {type: 'html5'}
            ],
			width: 630,
            height: 480
            
        });
		
		
        $('#element_to_pop_up').bPopup({
            modalClose: false,
            opacity: 0.8,
            positionStyle: 'fixed', //'fixed' or 'absolute'
            onClose: function() { document.getElementById('wow-player').innerHTML = ''; }
        });
		
	}
	
	
    
    
    
</script>

</body>
</html>
