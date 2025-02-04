<?php

if ($object->xpdo) {
    /** @var modX $modx */
    $modx = &$object->xpdo;

    switch ($options[xPDOTransport::PACKAGE_ACTION]) {
        case xPDOTransport::ACTION_INSTALL:
        case xPDOTransport::ACTION_UPGRADE:

            $class = 'hostPanelSettings';
            $settings = [
                [
                    'key' => 'php',
                    'parent' => '',
                    'value' => '5.6',
                ],
                [
                    'key' => 'php',
                    'parent' => '',
                    'value' => '7.0',
                ],
                [
                    'key' => 'php',
                    'parent' => '',
                    'value' => '7.1',
                ],
                [
                    'key' => 'php',
                    'parent' => '',
                    'value' => '7.2',
                ],
                [
                    'key' => 'php',
                    'parent' => '',
                    'value' => '7.3',
                ],
                [
                    'key' => 'php',
                    'parent' => '',
                    'value' => '7.4',
                ],
                [
                    'key' => 'cms',
                    'parent' => '',
                    'value' => 'Без CMS==',
                ],
                [
                    'key' => 'cms',
                    'parent' => '',
                    'value' => 'MODX Revolution==modx',
                ],
                [
                    'key' => 'version',
                    'parent' => 'modx',
                    'value' => '2.3.6-pl',
                ],
                [
                    'key' => 'version',
                    'parent' => 'modx',
                    'value' => '2.4.2-pl',
                ],
                [
                    'key' => 'version',
                    'parent' => 'modx',
                    'value' => '2.4.3-pl',
                ],
                [
                    'key' => 'version',
                    'parent' => 'modx',
                    'value' => '2.4.4-pl',
                ],
                [
                    'key' => 'version',
                    'parent' => 'modx',
                    'value' => '2.5.0-pl',
                ],
                [
                    'key' => 'version',
                    'parent' => 'modx',
                    'value' => '2.5.1-pl',
                ],
                [
                    'key' => 'version',
                    'parent' => 'modx',
                    'value' => '2.5.2-pl',
                ],
                [
                    'key' => 'version',
                    'parent' => 'modx',
                    'value' => '2.5.4-pl',
                ],
                [
                    'key' => 'version',
                    'parent' => 'modx',
                    'value' => '2.5.5-pl',
                ],
                [
                    'key' => 'version',
                    'parent' => 'modx',
                    'value' => '2.5.6-pl',
                ],
                [
                    'key' => 'version',
                    'parent' => 'modx',
                    'value' => '2.5.7-pl',
                ],
                [
                    'key' => 'version',
                    'parent' => 'modx',
                    'value' => '2.5.8-pl',
                ],
                [
                    'key' => 'version',
                    'parent' => 'modx',
                    'value' => '2.6.0-pl',
                ],
                [
                    'key' => 'version',
                    'parent' => 'modx',
                    'value' => '2.6.1-pl',
                ],
                [
                    'key' => 'version',
                    'parent' => 'modx',
                    'value' => '2.6.2-pl',
                ],
                [
                    'key' => 'version',
                    'parent' => 'modx',
                    'value' => '2.6.3-pl',
                ],
                [
                    'key' => 'version',
                    'parent' => 'modx',
                    'value' => '2.6.4-pl',
                ],
                [
                    'key' => 'version',
                    'parent' => 'modx',
                    'value' => '2.6.5-pl',
                ],
                [
                    'key' => 'version',
                    'parent' => 'modx',
                    'value' => '2.7.0-pl',
                ],
                [
                    'key' => 'version',
                    'parent' => 'modx',
                    'value' => '2.7.1-pl',
                ],
                [
                    'key' => 'version',
                    'parent' => 'modx',
                    'value' => '2.7.2-pl',
                ],
                [
                    'key' => 'version',
                    'parent' => 'modx',
                    'value' => '2.7.3-pl',
                ],
                [
                    'key' => 'version',
                    'parent' => 'modx',
                    'value' => '2.8.0-pl',
                ],
                [
                    'key' => 'version',
                    'parent' => 'modx',
                    'value' => '2.8.1-pl',
                ],
                [
                    'key' => 'version',
                    'parent' => 'modx',
                    'value' => '2.8.2-pl',
                ],
                [
                    'key' => 'version',
                    'parent' => 'modx',
                    'value' => '2.8.3-pl',
                ],
                [
                    'key' => 'version',
                    'parent' => 'modx',
                    'value' => '2.8.4-pl',
                ],
                [
                    'key' => 'version',
                    'parent' => 'modx',
                    'value' => '2.8.5-pl',
                ],
                [
                    'key' => 'version',
                    'parent' => 'modx',
                    'value' => '2.8.6-pl',
                ],
                [
                    'key' => 'version',
                    'parent' => 'modx',
                    'value' => '2.8.7-pl',
                ],
                [
                    'key' => 'version',
                    'parent' => 'modx',
                    'value' => '2.8.8-pl',
                ],
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
            ];

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