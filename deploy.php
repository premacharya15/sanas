<?php
$dir = '/home4/sanashub/sit132.sanasinvite.com/wp-content/themes/sanas';
chdir($dir);
$output = shell_exec('git fetch --all && git reset --hard origin/main 2>&1');
echo "<pre>$output</pre>";
?>