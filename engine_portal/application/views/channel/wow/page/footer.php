

<link rel="stylesheet" href="<?php echo config_item('assets_wow'); ?>css/colorbox.css" />
<script src="<?php echo config_item('assets_wow'); ?>js/jquery.colorbox.js"></script>
<script type="text/javascript">
$(function() {		
				
	JQTWEET = {
	     	    
	    search: '', //leave this blank if you want to show user's tweet
	    user: 'UZoneIndonesia', //username
	    numTweets: 10, //number of tweets
	    appendTo: '#myslider-content',
	    template: '<div class="slide1 container-item">{AVATAR}\
					<div class="news-container-twitt">\
						<div class="slider-title-news"><a target="_blank" href="{URL}">{USER}</a></div>\
						<div class="slider-desc-news">{TEXT}</div>\
						<div class="slider-nav-twit">{AGO}\
						</div>\
						</div>\
				   </div>',
		/*
	    <a class="nav-twit-item" href="#">Reply</a>\
        <a class="nav-twit-item" href="#">Retweet</a>\
        <a class="nav-twit-item" href="#">Favorite</a>\
		*/
	    // core function of jqtweet
	    // https://dev.twitter.com/docs/using-search
	    loadTweets: function() {

	        var request;
	         
	        // different JSON request {hash|user}
	        if (JQTWEET.search) {
            request = {
                q: JQTWEET.search,
                count: JQTWEET.numTweets,
                api: 'search_tweets'
            }
	        } else {
            request = {
                q: JQTWEET.user,
                count: JQTWEET.numTweets,
                api: 'statuses_userTimeline'
            }
	        }

	        $.ajax({
	            url: '<?php echo site_url('wow/read/tweet');?>',
	            type: 'POST',
	            dataType: 'json',
	            data: request,
	            success: function(data, textStatus, xhr) {
		            
		            if (data.httpstatus == 200) {
		            	if (JQTWEET.search) data = data.statuses;

	                var text, name, img;	         
	                	                
	                try {
	                  // append tweets into page
	                  for (var i = 0; i < JQTWEET.numTweets; i++) {		
	                  
	                    url = 'http://twitter.com/' + data[i].user.screen_name + '/status/' + data[i].id_str;

	                  
	                    $(JQTWEET.appendTo).append( JQTWEET.template.replace('{TEXT}', JQTWEET.ify.clean(data[i].text) )
	                        .replace('{USER}', data[i].user.screen_name)
							.replace('{AVATAR}', '<img class="rounded" src="'+data[i].user.profile_image_url_https+'">')
	                        .replace('{AGO}', JQTWEET.timeAgo(data[i].created_at) )
	                        .replace('{URL}', url )			                            
	                        );
	                  }
                  
                  } catch (e) {
	                  //item is less than item count
                  }
                  
              
	                    
	               } else alert('no data returned');
	             
	            }   
	 
	        });
	 
	    }, 
	     
	         
	    /**
	      * relative time calculator FROM TWITTER
	      * @param {string} twitter date string returned from Twitter API
	      * @return {string} relative time like "2 minutes ago"
	      */
	    timeAgo: function(dateString) {
	        var rightNow = new Date();
	        var then = new Date(dateString);
	         

	 
	        var diff = rightNow - then;
	 
	        var second = 1000,
	        minute = second * 60,
	        hour = minute * 60,
	        day = hour * 24,
	        week = day * 7;
	 
	        if (isNaN(diff) || diff < 0) {
	            return ""; // return blank string if unknown
	        }
	 
	        if (diff < second * 2) {
	            // within 2 seconds
	            return "right now";
	        }
	 
	        if (diff < minute) {
	            return Math.floor(diff / second) + " seconds ago";
	        }
	 
	        if (diff < minute * 2) {
	            return "about 1 minute ago";
	        }
	 
	        if (diff < hour) {
	            return Math.floor(diff / minute) + " minutes ago";
	        }
	 
	        if (diff < hour * 2) {
	            return "about 1 hour ago";
	        }
	 
	        if (diff < day) {
	            return  Math.floor(diff / hour) + " hours ago";
	        }
	 
	        if (diff > day && diff < day * 2) {
	            return "yesterday";
	        }
	 
	        if (diff < day * 365) {
	            return Math.floor(diff / day) + " days ago";
	        }
	 
	        else {
	            return "over a year ago";
	        }
	    }, // timeAgo()
	     
	     
	    /**
	      * The Twitalinkahashifyer!
	      * http://www.dustindiaz.com/basement/ify.html
	      * Eg:
	      * ify.clean('your tweet text');
	      */
	    ify:  {
	      link: function(tweet) {
	        return tweet.replace(/\b(((https*\:\/\/)|www\.)[^\"\']+?)(([!?,.\)]+)?(\s|$))/g, function(link, m1, m2, m3, m4) {
	          var http = m2.match(/w/) ? 'http://' : '';
	          return '<a class="twtr-hyperlink" target="_blank" href="' + http + m1 + '">' + ((m1.length > 25) ? m1.substr(0, 24) + '...' : m1) + '</a>' + m4;
	        });
	      },
	 
	      at: function(tweet) {
	        return tweet.replace(/\B[@＠]([a-zA-Z0-9_]{1,20})/g, function(m, username) {
	          return '<a target="_blank" class="twtr-atreply" href="http://twitter.com/intent/user?screen_name=' + username + '">@' + username + '</a>';
	        });
	      },
	 
	      list: function(tweet) {
	        return tweet.replace(/\B[@＠]([a-zA-Z0-9_]{1,20}\/\w+)/g, function(m, userlist) {
	          return '<a target="_blank" class="twtr-atreply" href="http://twitter.com/' + userlist + '">@' + userlist + '</a>';
	        });
	      },
	 
	      hash: function(tweet) {
	        return tweet.replace(/(^|\s+)#(\w+)/gi, function(m, before, hash) {
	          return before + '<a target="_blank" class="twtr-hashtag" href="http://twitter.com/search?q=%23' + hash + '">#' + hash + '</a>';
	        });
	      },
	 
	      clean: function(tweet) {
	        return this.hash(this.at(this.list(this.link(tweet))));
	      }
	    } // ify
	 
	     
	};		
	
});

