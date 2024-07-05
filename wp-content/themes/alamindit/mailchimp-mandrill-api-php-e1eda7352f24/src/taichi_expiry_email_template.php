<?php
require 'Mandrill.php';

$mandrill = new Mandrill('ULv1lw8ehJFIQZEiLoYAkg');

$message = array(
    'subject' => 'My subject',
    'from_email' => 'marc@example.com',
    'to' => array(array('email' => 'ittsel.ali@devsinc.com', 'name' => 'Marc')),
    );
echo "sg ok";
$template_name = 'Seated TCA';

$template_content = array(
    array(
        'name' => 'header',
        'content' => 'Hi  thanks for signing up.'),
    array(
        'name' => 'main',
        'content' => 'Copyright 2013.')

);
echo "ok all";
$response = $mandrill->messages->sendTemplate($template_name, $template_content, $message);
print_r($response);
?>
