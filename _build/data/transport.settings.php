<?php

$BUILD_SETTINGS = array();
$settings = array();
$tmp = array(
    'host_domain' => array(
        'xtype' => 'textfield',
        'area' => 'main',
        'value' => 'host.ru',
    ),
    'user_mask' => array(
        'xtype' => 'textfield',
        'area' => 'main',
        'value' => 'u[[+id]]',
    ),
    'domain_mask' => array(
        'xtype' => 'textfield',
        'area' => 'main',
        'value' => '[[+user]].h.host.ru',
    ),

    'socket_host' => array(
        'xtype' => 'textfield',
        'area' => 'socket',
        'value' => 'localhost',
    ),
    'socket_port' => array(
        'xtype' => 'textfield',
        'area' => 'socket',
        'value' => '9999',
    ),
);

foreach ($tmp as $k => $v) {
    $key = 'hostpanel_' . $k;

    /* @var modSystemSetting $setting */
    $setting = $modx->newObject('modSystemSetting');
    $setting->fromArray(array_merge(array(
        'key' => $key,
        'namespace' => PKG_NAME_LOWER,
    ), $v), '', true, true);

    $settings[] = $setting;
    $BUILD_SETTINGS[$key] = $setting->get('value');
}

unset($tmp);
return $settings;