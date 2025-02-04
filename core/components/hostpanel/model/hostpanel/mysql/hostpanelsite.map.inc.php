<?php
$xpdo_meta_map['hostPanelSite']= [
    'package' => 'hostpanel',
    'version' => '1.1',
    'table' => 'hostpanel_sites',
    'extends' => 'xPDOSimpleObject',
    'tableMeta' =>
  [
    'engine' => 'MyISAM',
  ],
    'fields' =>
  [
    'idx' => 0,
    'name' => '',
    'description' => '',
    'group' => '',
    'user' => '',
    'site' => '',
    'status' => '',
    'php' => '',
    'cms' => '',
    'version' => '',
    'layout' => '',
    'sftp_port' => 22,
    'sftp_user' => '',
    'sftp_pass' => '',
    'mysql_site' => '',
    'mysql_db' => '',
    'mysql_user' => '',
    'mysql_pass' => '',
    'mysql_table_prefix' => '',
    'connectors_site' => '',
    'manager_site' => '',
    'manager_user' => '',
    'manager_pass' => '',
    'path' => '',
    'active' => 1,
    'lock' => 0,
  ],
    'fieldMeta' =>
  [
      'idx' =>
    [
      'dbtype' => 'integer',
      'precision' => '10',
      'phptype' => 'integer',
      'attributes' => 'unsigned',
      'null' => false,
      'default' => 0,
    ],
      'name' =>
    [
      'dbtype' => 'varchar',
      'precision' => '100',
      'phptype' => 'string',
      'null' => false,
      'default' => '',
    ],
      'description' =>
    [
      'dbtype' => 'text',
      'phptype' => 'text',
      'null' => true,
      'default' => '',
    ],
      'group' =>
    [
      'dbtype' => 'varchar',
      'precision' => '100',
      'phptype' => 'string',
      'null' => false,
      'default' => '',
    ],
      'user' =>
    [
      'dbtype' => 'varchar',
      'precision' => '100',
      'phptype' => 'string',
      'null' => false,
      'default' => '',
    ],
      'site' =>
    [
      'dbtype' => 'varchar',
      'precision' => '100',
      'phptype' => 'string',
      'null' => false,
      'default' => '',
    ],
      'status' =>
    [
      'dbtype' => 'varchar',
      'precision' => '100',
      'phptype' => 'string',
      'null' => false,
      'default' => '',
    ],
      'php' =>
    [
      'dbtype' => 'varchar',
      'precision' => '5',
      'phptype' => 'string',
      'null' => false,
      'default' => '',
    ],
      'cms' =>
    [
      'dbtype' => 'varchar',
      'precision' => '100',
      'phptype' => 'string',
      'null' => false,
      'default' => '',
    ],
      'version' =>
    [
      'dbtype' => 'varchar',
      'precision' => '100',
      'phptype' => 'string',
      'null' => false,
      'default' => '',
    ],
      'layout' =>
    [
      'dbtype' => 'varchar',
      'precision' => '100',
      'phptype' => 'string',
      'null' => false,
      'default' => '',
    ],
      'sftp_port' =>
    [
      'dbtype' => 'integer',
      'precision' => '10',
      'phptype' => 'integer',
      'attributes' => 'unsigned',
      'null' => false,
      'default' => 22,
    ],
      'sftp_user' =>
    [
      'dbtype' => 'varchar',
      'precision' => '100',
      'phptype' => 'string',
      'null' => false,
      'default' => '',
    ],
      'sftp_pass' =>
    [
      'dbtype' => 'varchar',
      'precision' => '100',
      'phptype' => 'string',
      'null' => false,
      'default' => '',
    ],
      'mysql_site' =>
    [
      'dbtype' => 'varchar',
      'precision' => '100',
      'phptype' => 'string',
      'null' => false,
      'default' => '',
    ],
      'mysql_db' =>
    [
      'dbtype' => 'varchar',
      'precision' => '100',
      'phptype' => 'string',
      'null' => false,
      'default' => '',
    ],
      'mysql_user' =>
    [
      'dbtype' => 'varchar',
      'precision' => '100',
      'phptype' => 'string',
      'null' => false,
      'default' => '',
    ],
      'mysql_pass' =>
    [
      'dbtype' => 'varchar',
      'precision' => '100',
      'phptype' => 'string',
      'null' => false,
      'default' => '',
    ],
      'mysql_table_prefix' =>
    [
      'dbtype' => 'varchar',
      'precision' => '100',
      'phptype' => 'string',
      'null' => false,
      'default' => '',
    ],
      'connectors_site' =>
    [
      'dbtype' => 'varchar',
      'precision' => '100',
      'phptype' => 'string',
      'null' => false,
      'default' => '',
    ],
      'manager_site' =>
    [
      'dbtype' => 'varchar',
      'precision' => '100',
      'phptype' => 'string',
      'null' => false,
      'default' => '',
    ],
      'manager_user' =>
    [
      'dbtype' => 'varchar',
      'precision' => '100',
      'phptype' => 'string',
      'null' => false,
      'default' => '',
    ],
      'manager_pass' =>
    [
      'dbtype' => 'varchar',
      'precision' => '100',
      'phptype' => 'string',
      'null' => false,
      'default' => '',
    ],
      'path' =>
    [
      'dbtype' => 'varchar',
      'precision' => '100',
      'phptype' => 'string',
      'null' => false,
      'default' => '',
    ],
      'active' =>
    [
      'dbtype' => 'tinyint',
      'precision' => '1',
      'phptype' => 'boolean',
      'null' => true,
      'default' => 1,
    ],
      'lock' =>
    [
      'dbtype' => 'tinyint',
      'precision' => '1',
      'phptype' => 'boolean',
      'null' => true,
      'default' => 0,
    ],
  ],
    'indexes' =>
  [
      'name' =>
    [
        'alias' => 'name',
        'primary' => false,
        'unique' => false,
        'type' => 'BTREE',
        'columns' =>
      [
          'name' =>
        [
          'length' => '',
          'collation' => 'A',
          'null' => false,
        ],
      ],
    ],
      'group' =>
    [
        'alias' => 'group',
        'primary' => false,
        'unique' => false,
        'type' => 'BTREE',
        'columns' =>
      [
          'group' =>
        [
          'length' => '',
          'collation' => 'A',
          'null' => false,
        ],
      ],
    ],
      'user' =>
    [
        'alias' => 'user',
        'primary' => false,
        'unique' => false,
        'type' => 'BTREE',
        'columns' =>
      [
          'user' =>
        [
          'length' => '',
          'collation' => 'A',
          'null' => false,
        ],
      ],
    ],
      'site' =>
    [
        'alias' => 'site',
        'primary' => false,
        'unique' => false,
        'type' => 'BTREE',
        'columns' =>
      [
          'site' =>
        [
          'length' => '',
          'collation' => 'A',
          'null' => false,
        ],
      ],
    ],
      'status' =>
    [
        'alias' => 'status',
        'primary' => false,
        'unique' => false,
        'type' => 'BTREE',
        'columns' =>
      [
          'status' =>
        [
          'length' => '',
          'collation' => 'A',
          'null' => false,
        ],
      ],
    ],
      'cms' =>
    [
        'alias' => 'cms',
        'primary' => false,
        'unique' => false,
        'type' => 'BTREE',
        'columns' =>
      [
          'cms' =>
        [
          'length' => '',
          'collation' => 'A',
          'null' => false,
        ],
      ],
    ],
      'version' =>
    [
        'alias' => 'version',
        'primary' => false,
        'unique' => false,
        'type' => 'BTREE',
        'columns' =>
      [
          'version' =>
        [
          'length' => '',
          'collation' => 'A',
          'null' => false,
        ],
      ],
    ],
      'layout' =>
    [
        'alias' => 'layout',
        'primary' => false,
        'unique' => false,
        'type' => 'BTREE',
        'columns' =>
      [
          'layout' =>
        [
          'length' => '',
          'collation' => 'A',
          'null' => false,
        ],
      ],
    ],
      'sftp_port' =>
    [
        'alias' => 'sftp_port',
        'primary' => false,
        'unique' => false,
        'type' => 'BTREE',
        'columns' =>
      [
          'sftp_port' =>
        [
          'length' => '',
          'collation' => 'A',
          'null' => false,
        ],
      ],
    ],
      'sftp_user' =>
    [
        'alias' => 'sftp_user',
        'primary' => false,
        'unique' => false,
        'type' => 'BTREE',
        'columns' =>
      [
          'sftp_user' =>
        [
          'length' => '',
          'collation' => 'A',
          'null' => false,
        ],
      ],
    ],
      'sftp_pass' =>
    [
        'alias' => 'sftp_pass',
        'primary' => false,
        'unique' => false,
        'type' => 'BTREE',
        'columns' =>
      [
          'sftp_pass' =>
        [
          'length' => '',
          'collation' => 'A',
          'null' => false,
        ],
      ],
    ],
      'mysql_site' =>
    [
        'alias' => 'mysql_site',
        'primary' => false,
        'unique' => false,
        'type' => 'BTREE',
        'columns' =>
      [
          'mysql_site' =>
        [
          'length' => '',
          'collation' => 'A',
          'null' => false,
        ],
      ],
    ],
      'mysql_db' =>
    [
        'alias' => 'mysql_db',
        'primary' => false,
        'unique' => false,
        'type' => 'BTREE',
        'columns' =>
      [
          'mysql_db' =>
        [
          'length' => '',
          'collation' => 'A',
          'null' => false,
        ],
      ],
    ],
      'mysql_user' =>
    [
        'alias' => 'mysql_user',
        'primary' => false,
        'unique' => false,
        'type' => 'BTREE',
        'columns' =>
      [
          'mysql_user' =>
        [
          'length' => '',
          'collation' => 'A',
          'null' => false,
        ],
      ],
    ],
      'mysql_pass' =>
    [
        'alias' => 'mysql_pass',
        'primary' => false,
        'unique' => false,
        'type' => 'BTREE',
        'columns' =>
      [
          'mysql_pass' =>
        [
          'length' => '',
          'collation' => 'A',
          'null' => false,
        ],
      ],
    ],
      'mysql_table_prefix' =>
    [
        'alias' => 'mysql_table_prefix',
        'primary' => false,
        'unique' => false,
        'type' => 'BTREE',
        'columns' =>
      [
          'mysql_table_prefix' =>
        [
          'length' => '',
          'collation' => 'A',
          'null' => false,
        ],
      ],
    ],
      'connectors_site' =>
    [
        'alias' => 'connectors_site',
        'primary' => false,
        'unique' => false,
        'type' => 'BTREE',
        'columns' =>
      [
          'connectors_site' =>
        [
          'length' => '',
          'collation' => 'A',
          'null' => false,
        ],
      ],
    ],
      'manager_site' =>
    [
        'alias' => 'manager_site',
        'primary' => false,
        'unique' => false,
        'type' => 'BTREE',
        'columns' =>
      [
          'manager_site' =>
        [
          'length' => '',
          'collation' => 'A',
          'null' => false,
        ],
      ],
    ],
      'manager_user' =>
    [
        'alias' => 'manager_user',
        'primary' => false,
        'unique' => false,
        'type' => 'BTREE',
        'columns' =>
      [
          'manager_user' =>
        [
          'length' => '',
          'collation' => 'A',
          'null' => false,
        ],
      ],
    ],
      'manager_pass' =>
    [
        'alias' => 'manager_pass',
        'primary' => false,
        'unique' => false,
        'type' => 'BTREE',
        'columns' =>
      [
          'manager_pass' =>
        [
          'length' => '',
          'collation' => 'A',
          'null' => false,
        ],
      ],
    ],
      'path' =>
    [
        'alias' => 'path',
        'primary' => false,
        'unique' => false,
        'type' => 'BTREE',
        'columns' =>
      [
          'path' =>
        [
          'length' => '',
          'collation' => 'A',
          'null' => false,
        ],
      ],
    ],
  ],
];
