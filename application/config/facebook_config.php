<?php

$config['facebook_app_id'] = '';
$config['facebook_app_secret'] = '';
$config['facebook_graph_version'] = 'v2.7';
$config['facebook_login_type']          = 'web';
$config['facebook_login_redirect_url']  = 'index.php/auth/loginfb';
$config['facebook_logout_redirect_url'] = 'index.php/logout';
$config['facebook_permissions']         = array('public_profile', 'publish_actions', 'email');
$config['facebook_auth_on_load']        = FALSE;
?>