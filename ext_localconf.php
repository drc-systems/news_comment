<?php
if (!defined('TYPO3_MODE')) {
	die('Access denied.');
}

\TYPO3\CMS\Extbase\Utility\ExtensionUtility::configurePlugin(
	'DRCSystems.' . $_EXTKEY,
	'Newscomment',
	array(
		'Comment' => 'new, list, create, search, searchcomments, reply',
	),
	// non-cacheable actions
	array(
		'Comment' => 'list, create, search',
	)
);

\TYPO3\CMS\Extbase\Utility\ExtensionUtility::configurePlugin(
    'DRCSystems.' . $_EXTKEY,
    'Newscommentajax',
    array(
        'Comment' => 'addrating',
    ),
    // non-cacheable actions
    array(
        'Comment' => 'addrating',
    )
);


$TYPO3_CONF_VARS['FE']['eID_include']['Newscommentajax'] = \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::extPath('news_comment').'Classes/Ajax/EidDispatcher.php';
