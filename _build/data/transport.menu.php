<?php

$menus = [];

$tmp = [
    'hostpanel' => [
        'description' => 'hostpanel_menu_desc',
        'action' => [
			'controller' => 'index',
        ],
    ],
];

$i = 0;
foreach ($tmp as $k => $v) {
	$action = null;
	if (!empty($v['action'])) {
		/* @var modAction $action */
		$action = $modx->newObject('modAction');
		$action->fromArray(array_merge([
			'namespace' => PKG_NAME_LOWER,
			'id' => 0,
			'parent' => 0,
			'haslayout' => 1,
			'lang_topics' => PKG_NAME_LOWER . ':default',
			'assets' => '',
        ], $v['action']), '', true, true);
		unset($v['action']);
	}

	/* @var modMenu $menu */
	$menu = $modx->newObject('modMenu');
	$menu->fromArray(array_merge(
		[
			'text' => $k,
			'parent' => 'components',
			'icon' => 'images/icons/plugin.gif',
			'menuindex' => $i,
			'params' => '',
			'handler' => '',
        ], $v
	), '', true, true);

	if (!empty($action) && $action instanceof modAction) {
		$menu->addOne($action);
	}

	$menus[] = $menu;
	$i++;
}

unset($action, $menu, $i);
return $menus;