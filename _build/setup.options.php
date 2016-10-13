<?php

$integrate = false;
$output = '';

switch ($options[xPDOTransport::PACKAGE_ACTION]) {
    case xPDOTransport::ACTION_INSTALL:
    case xPDOTransport::ACTION_UPGRADE:
        $integrate = true;
        break;

    case xPDOTransport::ACTION_UNINSTALL:
        break;
}

if ($integrate) {
    $_lang['setting_hostpanel_host_domain'] = 'Домен для поддоменов хоста';
    $_lang['setting_hostpanel_host_domain_desc'] = 'Например, "h1.domain.ru". В итоге получим основные домены сайтов, вида: "[[+user]].h1.domain.ru".';
    $_lang['setting_hostpanel_user_mask'] = 'Маска для генерации имени пользователя';
    $_lang['setting_hostpanel_user_mask_desc'] = 'Например, "u[[+id]]". В итоге получим имена пользователей типа: "u22". Плейсхолдеры: id, username, name.';
    $_lang['setting_hostpanel_domain_mask'] = 'Маска для формирования домена';
    $_lang['setting_hostpanel_domain_mask_desc'] = 'Можно использовать [[+user]], [[+name]], [[+id]]';
    $_lang['setting_hostpanel_socket_host'] = 'Хост сокета';
    $_lang['setting_hostpanel_socket_host_desc'] = 'Хост, на котором установлен даймон';
    $_lang['setting_hostpanel_socket_port'] = 'Порт сокета';
    $_lang['setting_hostpanel_socket_port_desc'] = 'Порт, на котором висит даймон';

    switch ($modx->getOption('manager_language')) {
        case 'ru':
            break;
        default:
    }

    if (!empty($options['attributes']['settings'])) {
        foreach ($options['attributes']['settings'] as $k => $value) {
            if ($setting = $modx->getObject('modSystemSetting', array('key' => $k))) {
                $value = $setting->get('value');
            }

            $output .= '<label for="hostPanel-' . $k . '">' . $_lang['setting_' . $k] . ':</label>
                <input type="text" name="update_settings[' . $k . ']" id="hostPanel-' . $k . '" value="' . $value . '" />
                ' . $_lang['setting_' . $k . '_desc'] . '
                <br /><br />';
        }
    }
}

return $output;