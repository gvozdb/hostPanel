<?php

$_lang['area_hostpanel_main'] = 'Основные';
$_lang['area_hostpanel_socket'] = 'Сокет';
$_lang['area_hostpanel_security'] = 'Безопасность';

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

$_lang['setting_hostpanel_secret'] = 'Секретный ключ в MODX и в modxPanelDaemon';
$_lang['setting_hostpanel_secret_desc'] = 'Укажите секретный ключ, который совпадает с тем, что указан в настройках (config.yaml) в переменной "secret" даймона. Это необходимо для безопасности.';