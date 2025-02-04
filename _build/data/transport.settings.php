<?php
$BUILD_SETTINGS = [];
$settings = [];
$tmp = [
    'secret' => [
        'xtype' => 'textfield',
        'area' => 'security',
        'value' => 'DHJKGFksdjfghjsldFHgsyiwur89ug783rgdkhs',
    ],

    'host_domain' => [
        'xtype' => 'textfield',
        'area' => 'main',
        'value' => 'host.ru',
    ],
    'user_mask' => [
        'xtype' => 'textfield',
        'area' => 'main',
        'value' => 'u[[+id]]',
    ],
    'domain_mask' => [
        'xtype' => 'textfield',
        'area' => 'main',
        'value' => '[[+user]].h.host.ru',
    ],

    'socket_host' => [
        'xtype' => 'textfield',
        'area' => 'socket',
        'value' => 'localhost',
    ],
    'socket_port' => [
        'xtype' => 'textfield',
        'area' => 'socket',
        'value' => '9999',
    ],
];

foreach ($tmp as $k => $v) {
    $key = 'hostpanel_' . $k;

    /* @var modSystemSetting $setting */
    $setting = $modx->newObject('modSystemSetting');
    $setting->fromArray(array_merge([
        'key' => $key,
        'namespace' => PKG_NAME_LOWER,
    ], $v), '', true, true);

    $settings[] = $setting;
    $BUILD_SETTINGS[$key] = $setting->get('value');
}

unset($tmp);
return $settings;