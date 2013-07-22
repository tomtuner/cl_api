<?php

/**
 * Description of CLServiceEntity
 *
 * @author Thomas DeMeo
 */

namespace CL\Service\Entity;

class CLServiceEntity extends \AppCore\Service\Entity\AbstractServiceEntity
{   
    /**
     * Get Responsible Representative Name
     * 
     * @return string 
     */
    public function getStartDate()
    {
        return $this->getProperty('startdate');
    }
	
    /**
     * Get Responsible Representative Name
     * 
     * @return string 
     */
    public function getEndDate()
    {
        return $this->getProperty('enddate');
    }
	
    /**
     * Get Responsible Representative Name
     * 
     * @return string 
     */
    public function getResponsibleRepresentativeName()
    {
        return $this->getProperty('responsibleRepresentativeName');
    }

    /**
     * Get Responsible Representative Email
     * 
     * @return string 
     */
    public function getResponsibleRepresentativeEmail()
    {
        return $this->getProperty('responsibleRepresentativeEmail');
    }

    /**
     * Get Responsible Representative Phone
     * 
     * @return string 
     */
    public function getResponsibleRepresentativePhone()
    {
        return $this->getProperty('responsibleRepresentativePhone');
    }

    /**
     * Get Event Name
     * 
     * @return string 
     */
    public function getEventName()
    {
        return $this->getProperty('eventName');
    }

    /**
     * Get Event Building Number
     * 
     * @return string 
     */
    public function getEventBuildingNumber()
    {
        return $this->getProperty('eventBuildingNumber');
    }
    
    /**
     * Get Event Room Number
     * 
     * @return string 
     */
    public function getEventRoomNumber()
    {
        return $this->getProperty('eventRoomNumber');
    }
    
    /**
     * Get Event Other Location 
     * 
     * @return string 
     */
    public function getEventOtherLocation()
    {
        return $this->getProperty('eventOtherLocation');
    }
    
    /**
     * Get Event Description
     * 
     * @return string 
     */
    public function getEventDescription()
    {
        return $this->getProperty('eventDescription');
    }

    /**
     * Get Reservation Start Time
     * 
     * @return int 
     */
    public function getReservationStartTime()
    {
        return $this->getProperty('reservationStartTime');
    }

    /**
     * Get Event Start Time
     * 
     * @return string 
     */
    public function getEventStartTime()
    {
        return $this->getProperty('eventStartTime');
    }

    /**
     * Get Event End Time
     * 
     * @return string 
     */
    public function getEventEndTime()
    {
        return $this->getProperty('eventEndTime');
    }

    /**
     * Get Reservation End Time
     * 
     * @return string 
     */
    public function getReservationEndTime()
    {
        return $this->getProperty('reservationEndTime');
    }
    
    /**
     * Get API Timestamp
     * 
     * @return int 
     */
    public function getApiTimestamp()
    {
        return (int)$this->getProperty('apiTimestamp');
    }
    
    /**
     * Get API Hash
     * 
     * @return string 
     */
    public function getApiSignature()
    {
        return $this->getProperty('apiSignature');
    }
}

?>