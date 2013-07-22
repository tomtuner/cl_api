<?php

/**
 * Description of SearchQuery
 *
 * @author Nikesh Hajari
 */

namespace AppCore\Search;

class SearchQuery
{
    
    /**
     * AND Query Constant
     */
    const _AND = 'AND';
    
    /**
     * OR Query Constant
     */
    const  _OR = 'OR';
    
    /**
     * Search Criteria
     * 
     * array('fieldName' => 'fieldValue')
     * 
     * @var array 
     */
    private $searchCriteria;
    
    /**
     * Query Type
     * 
     * @var string 
     */
    private $queryType;
    
    /**
     * Set Search Criteria
     * 
     * @param string $query
     * @param string $fieldName
     */
    public function setSearchCriteria($fieldName, $query)
    {
        $this->fieldNames[$fieldName] = $query;
    }
    
    /**
     * Get Search Criteria
     * 
     * @return array
     */
    public function getSearchCriteria()
    {
        return $this->searchCriteria;
    }
    
    /**
     * Set Query Type
     * 
     * @param string $queryType
     */
    public function setQueryType($queryType)
    {
        $this->queryType = $queryType;
    }
    
    /**
     * Get Query Type
     * 
     * @return string
     */
    public function getQueryType()
    {
        return $this->queryType;
    }
    
    /**
     * Is Or Query
     * 
     * @return boolean
     */
    public function isOrQuery()
    {
        return $this->queryType === self::_OR;
    }
    
    /**
     * Is And Query
     * 
     * @return boolean
     */
    public function isAndQuery()
    {
        return $this->queryType === self::_AND;
    }
    
}

?>