<?php
$sessionId = session_id();
if(empty($sessionId)) $session               = new Session(360); #CACHE DE 180 mins
