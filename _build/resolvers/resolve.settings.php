<?php

if ($object->xpdo) {
    /** @var modX $modx */
    $modx = &$object->xpdo;

    switch ($options[xPDOTransport::PACKAGE_ACTION]) {
        case xPDOTransport::ACTION_INSTALL:
        case xPDOTransport::ACTION_UPGRADE:

            $class = 'hostPanelSettings';
            $settings = array(
                array(
                    'key' => 'php',
                    'parent' => '',
                    'value' => '5.6',
                ),
                array(
                    'key' => 'php',
                    'parent' => '',
                    'value' => '7.0',
                ),
                array(
                    'key' => 'php',
                    'parent' => '',
                    'value' => '7.1',
                ),
                array(
                    'key' => 'php',
                    'parent' => '',
                    'value' => '7.2',
                ),
                array(
                    'key' => 'php',
                    'parent' => '',
                    'value' => '7.3',
                ),
                array(
                    'key' => 'php',
                    'parent' => '',
                    'value' => '7.4',
                ),
                array(
                    'key' => 'cms',
                    'parent' => '',
                    'value' => 'Без CMS==',
                ),
                array(
                    'key' => 'cms',
                    'parent' => '',
                    'value' => 'MODX Revolution==modx',
                ),
                array(
                    'key' => 'version',
                    'parent' => 'modx',
                    'value' => '2.3.6-pl',
                ),
                array(
                    'key' => 'version',
                    'parent' => 'modx',
                    'value' => '2.4.2-pl',
                ),
                array(
                    'key' => 'version',
                    'parent' => 'modx',
                    'value' => '2.4.3-pl',
                ),
                array(
                    'key' => 'version',
                    'parent' => 'modx',
                    'value' => '2.4.4-pl',
                ),
                array(
                    'key' => 'version',
                    'parent' => 'modx',
                    'value' => '2.5.0-pl',
                ),
                array(
                    'key' => 'version',
                    'parent' => 'modx',
                    'value' => '2.5.1-pl',
                ),
                array(
                    'key' => 'version',
                    'parent' => 'modx',
                    'value' => '2.5.2-pl',
                ),
                array(
                    'key' => 'version',
                    'parent' => 'modx',
                    'value' => '2.5.4-pl',
                ),
                array(
                    'key' => 'version',
                    'parent' => 'modx',
                    'value' => '2.5.5-pl',
                ),
                array(
                    'key' => 'version',
                    'parent' => 'modx',
                    'value' => '2.5.6-pl',
                ),
                array(
                    'key' => 'version',
                    'parent' => 'modx',
                    'value' => '2.5.7-pl',
                ),
                array(
                    'key' => 'version',
                    'parent' => 'modx',
                    'value' => '2.5.8-pl',
                ),
                array(
                    'key' => 'version',
                    'parent' => 'modx',
                    'value' => '2.6.0-pl',
                ),
                array(
                    'key' => 'version',
                    'parent' => 'modx',
                    'value' => '2.6.1-pl',
                ),
                array(
                    'key' => 'version',
                    'parent' => 'modx',
                    'value' => '2.6.2-pl',
                ),
                array(
                    'key' => 'version',
                    'parent' => 'modx',
                    'value' => '2.6.3-pl',
                ),
                array(
                    'key' => 'version',
                    'parent' => 'modx',
                    'value' => '2.6.4-pl',
                ),
                array(
                    'key' => 'version',
                    'parent' => 'modx',
                    'value' => '2.6.5-pl',
                ),
                array(
                    'key' => 'version',
                    'parent' => 'modx',
                    'value' => '2.7.0-pl',
                ),
                array(
                    'key' => 'version',
                    'parent' => 'modx',
                    'value' => '2.7.1-pl',
                ),
                array(
                    'key' => 'version',
                    'parent' => 'modx',
                    'value' => '2.7.2-pl',
                ),
                array(
                    'key' => 'version',
                    'parent' => 'modx',
                    'value' => '2.7.3-pl',
                ),
                array(
                    'key' => 'version',
                    'parent' => 'modx',
                    'value' => '2.8.0-pl',
                ),
                array(
                    'key' => 'version',
                    'parent' => 'modx',
                    'value' => '2.8.1-pl',
                ),
                // array(
                //     'key' => 'layout',
                //     'parent' => 'modx',
                //     'value' => 'Рутина==routine',
                // ),
                // array(
                //     'key' => 'layout',
                //     'parent' => 'modx',
                //     'value' => 'Рутина мультиязык==routine_multilang',
                // ),
            );

            foreach ($settings as $data) {
                if (!$modx->getCount($class, $data)) {
                    $obj = $modx->newObject($class);
                    $obj->fromArray($data);
                    $obj->save();

                    $modx->log(modX::LOG_LEVEL_INFO, 'Add setting "<b>' . $data['key'] . '</b>: ' . $data['value'] . '"');
                }
            }

            break;

        case xPDOTransport::ACTION_UNINSTALL:
            break;
    }
}

return true;