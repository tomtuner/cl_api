<?php

return array(
    'service_manager' => array(
        'services' => array(
            // Keys are the service names
            // Values are objects
           'DatabaseConnection' => new \AppDatabase\Connection\DatabaseConnection(),
        ),
    ),
);
?>