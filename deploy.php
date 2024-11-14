<?php
$dir = '/home4/sanashub/home4/sanasinvite.com/public_html/.dev132/wp-content/themes/sanas';
chdir($dir);
$output = shell_exec('git fetch --all && git reset --hard origin/main 2>&1');
echo "<pre>$output</pre>";
?>