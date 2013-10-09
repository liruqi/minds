<?php

    $user = elgg_get_logged_in_user_entity();

    $domain_link = "http://". $vars['domain'] . "/install.php?username=".urlencode($user->username) . "&name=".urlencode($user->name) . "&email=".urlencode($user->email);

?>

<div id="pingtest-results">
    <p>Testing <a href="<?php echo $domain_link; ?>"><?php echo $vars['domain']; ?></a>, one moment please...</p>
</div>
<div id="pingtest-fail" style=display:none;>
    <h1>Problem...</h1>
    <p>Unfortunately your new minds node (<?php echo $vars['domain']; ?>) could not be reached. If you are using a custom domain, it may be that you need to modify your DNS settings.</p>
    <h2>DNS details</h2>
    <div class="dns">
        <p><label>Domain:</label> <?php echo $vars['domain']; ?><br />
        <label>IP Address:</label> <?php echo $CONFIG->multisite_server_ip; ?></p>
    </div>
    
    <br />
    
    
    <p>If you believe this to be a mistake, you could try <a href="http://<?php echo $vars['domain']; ?>/install.php">going there anyway...</a></p>
</div>

<script>

    // Change message after a period of time
    setTimeout(function() {
          $('#pingtest-results').html('<p>Sorry, the test timed out trying to reach <?php echo $vars['domain'];?>. You could try <a href="http://<?php echo $vars['domain']; ?>/install.php">going there anyway...</a></p>');
    }, 10000);

    $(document).ready(function(){
        // Use YQL to bypass cross site restrictions, there is possibly a better way...
        $.getJSON("http://query.yahooapis.com/v1/public/yql?"+
        "q=select%20*%20from%20html%20where%20url%3D%22"+
        encodeURIComponent("http://<?php echo $vars['domain']; ?>/install.php")+"%22&format=json'&callback=?", function(data){
          if(data.results[0]){
              window.location = "<?php echo $domain_link; ?>";
          } else {
              
              $('#pingtest-results').fadeOut();
              $('#pingtest-fail').fadeIn();
          }
      });
    });
</script>