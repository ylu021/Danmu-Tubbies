<?php include 'head.php'; ?>
    <!-- 1. The <iframe> (and video player) will replace this <div> tag. -->
    <!-- <div id="player"></div> -->
    <div class="row">
				<div class="col-md-6 col-md-offset-3">
            <p class="pre-auth">
                  Please authorize to continue using
                  <div class="g-signin2" data-onsuccess="onSignIn" data-theme="dark"></div>
            </p>

              <header class="post-auth">
                <div class="row">
                  <div class="col-md-6 text-right"></div>
                  <div class="col-md-6 text-right">
                    <a href="#" onclick="signOut()">Log Out</a>
                    <a href="#" onclick="disassociate();">Disassociate App and Site (easily undone)</a>

                  </div>
                </div>

              </header>

						<!-- <form action="#"> -->
                <p><input type="hidden" id="email"/></p>
								<p><input type="text" id="searchtext" placeholder="Type Something..." autocomplete="off" class="form-control"/></p>
								<p><input type="submit" id="search" value="Search" disabled class="form-control btn btn-primary w100"/></p>
						<!-- </form> -->
						<div id="searchresult">

            </div>
				</div>
		</div>
    <script src="https://code.jquery.com/jquery-3.1.1.slim.min.js"></script>
    <script src="hmac-md5.js"></script>
    <script src="auth.js"></script>
    <script src="search.js"></script>
    <script src="https://apis.google.com/js/client.js?onload=googleApiClientReady"></script>
    <script>
    function signOut() {
        var auth2 = gapi.auth2.getAuthInstance();
        auth2.signOut().then(function () {
            console.log('User signed out.');

        });
      }
      function disassociate() {
        var auth2 = gapi.auth2.getAuthInstance();
        auth2.disconnect().then(function () {
            console.log('User disconnected from association with app.')
          })
      }

    </script>
  </body>
</html>
