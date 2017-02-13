<?php include 'head.php'; ?>
    <!-- 1. The <iframe> (and video player) will replace this <div> tag. -->
    <!-- <div id="player"></div> -->
        <div class="row">
          <div class="col-md-6 col-md-offset-3">
                <p><input type="hidden" id="email"/></p>
								<p><input type="text" id="searchtext" placeholder="Type Something..." autocomplete="off" class="form-control"/></p>
								<p><input type="submit" id="search" value="Search" class="form-control btn btn-primary w100" style="display:none;"/></p>
						<div id="searchresult">

            </div>
          </div>
				</div>
		</div>
    <?php include 'script.php'; ?>

  </body>
</html>
