<?php
include 'database-read.php';
?>

<!DOCTYPE html>
<html lang="en">
		<head>
			<meta charset="UTF-8">
			<title>Danmu Project</title>
			<link rel="stylesheet" href="style.css">

		</head>
		<body>
			<div id="container">
				<div id="youtube_container">
				</div>

			</div>
			<footer>
				<input type="text" placeholder="输入你想说的东西">
				<button id="btn" onClick="content()" onmouseover="enter(this)" onmouseleave="leave(this)">准备</button>
				<!-- <h4>Get current Time = </h4> -->
				<p id="demo"></p>

			</footer>
		</body>
    <script src="https://code.jquery.com/jquery-3.1.1.min.js"></script>

		<script>
		// 2. This code loads the IFrame Player API code asynchronously.
	      var tag = document.createElement('script');

	      tag.src = "https://www.youtube.com/iframe_api";
	      var firstScriptTag = document.getElementsByTagName('script')[0];
	      firstScriptTag.parentNode.insertBefore(tag, firstScriptTag);

	      // 3. This function creates an <iframe> (and YouTube player)
	      //    after the API code downloads.
	      var player;
        var qs = (function(a) {
          if (a == "") return {};
          var b = {};
          for (var i = 0; i < a.length; ++i)
          {
              var p=a[i].split('=', 2);
              if (p.length == 1)
                  b[p[0]] = "";
              else
                  b[p[0]] = decodeURIComponent(p[1].replace(/\+/g, " "));
          }
          return b;
        })(window.location.search.substr(1).split('&'));
	      function onYouTubeIframeAPIReady() {
          // var videoID =
          // console.log(videoID)

	        player = new YT.Player('youtube_container', {
	          height: '390',
	          width: '640',
	          videoId: qs['q'],
	          events: {
	            'onReady': onPlayerReady,
	            'onStateChange': onPlayerStateChange
	          }
	        });
	      }

	      // 4. The API will call this function when the video player is ready.
	      function onPlayerReady(event) {
	        event.target.playVideo();
	      }


		// player.addEventListener(YT.PlayerState.PLAYING, onVideoPlaying, false);

		// function onVideoPlaying() {
		//   console.log('currentTime:', player.getCurrentTime(), 'duration:', player.getDuration());
		// }

	      function onPlayerStateChange(event) {
	        if (event.data == YT.PlayerState.PLAYING) {
	          // setTimeout(stopVideo, 6000);
	          //done = true;
	          document.getElementsByTagName("demo").innerHTML = player.getCurrentTime();
	        }
	      }
	      function stopVideo() {
	        player.stopVideo();
	      }
		var h = $('html').height();
		var w = $('html').width() + 200;

		function content(){
			var content = $('input').val();
			$('input').val('');
			var $div = $('<div class="title">'+content+'</div>')
			$('#container').append($div)
			var rd = Math.random();
				rd = rd * h;
			$div.css('top',rd).stop().animate({
				left:'-300px'
			},10000,'linear',function(){
				$(this).remove()
			})

      //submit form
      var xttp = new XMLHttpRequest()
      xttp.open("POST", 'post-comment.php', true)
      xttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded")

      var timeobj= document.getElementsByTagName("demo").innerHTML
      var userid= qs['email']
      var videoid = qs['q']
      console.log(userid, videoid)
      $.post("post-comment.php",{text:content, time:timeobj, user_id: userid, video_id: videoid}, function(data) {
        console.log(data)
      });

      // $.post("post-comment.php", {text:content, time:timeobj, user_id: userid, video_id: videoid});
      // // console.log(obj)
      // xttp.onreadystatechange = function () {
      //   if (xttp.readyState == 4 && xttp.status == 200) {
      //     alert(xttp.responseText)
      //   }
      // }
      //console.log("text="content, timeobj, userid, videoid)
      // xttp.send(
      //   "text="+content+
      //   "&time="+timeobj+
      //   "&user_id="+userid+
      //   "&video_id="videoid+" "
      // )
		}

		function meow(){
			var display = $('input').val();
				$('input').val('');

		}
		function enter(x){
			x.innerHTML = '发射'
		}
		function leave(x){
			x.innerHTML = '准备'
		}

		</script>
</html>
