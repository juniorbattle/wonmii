<?php

$contentHTML = '
  <nav class="pull-left">
      <ul>
          <li><a href="#">WonMii</a></li>
          <li><a href="#">Functionality</a></li>
      </ul>
  </nav>
  <div class="copyright pull-right">
      © <script>document.write(new Date().getFullYear())</script>, made with <i class="fa fa-heart heart"></i> by <a href="#">WonMii</a>
  </div>
  <div class="clearfix"></div>
';


$content->setEntityContent(
  $contentHTML
);
