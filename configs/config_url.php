<?php

$config['base_url'] = ((isset($_SERVER['HTTP_X_FORWARDED_PROTO']) && $_SERVER['HTTP_X_FORWARDED_PROTO'] == "https") ? "https" : "http");
$config['base_url'] .= "://" . $_SERVER['SERVER_NAME'] . ($config['base_url']  == 'http' ?  '' : '') . '/';

$actual_link = (empty($_SERVER['HTTP_X_FORWARDED_PROTO']) ? 'http' : 'https') . "://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
