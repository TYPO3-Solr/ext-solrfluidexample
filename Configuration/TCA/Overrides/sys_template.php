<?php
if (!defined('TYPO3_MODE')) {
    die('Access denied.');
}

// Add TypoScript templates
\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addStaticFile(
    'solrfluidexample',
    'Configuration/TypoScript/Templates/',
    'Search - Solrfluid use custom templates from solrfluidexample'
);
