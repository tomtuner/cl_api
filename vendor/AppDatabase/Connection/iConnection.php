<?php

/**
 * Description of iConnection
 *
 * @author Nikesh Hajari
 */

namespace AppDatabase\Connection;

interface iConnection
{
    
    /**
     * Get Connection
     * 
     * @return \Propel\PDO
     */
    public function getConnection($databaseName);
    
}

?>
