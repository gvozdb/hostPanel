<?php
$xpdo_meta_map['hostPanelSettings']= [
    'package' => 'hostpanel',
    'version' => '1.1',
    'table' => 'hostpanel_settings',
    'extends' => 'xPDOSimpleObject',
    'tableMeta' =>
  [
    'engine' => 'MyISAM',
  ],
    'fields' =>
  [
    'key' => '',
    'parent' => '',
    'value' => '',
  ],
    'fieldMeta' =>
  [
      'key' =>
    [
      'dbtype' => 'varchar',
      'precision' => '100',
      'phptype' => 'string',
      'null' => false,
      'default' => '',
    ],
      'parent' =>
    [
      'dbtype' => 'varchar',
      'precision' => '100',
      'phptype' => 'string',
      'null' => true,
      'default' => '',
    ],
      'value' =>
    [
      'dbtype' => 'text',
      'phptype' => 'string',
      'null' => true,
      'default' => '',
    ],
  ],
    'indexes' =>
  [
      'key' =>
    [
        'alias' => 'key',
        'primary' => false,
        'unique' => false,
        'type' => 'BTREE',
        'columns' =>
      [
          'key' =>
        [
          'length' => '',
          'collation' => 'A',
          'null' => false,
        ],
      ],
    ],
      'parent' =>
    [
        'alias' => 'parent',
        'primary' => false,
        'unique' => false,
        'type' => 'BTREE',
        'columns' =>
      [
          'parent' =>
        [
          'length' => '',
          'collation' => 'A',
          'null' => false,
        ],
      ],
    ],
  ],
];
