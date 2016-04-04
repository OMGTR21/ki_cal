<?php

if (!defined('TYPO3_MODE')) {
	die('Access denied.');
}

\TYPO3\CMS\Extbase\Utility\ExtensionUtility::configurePlugin(
	'Ki.' . $_EXTKEY,
	'Fecal',
	array(
		'Calendar' => 'show, list, new, create, edit, update, delete, changeMonth',
		'Event' => 'edit, list, delete, show, update, new, create, search',
		'Entry' => 'edit, list, delete, update, show, new, create, search',
		'CalendarSearch' => 'list, show',
		'ShowPublic' => 'list, show'
	),
	// non-cacheable actions
	array(
		'Event' => 'create, update, delete',
		'Entry' => 'create, update, delete',
		'Calendar' => 'create, update, delete',
		'CalendarSearch' => '',
		'ShowPublic' => ''
	)
);
