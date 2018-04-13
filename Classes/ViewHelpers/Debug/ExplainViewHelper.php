<?php
namespace ApacheSolrForTypo3\Solrfluidexample\ViewHelpers\Debug;

/*
 * This file is part of the TYPO3 CMS project.
 *
 * It is free software; you can redistribute it and/or modify it under
 * the terms of the GNU General Public License, either version 2
 * of the License, or any later version.
 *
 * For the full copyright and license information, please read the
 * LICENSE.txt file that was distributed with this source code.
 *
 * The TYPO3 project - inspiring people to share!
 */

use ApacheSolrForTypo3\Solr\Domain\Search\ResultSet\Result\SearchResult;
use ApacheSolrForTypo3\Solr\Domain\Search\ResultSet\SearchResultSet;
use ApacheSolrForTypo3\Solr\ViewHelpers\AbstractSolrFrontendViewHelper;
use TYPO3Fluid\Fluid\Core\Rendering\RenderingContextInterface;
use TYPO3Fluid\Fluid\Core\ViewHelper\Traits\CompileWithRenderStatic;

/**
 * Class ExplainViewHelper
 *
 * @author Timo Hund <timo.hund@dkd.de>
 */
class ExplainViewHelper extends AbstractSolrFrontendViewHelper
{

    use CompileWithRenderStatic;

    /**
     * Initializes the arguments
     */
    public function initializeArguments()
    {
        parent::initializeArguments();
        $this->registerArgument('resultSet', SearchResultSet::class, 'ResultSet that is used to retrieve the explain', true);
        $this->registerArgument('result', SearchResult::class, 'Result to render the explain for', true);

    }

    /**
     * @param array $arguments
     * @param callable $renderChildrenClosure
     * @param RenderingContextInterface $renderingContext
     * @return string
     */
    public static function renderStatic(array $arguments, \Closure $renderChildrenClosure, RenderingContextInterface $renderingContext)
    {

            /** @var  $resultSet SearchResultSet */
        $resultSet = $arguments['resultSet'];
        if (is_null($resultSet) || is_null($resultSet->getUsedSearch())) {
            return 'no search was executed';
        }

            /** @var $result SearchResult */
        $result = $arguments['result'];
        $id = $result->getId();
        $explain = $resultSet->getUsedSearch()->getDebugResponse()->explain->{$id} ?? 'no explain available';
        return $explain;
    }
}