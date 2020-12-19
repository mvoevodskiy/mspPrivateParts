<?php
$xpdo_meta_map['mspPrivatePartsOrder']= array (
  'package' => 'mspprivateparts',
  'version' => '1.1',
  'table' => 'ms2_private_parts_orders',
  'extends' => 'xPDOObject',
  'tableMeta' => 
  array (
    'engine' => 'MyISAM',
  ),
  'fields' => 
  array (
    'local_id' => NULL,
    'token' => NULL,
  ),
  'fieldMeta' => 
  array (
    'local_id' => 
    array (
      'dbtype' => 'int',
      'phptype' => 'int',
      'precision' => '10',
      'null' => false,
      'index' => 'pk',
    ),
    'token' => 
    array (
      'dbtype' => 'varchar',
      'phptype' => 'text',
      'precision' => '255',
      'null' => false,
      'index' => 'pk',
    ),
  ),
  'indexes' => 
  array (
    'PRIMARY' => 
    array (
      'alias' => 'PRIMARY',
      'primary' => true,
      'unique' => false,
      'type' => 'BTREE',
      'columns' => 
      array (
        'local_id' => 
        array (
          'length' => '',
          'collation' => 'A',
          'null' => false,
        ),
        'token' => 
        array (
          'length' => '',
          'collation' => 'A',
          'null' => false,
        ),
      ),
    ),
  ),
  'aggregates' => 
  array (
    'Order' => 
    array (
      'class' => 'msOrder',
      'local' => 'local_id',
      'foreign' => 'id',
      'cardinality' => 'one',
      'owner' => 'foreign',
    ),
  ),
);
