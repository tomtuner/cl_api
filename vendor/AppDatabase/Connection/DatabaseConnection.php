<?php

/**
 * Description of DatabaseConnection
 *
 * @author Nikesh Hajari
 */

namespace AppDatabase\Connection;

class DatabaseConnection implements \AppDatabase\Connection\iConnection
{

    /**
     * @see iDatabaseManager::getConnection();
     */
    public function getConnection($databaseName)
    {
        if(!\Propel::isInit())
        {
            \Propel::init(__DIR__ . '../../ORM/conf/orm-conf.php');
        }
        
        return \Propel::getConnection($databaseName);
    }

}

?>
