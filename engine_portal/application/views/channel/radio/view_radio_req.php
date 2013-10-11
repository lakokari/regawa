<style type="text/css">
    body {
        background-color:#f0f0ee;
        font-size: .8em;
        font-family: Arial, "Helvetica Neue", Helvetica, sans-serif;
    }
    .clearfix:after {
        visibility:hidden;
        display:block;
        font-size:0;
        content: ".";
        clear:both;
        height:0;
    }
    .clearfix {
        display: inline-block;
    }
    * html .clearfix {
        height: 1%;
    }
    .bubble-list .bubble img {
        float:left;
        width:30px;
        height:30px;
        border:2px solid #ffffff;
        border-radius:10px

    }
    .bubble-content {
        position:relative;
        float:left;
        margin-left:12px;
        width:350px;
        padding:0px 20px;
        border-radius:10px;
        background-color:#FFFFFF;
        box-shadow:1px 1px 5px rgba(0,0,0,.2);
        margin-bottom:20px;
    }

    .bubble {
        margin-bottom:20px;
    }
    .point {
        border-top:10px solid transparent;
        border-bottom:10px solid transparent;
        border-right: 12px solid #FFF;
        position:absolute;
        left:-10px;
        top:12px;
    } 
</style>


    <div class="bubble-list">
     <?php
    if(!empty($view_radio_req)) {
        $urut = 1;
        foreach ($view_radio_req as $view_radio_req) {
            if(!empty($view_radio_req->foto)) {$foto = $view_radio_req->foto;} else {$foto = config_item('assets_url') ."css/img/user.png";}
            echo '
            
                        <div class="bubble clearfix">
                                <img src="'.config_item('api_folder').'radio/'.$foto.'">
                                <div class="bubble-content">
                                        <div class="point"></div>
                                        <p><b>'.$view_radio_req->pengirim.'</b></p>
                                        <p>'.$view_radio_req->pesan.'</p>
                                </div>
                        
                  
            ';        
        $urut++;
        }
    } else {
        echo config_item('text_nodata');
    }
?>
</div>
