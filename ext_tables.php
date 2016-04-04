<?php
if (!defined('TYPO3_MODE')) {
	die('Access denied.');
}

\TYPO3\CMS\Extbase\Utility\ExtensionUtility::registerPlugin(
	'Ki.' . $_EXTKEY,
	'Fecal',
	'Calendar'
);

\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addStaticFile($_EXTKEY, 'Configuration/TypoScript', 'Calendar');

\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addLLrefForTCAdescr('tx_kical_domain_model_event', 'EXT:ki_cal/Resources/Private/Language/locallang_csh_tx_kical_domain_model_event.xlf');
\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::allowTableOnStandardPages('tx_kical_domain_model_event');

\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addLLrefForTCAdescr('tx_kical_domain_model_entry', 'EXT:ki_cal/Resources/Private/Language/locallang_csh_tx_kical_domain_model_entry.xlf');
\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::allowTableOnStandardPages('tx_kical_domain_model_entry');

\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addLLrefForTCAdescr('tx_kical_domain_model_calendar', 'EXT:ki_cal/Resources/Private/Language/locallang_csh_tx_kical_domain_model_calendar.xlf');
\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::allowTableOnStandardPages('tx_kical_domain_model_calendar');

\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addLLrefForTCAdescr('tx_kical_domain_model_calendarsearch', 'EXT:ki_cal/Resources/Private/Language/locallang_csh_tx_kical_domain_model_calendarsearch.xlf');
\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::allowTableOnStandardPages('tx_kical_domain_model_calendarsearch');

\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addLLrefForTCAdescr('tx_kical_domain_model_showpublic', 'EXT:ki_cal/Resources/Private/Language/locallang_csh_tx_kical_domain_model_showpublic.xlf');
\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::allowTableOnStandardPages('tx_kical_domain_model_showpublic');
