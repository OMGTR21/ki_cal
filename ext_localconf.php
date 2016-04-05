<?php

if (!defined('TYPO3_MODE')) {
	die('Access denied.');
}

\TYPO3\CMS\Extbase\Utility\ExtensionUtility::configurePlugin(
	'Ki.' . $_EXTKEY,
	'Fecal',
	array(
		'Calendar' => 'show, list, new, create, edit, update, delete, changeMonth',
		'Event' => 'edit, update, create, search, delete',
		'Entry' => 'edit, update, create, search, delete',
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
