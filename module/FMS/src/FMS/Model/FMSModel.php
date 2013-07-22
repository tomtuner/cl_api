<?php

/**
 * FMSModel
 *
 * @author Sam Falconer
 */

namespace FMS\Model;

use FMS\Service\Entity\FMSServiceEntity;
use AppCore\Exception\ModelException;
use AppCore\Exception\TransactionException;

class FMSModel
{
    /**
     * Create Event
     * 
     * @param \FMS\Service\Entity\FMSServiceEntity $e
     * @return bool wasSuccessful
     * @throws ModelException
     */
    public function create(FMSServiceEntity $e)
    {
    	//ITS needs to install the Oracle PDO driver.
    	//We will use PDO when this becomes possible.
    	//$fmsConnection = new \PDO('oci:dbname=finsrv13', 'evr', 'gSgmxe56');
    
        $fmsConnection = oci_connect('evr', 'gSgmxe56', 'finsrv13');

        try
        {	        	
        	$fmsString = "call afm.add_project(
        	:pTitle,
        	:pd_rec,
        	:pRequester,
        	:pReq_dept,
        	:pPhone,
        	:pEmail,
        	:pBldg,
        	:pbl_mnemonic,
        	:pfl_id,
        	:proom,
        	:plocation,
        	:pProj_desc,
        	:pAcct,
        	:pddue,
        	to_date(:ptResStart,'DD-MON-YY HH24:MI'),
        	to_date(:ptResEnd,'DD-MON-YY HH24:MI'),
        	to_date(:ptEventStart,'DD-MON-YY HH24:MI'),
        	to_date(:ptEventEnd,'DD-MON-YY HH24:MI')
        	)";
        	
        	$emptyString = "";

            $dateFormatString = "d-M-y";
            $dateTimeFormatString = "d-M-y H:i";
        	
        	$currentDateString = date($dateFormatString);

            $dueDateString = date($dateFormatString, $e->getReservationStartTime());

            $reservationStartTimeString = date($dateTimeFormatString, $e->getReservationStartTime());
            $reservationEndTimeString = date($dateTimeFormatString, $e->getReservationEndTime());
            $eventStartTimeString = date($dateTimeFormatString, $e->getEventStartTime());
            $eventEndTimeString = date($dateTimeFormatString, $e->getEventEndTime());
        	
        	$fmsOci = oci_parse($fmsConnection, $fmsString);
        	
        	oci_bind_by_name($fmsOci, ":pTitle", $e->getEventName());
        	oci_bind_by_name($fmsOci, ":pd_rec", $currentDateString);
        	oci_bind_by_name($fmsOci, ":pRequester", $e->getResponsibleRepresentativeName());
        	oci_bind_by_name($fmsOci, ":pReq_dept", $emptyString);
        	oci_bind_by_name($fmsOci, ":pPhone", $e->getResponsibleRepresentativePhone());
        	oci_bind_by_name($fmsOci, ":pEmail", $e->getResponsibleRepresentativeEmail());
        	oci_bind_by_name($fmsOci, ":pBldg", $e->getEventBuildingNumber());
        	oci_bind_by_name($fmsOci, ":pbl_mnemonic", $emptyString);
        	oci_bind_by_name($fmsOci, ":pfl_id", $emptyString);
        	oci_bind_by_name($fmsOci, ":proom", $e->getEventRoomNumber());
        	oci_bind_by_name($fmsOci, ":plocation", $e->getEventOtherLocation());
        	oci_bind_by_name($fmsOci, ":pProj_desc", $e->getEventDescription());
        	oci_bind_by_name($fmsOci, ":pAcct", $emptyString);
        	oci_bind_by_name($fmsOci, ":pddue", $dueDateString);
        	oci_bind_by_name($fmsOci, ":ptResStart", $reservationStartTimeString);
        	oci_bind_by_name($fmsOci, ":ptResEnd", $reservationEndTimeString);
        	oci_bind_by_name($fmsOci, ":ptEventStart", $eventStartTimeString);
        	oci_bind_by_name($fmsOci, ":ptEventEnd", $eventEndTimeString);
           	
           	oci_execute($fmsOci);
           	
           	oci_close($fmsConnection);
           	
        	return true;
        } 
        catch(\Exception $e) 
        {
            throw new ModelException('Error Creating Event in FMS Database', $e);
        }
    }
}

?>