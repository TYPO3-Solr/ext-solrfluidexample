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

use ApacheSolrForTypo3\Solr\Domain\Search\ResultSet\SearchResultSet;
use ApacheSolrForTypo3\Solr\ViewHelpers\AbstractSolrFrontendViewHelper;
use TYPO3Fluid\Fluid\Core\Rendering\RenderingContextInterface;
use TYPO3Fluid\Fluid\Core\ViewHelper\Traits\CompileWithRenderStatic;

/**
 * Class QueryUrlViewHelper
 *
 * @author Timo Hund <timo.hund@dkd.de>
 */
class QueryUrlViewHelper extends AbstractSolrFrontendViewHelper
{

    use CompileWithRenderStatic;

    /**
     * Initializes the arguments
     */
    public function initializeArguments()
    {
        parent::initializeArguments();
        $this->registerArgument('resultSet', SearchResultSet::class, 'ResultSet to build the query for', true);
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

        $readConnection = $resultSet->getUsedSearch()->getSolrConnection()->getReadService();

        $searchRequest= $resultSet->getUsedSearchRequest();
        $resultsPerPage = (int)$searchRequest->getResultsPerPage();
        $offsetMultiplier = max(0, $searchRequest->getPage() - 1);
        $offSet = $offsetMultiplier * $resultsPerPage;

        $query = $resultSet->getUsedQuery();
        $arguments = $query->getQueryParameters();
        $arguments['q'] =  (string)$query->getQueryStringContainer()->getQueryString();
        $arguments['start'] = $offSet;
        $arguments['rows'] =  $query->getRows();
        $arguments['debugQuery'] = 'on';

        $coreEndpoint = (string) $readConnection;
        $query = self::getQuery($arguments);
        return $coreEndpoint . 'select?' . $query;
    }

    /**
     * @param array $parameters
     * @return mixed
     */
    protected static function getQuery($parameters)
    {
        $queryString = http_build_query($parameters, null, '&');
        return preg_replace('/%5B(?:[0-9]|[1-9][0-9]+)%5D=/', '=', $queryString);
    }
}