</script>
<style>
#video-player-footer
{
	margin: 100px 0 10px 0;
}

.slider-title-news a{
	color:rgb(225, 225, 225);
}


.overlay-play-icon{
	text-align: center;
	width: 155px;
	height: 20px;
	padding-top: 85px;
}

.overlay-play-icon:hover{
	text-align: center;
	width: 155px;
	height: 20px;
	padding-top: 85px;
}
.footer-title-news{
	padding-top:70px;
}
.footer-title-news a{
	text-decoration:none;
	margin-top:100px;
	color:#fff;
}
.footer-title-news a:hover{
	color:#ff0000;
}
.footer-date-news{
	font-size:12px;
	margin-bottom:10px;
	width:100%;
	border-bottom:1px dotted #666;
}

.twitter-feed-timeline .slide1 img {
    width: 52px;
    height: 47px;
    margin-bottom: 44px;
    float: left;
}
</style>
<div class="sidebar-bottom-bg">
    <div class="margin-container" style="height: 340px;">
        <div class="sidebar-bottom-left">
                    <div class="sidebar-bottom-title">News</div>
        			<div class="footer-title-news">
        			<?php foreach ($wow_news->result() as $news) :?>
        				<a href="<?php echo site_url('wow/read/news/'. $news->id); ?>"><?php echo $news->news_title; ?></a>
						<div class="footer-date-news"><?php echo date('d M Y H:i:s',strtotime($news->news_datetime)); ?></div>
        			<?php endforeach; ?>
					</div>
        </div>
		
        <div class="sidebar-bottom-center">
            <div class="sidebar-bottom-title">Play Me</div>
			<div class="playtime-thumb">
                  <a class='iframe' href="<?php echo site_url('wow/channel/video_footer').'/'.$data_news[0]->id;?>">
                      <img src="<?php echo config_item('userfiles').'wow'.'/news/'.$data_news[0]->img_path; ?>" height="120px">
                    <div class="overlay-play-icon"><span style="color:rgb(212, 29, 23);">Play Me</span></div>
                </a>
			</div>
            <div class="etalase-desc-title">
                <?php echo $data_news[0]->news_title; ?>
            </div>
			<br/>
            <div class="etalase-desc-text">
                <?php //echo $data_news[0]->news_datetime; ?>
            </div>
        </div>
        
        <div class="sidebar-bottom-right">
            <div class="sidebar-bottom-title">Twitter feed</div>
            <div class="twitter-feed-heading">
                <a href="#" class="icon-twitter-circle-grey"></a>
                <div class="twitter-feed-title">
                    @UZoneIndonesia 
                </div>
                <div class="twitter-feed-text">
                    Join our conversation on twitter with hashtag: <a href="#">#Wow10Sec</a>
                </div>
				<div class="follow-red-button">
				<a href="https://twitter.com/UZoneIndonesia" class="twitter-follow-button" data-show-count="false" data-size="large" data-show-screen-name="false">Follow @UZoneIndonesia</a>
<script>!function(d,s,id){var js,fjs=d.getElementsByTagName(s)[0],p=/^http:/.test(d.location)?'http':'https';if(!d.getElementById(id)){js=d.createElement(s);js.id=id;js.src=p+'://platform.twitter.com/widgets.js';fjs.parentNode.insertBefore(js,fjs);}}(document, 'script', 'twitter-wjs');</script>
                </div>
				<!--<a href="#" class="follow-red-button">Follow</a>-->
            </div>
            <div class="twitter-feed-timeline">
                <div id="myslider1" class="myslider1">
                    <div id="myslider-content">


                        
                    </div>

                </div>
            </div>
					<script type="text/javascript">
						$(function () {
							JQTWEET.loadTweets();
						});

					</script>
        </div>
    </div>
</div>



<script>

    $('#myslider1').swipePlanes();
	
	$(document).ready(function() { 
		$(".iframe").colorbox({iframe:true, width:"580", height:"400"});
		$("#click").click(function(){ 
			$('#click').css({"background-color":"#f00", "color":"#fff", "cursor":"inherit"}).text("Open this window again and this message will still be here.");
			return false;
		});
    });
</script>