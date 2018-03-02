<?php
$EM_CONF[$_EXTKEY] = array(
    'title' => 'Apache Solr for TYPO3 - Fluid Frontend Customizing',
    'description' => 'This extension shows, how to customize solrfluid with custom templates',
    'version' => '3.0.0',
    'state' => 'stable',
    'category' => 'plugin',
    'author' => 'Timo Hund, Markus Friedrich',
    'author_email' => 'timo.hund@dkd.de',
    'author_company' => 'dkd Internet Service GmbH',
    'module' => '',
    'uploadfolder' => 0,
    'createDirs' => '',
    'modify_tables' => '',
    'clearCacheOnLoad' => 0,
    'constraints' => array(
        'depends' => array(
            'scheduler' => '',
            'solr' => '8.0.0-',
            'extbase' => '8.7.0-9.1.99',
            'fluid' => '8.7.0-9.1.99',
            'typo3' => '8.7.0-9.1.99'
        ),
        'conflicts' => array(),
        'suggests' => array(
            'devlog' => '',
        ),
    ),
    'autoload' => array(
        'psr-4' => array(
            'ApacheSolrForTypo3\\Solrfluidexample\\' => 'Classes/',
            'ApacheSolrForTypo3\\Solrfluidexample\\Tests\\' => 'Tests/'
        )
    )
);
