<?php include 'head.php'; ?>
    <div id="site-info" class="info">
      <p class="info-p">
        Tubbies is an envision of new video watching experience, which borrows the idea of the Japanese website Niconico
      </p>
      <div><img  class="info-img" src="images/niconico.png" alt="niconico"/></div>
    </div>
    <div class="search container-pushin">
      <div class="search-bar">
        <input type="text" id="searchtext" placeholder="Type Something..." autocomplete="off" class="form-control search-bar-field"/>
        <input type="submit" id="search" value="Search" class="form-control search-bar-field-btn"/>
      </div>
    </div>
    <div id="searchresult" class="search-result"></div>
    <?php include 'script.php'; ?>
  </body>
</html>
