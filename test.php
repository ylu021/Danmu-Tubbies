<?php
  require_once 'db-info.php';

  $query = 'SELECT * from "Tubbies_Comment" WHERE video_id=? ORDER BY comment_time ASC';
  $stmt = $db->prepare($query);
  $stmt->execute(array($_GET['q']));

  include 'head.php';
?>


		<body>
			<div class="outer-container">
        <div class="inner-container">
          <div id="overlay-comment" class="overlay-comment"></div>
          <div id="active-comment" class="active-comment"><div id="active-btn" class="active-btn"><button id="active-btn" class="active-btn">Show comments</button></div></div>
          <div id="youtube_container">
  				</div>
        </div>

        <div>
			</div>
			<div class="comment-container">
        <div class="comment">
          <!--<a class="nav-result" href="#" onclick="location.href = document.referrer; return false;">Back to search results</a>-->
          <input class="comment-field" type="text" id="btntext" placeholder="say something">
          <button class="comment-btn" id="btn" onClick="content()" onmouseover="enter(this)" onmouseleave="leave(this)">ready</button>
        </div>
				
				<!-- <h4>Get current Time = </h4> -->
				<p id="demo"></p>

			</comment>
      <div class="footer container-pushin">
        <span class="site-info">Danmu|Tubbies © 2017, A project made by Yichen Lu & Mingjian Zhang</span>
      </div>
      <script src="https://www.youtube.com/iframe_api"></script>
      <?php include 'script.php'; ?>

    <script>
      // 2. This code loads the IFrame Player API code asynchronously.
      var tag = document.createElement('script');

      tag.src = "https://www.youtube.com/iframe_api";
      var firstScriptTag = document.getElementsByTagName('script')[0];
      firstScriptTag.parentNode.insertBefore(tag, firstScriptTag);

      // 3. This function creates an <iframe> (and YouTube player)
      //    after the API code downloads.
      var player

      var qs = (function(a) {
        var b = {}
        for (var i = 0; i < a.length; ++i)
        {
          var decoded = "" //decoded queries
          var p=a[i].split('=', 2)
          if (p.length == 1)
                b[p[0]] = ""
          
          if(i==2) //email
            decoded = atob(p[1])
          else
            decoded = p[1]

          b[p[0]] = decodeURIComponent(p[1].replace(/\+/g, " "));
        }
        return b;
      })(window.location.search.substr(1).split('&'))

      function onYouTubeIframeAPIReady() {

        player = new YT.Player('youtube_container', {
          height: '390',
          width: '640',
          videoId: qs['q'],
          playerVars: {
            origin: window.location.hostname,
            fs: 0,
            showinfo: 0,
          },
          events: {
            'onReady': onPlayerReady,
            'onStateChange': onPlayerStateChange
          }
        })
      }

      // 4. The API will call this function when the video player is ready.
      function onPlayerReady(event) {
        event.target.playVideo()
      }

      function onPlayerStateChange(event) {
        if (event.data == YT.PlayerState.PLAYING) {
          counter = 0
          $('#btntext').keypress(function(e){
            if(e.keyCode==13)
              $('#btn').click();
          });
          document.getElementsByTagName("demo").innerHTML = player.getCurrentTime();
          <?php
                while($row = $stmt->fetch( PDO::FETCH_ASSOC )){
          ?>

                    comment = "<?php echo $row['comment_text']; ?>"
                    time = "<?php echo $row['comment_time']; ?>"
                    console.log(comment, time)
                    fire(comment, time, player.getCurrentTime(), player.getDuration(), counter)
                    counter+=100

                    if (player.getPlayerState() == 2){
                      console.log('video is paused')
                      $('#overlay-comment').find('#title').each(function(){
                        console.log($(this))
                        $(this).stop()
                      })
                    }

          <?php }
          ?>
        }

      }
      function stopVideo() {
        player.stopVideo()
      }
      var h = $('html').height();
      var w = $('html').width() + 200;


      function content(){
        var content = $('input').val()
        var $div = $('<div class="title">'+content+'</div>')
        $('#overlay-comment').append($div)
        $('input').val('')
        // var max = document.getElementById('player').offsetHeight;
        var rd = Math.random()
          rd = rd * h;
        $div.stop().animate({
            top: '0px'
          },10000,'linear',function(){
            $(this).remove();
            counter+=50
          })
        // var temp = setInterval(function () {
        //   $div.classList.add("title-transit")
        //   $div.addEventListener('webkitTransitionEnd', function(){
        //     console.log('ended')
        //     clearInterval(temp)
        //   }, false)
        // }, 100)) //1 second

        //submit form
        var xttp = new XMLHttpRequest()
        xttp.open("POST", 'post-comment.php', true)
        xttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded")

        var timeobj= document.getElementsByTagName("demo").innerHTML
        var userid= qs['email']
        var videoid = qs['q']
        console.log(userid, videoid)
        $.post("post-comment.php",{text:content, time: timeobj, user_id: userid, video_id: videoid}, function(data) {
          console.log(data)
        })
      }

      var scaleWindow = function(cur_timeframe, maxYT_timeframe) {
         var maxdx = window.innerWidth
        //  var mindx = 0
        //  var minTF = 0
         var maxTF = maxYT_timeframe
        //  return maxdx-0)*(cur_timeframe-0)/(maxTF-0)+0
         return maxdx*cur_timeframe/maxTF
      }

      function fire(text, time, playerTime, duration, counter) {
        console.log(text,time, playerTime)
        console.log('scaled', duration, scaleWindow(time, duration)) 
        playTime = document.getElementsByTagName("demo").innerHTML
        if (time>=playTime) {
          console.log(time, playTime)

          var $div = $('<div class="title">'+text+'</div>')
          $('#overlay-comment').append($div)
          var rd = Math.random();
            rd = rd * h;
          $div.stop().animate({
            top: '0px'
          },10000,'linear',function(){
            $(this).remove();
            counter+=50
          })
        }
      }

      function enter(x) {
        x.innerHTML = 'Fire'
      }
      function leave(x) {
        x.innerHTML = 'Ok'
      }

      var colors = 'e40066-fcec52-94e8b4-50c9ce-b47aea'.split('-')
      var comments = document.getElementById('overlay-comment')
      var maxHeight = parseFloat(window.getComputedStyle(comments).height)
      var initialHeight = 0
      var time = 1000

      $('#active-btn').mouseenter(function(){
        console.log('in')
        $('#overlay-comment').css('opacity','1')
      }).mouseleave(function(){
        console.log('out')
        $('#overlay-comment').css('opacity','0')
      })

      // var comment = function(text) {
      //   var color = Math.floor((Math.random() * (colors.length-1)) + 0)
      //   var comment = document.createElement('div')
      //   comment.style.color = color
      //   comment.textContent = text
      //   comment.className = 'title'
      //   comment.id = 'title'
      //   return comment
      // }

		</script>
    </body>
</html>
