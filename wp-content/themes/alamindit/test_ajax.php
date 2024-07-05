<?php
echo get_post_meta(4565,'_EventStartDate', true);
$date=date_create("2013-03-15");
date_add($date,date_interval_create_from_date_string("29 months"));
echo date_format($date,"Y-m-d");

?>
