<?php
/** @var xPDOTransport $transport */
/** @var array $options */
/** @var modX $modx */

if ($transport->xpdo) {
    $modx =& $transport->xpdo;

    switch ($options[xPDOTransport::PACKAGE_ACTION]) {
        case xPDOTransport::ACTION_INSTALL:
        case xPDOTransport::ACTION_UPGRADE:
            if (!empty($options['settings']) && !empty($options['update_settings'])) {
                foreach ($options['update_settings'] as $k => $v) {
                    if (!empty($v) && $setting = $modx->getObject('modSystemSetting', array('key' => $k))) {
                        $setting->set('value', $v);
                        $setting->save();

                        $modx->log(modX::LOG_LEVEL_INFO, 'Updated system setting "<b>' . $k . '</b>"');
                    }
                }
            }
            break;

        case xPDOTransport::ACTION_UNINSTALL:
            break;
    }
}

return true;