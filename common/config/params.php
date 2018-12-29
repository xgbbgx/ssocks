<?php
return [
    'adminEmail' => 'admin@example.com',
    'supportEmail' => 'support@example.com',
    'user.passwordResetTokenExpire' => 3600,
    
    'oauth_conf'=>include __DIR__ . '/conf/oauth_conf.php',//oauth授权
    'user_conf'=>include __DIR__ . '/conf/user_conf.php',//用户配置
];
