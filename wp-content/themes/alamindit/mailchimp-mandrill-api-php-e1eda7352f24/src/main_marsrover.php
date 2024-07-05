<?php
require 'Mandrill.php';

$mandrill = new Mandrill('ULv1lw8ehJFIQZEiLoYAkg');
$message = array(
    'subject' => 'My subject',
    'from_email' => 'marc@example.com',
    'to' => array(array('email' => 'ittsel.ali@devsinc.com', 'name' => 'Marc')),
    );
$template_name = 'Seated TCA';
$template_content = array(
    array(
        'name' => 'certify',
        'content' => 'Ittsel Ali'),
    array(
        'name' => 'held',
        'content' => 'Held on:    29-09-2009'),
    array(
        'name' => 'location',
        'content' => 'Location:   Lahore'),			
    array(
        'name' => 'mt',
        'content' => 'Ittsel Ali'));
$response = $mandrill->messages->sendTemplate($template_name, $template_content, $message);
print_r($response);
?>
