<?php
date_default_timezone_set("Asia/Mumbai");
$CurrentTime = time();
$DateTime = strftime("%B-%d-%Y  %H:%M:%S" , $CurrentTime);
echo $DateTime;
?>