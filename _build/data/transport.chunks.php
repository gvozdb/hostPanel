<?php

$chunks = [];

$tmp = [
    // 'tpl.hostPanel.item' => array(
    // 	'file' => 'item',
    // 	'description' => '',
    // ),
    // 'tpl.hostPanel.office' => array(
    // 	'file' => 'office',
    // 	'description' => '',
    // ),
];

// Save chunks for setup options
$BUILD_CHUNKS = [];

foreach ($tmp as $k => $v) {
    /* @avr modChunk $chunk */
    $chunk = $modx->newObject('modChunk');
    $chunk->fromArray([
        'id' => 0,
        'name' => $k,
        'description' => @$v['description'],
        'snippet' => file_get_contents($sources['source_core'] . '/elements/chunks/chunk.' . $v['file'] . '.tpl'),
        'static' => BUILD_CHUNK_STATIC,
        'source' => 1,
        'static_file' => 'core/components/' . PKG_NAME_LOWER . '/elements/chunks/chunk.' . $v['file'] . '.tpl',
    ], '', true, true);

    $chunks[] = $chunk;

    $BUILD_CHUNKS[$k] = file_get_contents($sources['source_core'] . '/elements/chunks/chunk.' . $v['file'] . '.tpl');
}

unset($tmp);
return $chunks;