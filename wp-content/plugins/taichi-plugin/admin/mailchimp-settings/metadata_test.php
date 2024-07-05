    <html>
      <head>
        <title>Oauth2 Tester</title>
      </head>
      <body>
      <pre>
<?php
require_once('MC_OAuth2Client.php');
require_once('MC_RestClient.php');
$session = array('access_token' => 'A_VALID_ACCESS_TOKEN', 'expires_in' => 0, 'scope' =>'', 'base_domain'=>'http://127.0.0.1/devs/creativenutritionmarketing', 'expires' => EXPIRES_FROM_RETRIEVING_ACCESS_TOKEN, 
                 'refresh_token' => '', 'secret' => '91e3f07f989927e54044a93ea85435bf', 'sig' => 'SIG_FROM_RETRIEVING_ACCESS_TOKEN'
                 );


$rest = new MC_RestClient($session);
$data = $rest->getMetadata();
?>
</pre>
           Here are the results of the metadata call: <?=print_r($data,true)?>

      </body>
    </html>

