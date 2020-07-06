<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
error_reporting(E_ERROR); ?>

<div class="content_luar">
  <div class="content_dalam">
    <iframe src="http://<?= str_replace("/","",str_replace("http","",$url)); ?>" width="100%" height="590px" frameborder="0"></iframe>
  </div>
</div>


<!--
<div class="content_luar">
  <div class="content_dalam">
  
<form id="login" target="frame" method="post" action="http://<?str_replace("/","",str_replace("http","",$url)); ?>">
    <input type="hidden" name="username" value="login" />
    <input type="hidden" name="password" value="pass" />
</form>

<iframe id="frame" name="frame"  width="100%" height="590px" frameborder="0"></iframe>

  </div>
</div>

<script type="text/javascript">
    // submit the form into iframe for login into remote site
    document.getElementById('login').submit();

    // once you're logged in, change the source url (if needed)
    var iframe = document.getElementById('frame');
    iframe.onload = function() {
        if (iframe.src != "http://<?str_replace("/","",str_replace("http","",$url)); ?>") {
            iframe.src = "http://<?str_replace("/","",str_replace("http","",$url)); ?>";
        }
    }
</script>-->