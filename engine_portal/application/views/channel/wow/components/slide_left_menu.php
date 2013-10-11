<style>
    .dropdown-menu {
        position: absolute;
        top: 100%;
        left: 0;
        z-index: 1000;
        float: left;
        min-width: 165px;
        padding: 5px 0;
        margin: 2px 0 0;
        list-style: none;
        background-color: rgba(255, 255, 255, 0.8);;
        border: 1px solid #ccc;
        border: 1px solid rgba(0, 0, 0, 0.2);
        *border-right-width: 2px;
        *border-bottom-width: 2px;
        -webkit-border-radius: 6px;
        -moz-border-radius: 6px;
        border-radius: 6px;
        -webkit-box-shadow: 0 5px 10px rgba(0, 0, 0, 0.2);
        -webkit-box-shadow: none;
        -moz-box-shadow: 0 5px 10px rgba(0, 0, 0, 0.2);
        -moz-box-shadow: none;
        box-shadow: 0 5px 10px rgba(0, 0, 0, 0.2);
        box-shadow: none;
        -webkit-background-clip: padding-box;
        -moz-background-clip: padding;
        background-clip: padding-box;
    }

    .dropdown-menu.pull-right {
        right: 0;
        left: auto;
    }

    .dropdown-menu .divider {
        *width: 100%;
        height: 1px;
        margin: 9px 1px;
        *margin: -5px 0 5px;
        overflow: hidden;
        background-color: #e5e5e5;
        border-bottom: 1px solid #ffffff;
    }

    .dropdown-menu > li > a {
        display: block;
        padding: 3px 20px;
        clear: both;
        font-weight: normal;
        line-height: 20px;
        color: #333333;
        white-space: nowrap;
        text-decoration: none;
        font-size: 14px;
    }

    .dropdown-menu > li > a:hover,
    .dropdown-menu > li > a:focus,
    .dropdown-submenu:hover > a,
    .dropdown-submenu:focus > a {
        color: #ffffff;
        text-decoration: none;
        background-color: #d31821;
        background-image: -moz-linear-gradient(top, #2e8bcc, #297db7);
        background-image: -webkit-gradient(linear, 0 0, 0 100%, from(#2e8bcc), to(#297db7));
        background-image: -webkit-linear-gradient(top, #2e8bcc, #297db7);
        background-image: -o-linear-gradient(top, #2e8bcc, #297db7);
        background-image: linear-gradient(to bottom, #2e8bcc, #297db7);
        background-image: none;
        background-repeat: repeat-x;
        filter: progid:DXImageTransform.Microsoft.gradient(startColorstr='#ff2e8bcc', endColorstr='#ff297db7', GradientType=0);
        filter: progid:DXImageTransform.Microsoft.gradient(enabled=false);
    }

    .dropdown-menu > .active > a,
    .dropdown-menu > .active > a:hover,
    .dropdown-menu > .active > a:focus {
        color: #fff;
        text-decoration: none;
        background-color: #d31821;
        background-image: -moz-linear-gradient(top, #2e8bcc, #297db7);
        background-image: -webkit-gradient(linear, 0 0, 0 100%, from(#2e8bcc), to(#297db7));
        background-image: -webkit-linear-gradient(top, #2e8bcc, #297db7);
        background-image: -o-linear-gradient(top, #2e8bcc, #297db7);
        background-image: linear-gradient(to bottom, #2e8bcc, #297db7);
        background-image: none;
        background-repeat: repeat-x;
        outline: 0;
        filter: progid:DXImageTransform.Microsoft.gradient(startColorstr='#ff2e8bcc', endColorstr='#ff297db7', GradientType=0);
        filter: progid:DXImageTransform.Microsoft.gradient(enabled=false);
    }

    .dropdown-menu > .disabled > a,
    .dropdown-menu > .disabled > a:hover,
    .dropdown-menu > .disabled > a:focus {
        color: #999999;
    }

    .dropdown-menu > .disabled > a:hover,
    .dropdown-menu > .disabled > a:focus {
        text-decoration: none;
        cursor: default;
        background-color: transparent;
        background-image: none;
        filter: progid:DXImageTransform.Microsoft.gradient(enabled=false);
    }

    div.leftmenu {
        position:fixed;
        z-index:9999;
        top: 50%;
        left:-165px;
    }
    div.leftmenu .dropdown-menu {
        position:relative;
        top:-100px;
    }
    div.leftmenu > a.btn {
        position:absolute;
        left:150px;
        z-index:99999;
        padding-left:30px;
        background : #fff;
    }
    div.leftmenu .tombol{
        position:absolute;
        left:143px;
        z-index:99999;
        padding-left:22px;
        width : 50px;
        height : 20px;
    }

    .dropdown-menu {
        border : 0px solid white;
        border-radius: 0px;
    }
</style>

<div class="leftmenu">
    <div class="tombol">
        <a href="#" title="Click to Expand Panel Menu"><img src="<?php echo base_url(); ?>assets/css/img/button-panel-menu-click-here.png"></a>
    </div>        
    <ul class="dropdown-menu show" id='byfeature'>
        <li><a href='<?php echo base_url() ?>'>Home</a></li>
        <?php foreach ($channels as $category): ?>
            <li><a href='<?php echo base_url($category->name . '/channel') ?>'><?php
                    if ($category->name == 'tv') {
                        echo 'TV';
                    } else {
                        echo ucwords($category->name);
                    }
                    ?></a></li> <!-- edited by alex 8/7/2013 -->
<?php endforeach; ?>
    </ul>
</div>
<script>
    $(document).click(function() {
        $(".leftmenu").stop().animate({left: '-165px'});
        $('.tombol').click(function(event) {
            event.stopPropagation();
            if ($(".leftmenu").css('left') == '0px') {

                $(".leftmenu").animate({left: '-165px'});
            } else {

                $(".leftmenu").animate({left: '0px'});
            }
        });

    });
</script> 
