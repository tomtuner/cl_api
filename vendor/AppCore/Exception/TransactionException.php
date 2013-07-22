<?php

/**
 * Description of TransactionException
 *
 * @author Nikesh Hajari
 */

namespace AppCore\Exception;

class TransactionException extends \Exception
{
    
    /**
     * Override constructor in Exception class
     * @public
     * @param string $message Exception Message
     * @param exception|null $previous Exception Object for Exception Chaining
     */
    public function __construct($message, $previous = NULL)
    {
        parent::__construct($message, 0, $previous);
    }
}

?>
