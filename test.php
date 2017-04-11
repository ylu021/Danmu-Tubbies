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
          <button class="comment-btn" id="btn" onmouseover="enter(this)" onmouseleave="leave(this)">ready</button>
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
      // console.log('port?', window.location.host)
      var socket = io.connect('https://cryptic-citadel-20273.herokuapp.com')
      var danmaku = {}
      // var socket = io()
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
        var myTimer = null
        if (event.data == YT.PlayerState.PLAYING) {
          //retrieve from database
          <?php
                while($row = $stmt->fetch( PDO::FETCH_ASSOC )){
          ?>
                var comment = "<?php echo $row['comment_text']; ?>"
                var time = "<?php echo $row['comment_time']; ?>"
                if(danmaku.hasOwnProperty(time)){
                  danmaku[time].push(comment)
                }else {
                  danmaku[time] = [comment]
                }

                // fire(danmaku)
                    // danmaku
                    // fire(comment, time, Math.floor(player.getCurrentTime()), Math.floor(player.getDuration ()), counter)
                    // counter+=100
                    //
                    // if (player.getPlayerState() == 2){
                    //   console.log('video is paused')
                    //   $('#overlay-comment').find('#title').each(function(){
                    //     console.log($(this))
                    //     $(this).stop()
                    //   })
                    // }

          <?php }
          ?>
          console.log('danmaku is', danmaku)
          //get currenttime in integer and fire
          myTimer = setInterval(function(){
            var time;
            document.getElementsByTagName("demo").innerHTML = Math.floor(player.getCurrentTime())
            var timeobj = document.getElementsByTagName("demo").innerHTML
            if(danmaku.hasOwnProperty(timeobj))
              fireAll(danmaku)
          }, 100); // 100 means repeat in 100 ms

          //button click
          document.getElementById('btn').addEventListener("click", function() {
            console.log(document.getElementsByTagName("demo").innerHTML)
            var timeobj = document.getElementsByTagName("demo").innerHTML
            var userid= decodeURIComponent(atob(qs['email']))
            console.log('time or rubbish', timeobj)
            var videoid = qs['q']
            var content = $('input').val()
            $.post("post-comment.php",{text:content, time: timeobj, user_id: userid, video_id: videoid}, function(data) {
              console.log('done posting', data)
              socket.emit('message', {text: content, user_id: userid})
            })

          })

          $('#btntext').keypress(function(e){
            if(e.keyCode==13)
              $('#btn').click();
          });
        }
        else{
          //paused
          clearInterval(myTimer)
        }
      }

      function fireAll(danmaku) {
          console.log('firing', danmaku)
          var fireevent = null
          Object.keys(danmaku).forEach(function(key) {
            for(var text of danmaku[key]) {
              var $div = $('<div class="title">'+text+'</div>')
              $('#overlay-comment').append($div)
              $div.stop().animate({
                  top: '0px'
                },10000,'linear',function(){
                  $(this).remove();
                  // counter+=50
                })
              })
            }
            clearInterval(fireevent)
          })
      }

      function stopVideo() {
        player.stopVideo()
      }
      var h = $('html').height();
      var w = $('html').width() + 200;


      // $('#btn').on('click', function(e){
      //   // console.log('socket?', socket)
      //   //submit form
      //   // var timeobj= document.getElementsByTagName("demo").innerHTML
      //   // var userid= decodeURIComponent(atob(qs['email']))
      //   // console.log('email or rubbish', userid)
      //   // var videoid = qs['q']
      //   // var content = $('input').val()
      //   // $.post("post-comment.php",{text:content, time: timeobj, user_id: userid, video_id: videoid}, function(data) {
      //   //   console.log('done posting', data)
      //   //   socket.emit('message', {text: content, user_id: userid})
      //   // })
      // })

      socket.on('incoming', function(data) {
        //listens for broadcast
        var $div = $('<div class="title">'+data.text+':'+data.user_id+'</div>')
        $('#overlay-comment').append($div)
        $('input').val('')
        $div.stop().animate({
            top: '0px'
          },10000,'linear',function(){
            $(this).remove();
            // counter+=50
          })
        })
      socket.on('error', function(){ console.log('err')})

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

      // $('#active-btn').mouseenter(function(){
      //   $('#overlay-comment').css('opacity','1')
      // }).mouseleave(function(){
      //   $('#overlay-comment').css('opacity','0')
      // })

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
