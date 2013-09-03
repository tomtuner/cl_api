<?php

/**
 * Description of CLService
 *
 * @author Thomas DeMeo
 */

namespace CL\Service;

use AppCore\Service\Entity\iServiceEntity;
use AppCore\Exception\ServiceException;
use AppCore\Service\EventHookType;

class CLService extends \AppCore\Service\AbstractService implements \CL\Service\iCLService
{
	// Constants
    private $apiKeyConst = "74fcd9096f464af99e5b77dd48ceb00e";
    private $apiUserConst = "rit-ws-01";
    private $ipAddrConst = "129.21.35.181";
	
	// The link for new and debug api
	private $baseURL = "https://thelink.rit.edu/api/";
	// private $baseURL = "https://thelink.rit.edu/ws/";
	
    /**
     * CL Service Entitiy
     * @var CL\Service\CLServiceEntity
     */
    private $serviceEntity;

    /**
     * FMS Service Default Constructor
     * @param iServiceEntity $serviceEntity
     */
    public function __construct(iServiceEntity $serviceEntity)
    {
        $this->serviceEntity = $serviceEntity;
    }
	
    private function fetchData($url, $parameters){
            $requesturl = $url;
            $cnt            = 0;
           
            foreach($parameters as $key => $value){
                    $op   = ($cnt == 0 ? "?" : "&");
                    $url .= $op . $key . "=" . urlencode($value);
                    $cnt++;
            }
           
            //echo $url . "\r\n";
			// print_r(BASE_URL);
            // print_r($url);
            $session = curl_init($url);
            curl_setopt($session, CURLOPT_HEADER, false);
            curl_setopt($session, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($session, CURLOPT_HTTPHEADER, Array("Accept: text/xml"));
           
            $response = curl_exec($session);
			if (!$response) {
				// print_r("Curl Request Failed Error!");
				// $response=<<<XML
// 				<error>Request Error!
// 				</error>
// 				XML;
				$response = "<?xml version='1.0'?>";
		  		$response .= "<error>\n";

	      	    $response .= "</error>\n";
			    // print_r($response);
				return $response;
			}
			 // print_r($response);
            return $response;
    }
	
    private function getEvents($startdate, $enddate, $type){
            $time = time();
           
            // ob_end_flush();

            $parameters                     = $this -> buildHash();
			$parameters['startdate']		= $startdate;
			$parameters['enddate']			= $enddate;
			$parameters['type']				= $type;
			// $parameters['type']				= "campus only";
			
            // $parameters['id']               = 64382;
           
            // $parameters['pagesize'] = 500;
           
            $url = $this-> baseURL . "events";
			//$url = $this->baseURL . "test";
			// print_r($parameters);
			
			$fetchData = $this->fetchData($url, $parameters);
			// print_r($fetchData);
			
			// print_r($fetchData);
            $xmlData        = simplexml_load_string($fetchData);
           	if (!$xmlData) {
				print_r("XML DATA!\n");
				print_r($fetchData);

           	}
			// Data ready to load into xml2array
			// print_r($xmlData);
			
            $decoded    = $this -> xml2array($xmlData);
            // $events     = $this -> processArray($decoded);
			// print_r($decoded);
             // print "<pre>";
             // print var_dump($events);
             // print "</pre>";
			return $xmlData;        
    }
	
    private function getGUID() {
            // Get a MS style GUID since PHP uses UUIDs
            // GUID Format = EC3597BD-A1DE-B544-9F97-8611944356CC

            if (function_exists('com_create_guid')) {
                    return com_create_guid();
            } else {
                    mt_srand((double)microtime() * 10000);
                    $charid = strtoupper(md5(uniqid(rand(), TRUE)));
                    $hyphen = chr(45);
                    $uuid = substr($charid, 0, 8) . $hyphen . substr($charid, 8, 4) . $hyphen . substr($charid, 12, 4) . $hyphen . substr($charid, 16, 4) . $hyphen . substr($charid, 20, 12);

                    return $uuid;
            }
    }
   
    private function buildHash() {
            $guid = $this -> getGUID();
            $utc = round(microtime(true) * 1000);
            $utc = (int) $utc;
			
			// print "TIME1:\n";
			// print_r($utc);
			
			//print "TIME2:\n";
			//print_r($utc2);
			
            $prehash = $this -> apiUserConst . $this -> ipAddrConst . $utc . $guid . $this -> apiKeyConst;
            $hash = (string)md5($prehash);
            $parameters = array();

            // Required Parameters
            $parameters['apikey'] = $this -> apiUserConst;
            $parameters['time'] = $utc;
            $parameters['random'] = $guid;
            $parameters['hash'] = $hash;

            // Optional Parameters
            $parameters['pagesize'] = 500;
            // Max results

            return $parameters;
    }
	
	// Convert XMLResponse to Array
	
    public function xml2array(\SimpleXMLElement $parent) {
            $array = array();

        foreach ($parent as $name => $element) {
            ($node = & $array[$name]) && (1 === count($node) ? $node = array($node) : 1) && $node = & $node[];
   
            $node = $element->count() ? $this -> xml2array($element) : trim($element);
        }
   
        return $array;
	}
	
    public function processArray($events){
		// print_r($in);
            // $pageData               = $in['results']['page'];
        //     $itemData               = $in['results']['page']['items'];
        //     $returnData             = NULL;
        //    
        //     foreach($itemData as $key => $val){
        //             $holder = $itemData[$key];                     
        //            
        //             switch($key){
        //                     case "event":
        //                            
        //                     break;                                 
        //                            
        //                     case "member":
        //                             $curmem     = array();
        //                             $moc            = 0;
        //                             $start          = -1;
        //                             $reccnt         = intval($pageData['pageSize']) - 1;                                   
        //                                                            
        //                             for($i=$start;$i<$reccnt;$i++){                                
        //                                     if($i == -1){                                                  
        //                                             $memrecord      = $holder;
        //                                     } else {
        //                                             $memrecord      = $holder[$i];                                                         
        //                                     }
        //                                    
        //                                     $pcnt                                           = 0;
        //                                     $positions                                      = $memrecord['positions']['position'];                                                                                         
        //                                     $curmem[$moc]                           = array();                     
        //                                     $curmem[$moc]['position']       = array();
        //                                     $curmem[$moc]['position'][$pcnt] = array();
        //                                    
        //                                     foreach($positions as $pk => $pv){                                                                                                             
        //                                             if(!is_numeric($pk)){                                                          
        //                                                     $curmem[$moc]['position'][$pcnt]['pos_' . $pk] = $pv;
        //                                             } else {                                                               
        //                                                     $pos = $positions[$pk];
        //                                                     $pcnt++;
        //                                                    
        //                                                     foreach($pos as $ppk => $ppv){
        //                                                             $curmem[$moc]['position'][$pcnt]['pos_' . $ppk] = $ppv;
        //                                                     }                                                                                                                      
        //                                             }                                                      
        //                                     }
        //                                    
        //                                     foreach($memrecord as $hk => $hv){
        //                                             if(!is_numeric($hk) && $hk != "positions"){
        //                                                     $curmem[$moc][$hk] = $hv;                                                              
        //                                             }
        //                                     }
        //                                    
        //                                     $moc++;
        //                             }                                                                              
        //                    
        //                             return $curmem;
        //                     break;
        //                            
        //                     case "membership":
        //                            
        //                     break;
        //                    
        //                     case "organization":
        //                             $curorg     = array();
        //                             $coc            = 0;
        //                             $start          = -1;
        //                             $reccnt         = intval($pageData['totalItems']) - 1;                                 
        //                                                            
        //                             for($i=$start;$i<$reccnt;$i++){                                
        //                                     if($i == -1){                                                  
        //                                             $orgrecord      = $holder;
        //                                     } else {
        //                                             $orgrecord      = $holder[$i];                                                                                         
        //                                     }
        //                                    
        //                                     $address        = $orgrecord['addresses']['address'];
        //                                     $category       = $orgrecord['categories']['category'];
        //                                     $customfld      = $orgrecord['customfields']['customfield'];   
        //                                     array_splice($orgrecord, 0, 3);        
        //                                    
        //                                     $getcf          = false;
        //                                     $year           = "";
        //                                    
        //                                     foreach($customfld as $kcf => $vcf){
        //                                             if($kcf == "name"){
        //                                                     if($vcf == "Year Founded:"){
        //                                                             $getcf = true;
        //                                                     }
        //                                             }
        //                                                    
        //                                             if($getcf && $kcf == "values"){
        //                                                     $year = $customfld[$kcf]["string"];
        //                                                     break;
        //                                             }
        //                                     }
        //                                                                                    
        //                                     $curorg[$coc] = array();
        //                                    
        //                                     foreach($address as $ak => $av){
        //                                             $curorg[$coc]['adr_' . $ak] = $av;
        //                                     }
        //                                    
        //                                     foreach($category as $ck => $cv){
        //                                             $curorg[$coc]['cat_' . $ck] = $cv;
        //                                     }
        //                                    
        //                                     foreach($orgrecord as $hk => $hv){
        //                                             if(!is_numeric($hk)){
        //                                                     if($hk == "description"){
        //                                                             $hv = htmlspecialchars($hv);
        //                                                     }
        //                                                     $curorg[$coc][$hk] = $hv;                                                              
        //                                             }
        //                                            
        //                                     }
        //                                    
        //                                     if($year != ""){
        //                                             $curorg[$coc]['year'] = $year;
        //                                     }
        //                                     $coc++;
        //                             }                                                                              
        //                    
        //                             return $curorg;        
        //                     break;                                 
        //                      
        //             }
        //     }  
		return $events;    
    }
	
    /**
     *  Take a set of Events results from CL and parse into and RSS feed
     * 
     * @throws ServiceException 
     *
     * @return bool
     */
    public function parseEventsIntoRSS($events, $campus)
    {
		
		$eventsStart = $events->Items;
		$campusEvents	 = $campus->Items;
		// print_r($campusEvents);
		// print_r($eventsStart);
		
		$d = new \DOMDocument('1.0', 'utf-8');
		
		if ($eventsStart && $campusEvents)
		{
			
			//create rss header
			$rssElement = $d->createElement('rss');
			$rssElement->setAttribute('version', '2.0');
			$rssElement->setAttributeNS('http://www.w3.org/2000/xmlns/' ,'xmlns:atom', 'http://www.w3.org/2005/Atom');
			$rssRoot = $d->appendChild($rssElement);
			
			//create channel
			$c = $rssRoot->appendChild(new \DOMElement('channel'));
			
			//add channel title
			$cT = $c->appendChild(new \DOMElement('title'));
			$cT->appendChild(new \DOMText('EVR Events Feed'));
			
			//add channel description
			$cD = $c->appendChild(new \DOMElement('description'));
			$cD->appendChild(new \DOMText('EVR Upcoming Events - Campus Center for Life'));		
			// print_r("Start Here RSS 2");

			for($i = 0; $i < count($eventsStart->Event); $i++)
			{
				//create item
				$e = $c->appendChild(new \DOMElement('item'));
				
				//add title
				$title = $e->appendChild(new \DOMElement('title'));
				$title->appendChild(new \DOMCdataSection($eventsStart->Event[$i]->EventName));
				
				$link = $e->appendChild(new \DOMElement('link'));
				
				//add description
				$description = $e->appendChild(new \DOMElement('description'));
				$description->appendChild(new \DOMCdataSection($eventsStart->Event[$i]->Description));
				
				//add status
				$status = $e->appendChild(new \DOMElement('status'));
				$status->appendChild(new \DOMText("Y"));
				
				//add cost
				$cost = $e->appendChild(new \DOMElement('cost'));
				// $cost->appendChild(new \DOMText($r->getEventCost()));
				
				//add cname
				// $cname = $e->appendChild(new \DOMElement('cname'));
				// $cname->appendChild(new \DOMCdataSection($r->getEventResponsibleRepresentativeName()));
				
				//add cphone
				$cphone = $e->appendChild(new \DOMElement('cphone'));
				
				//add cemail
				$cemail = $e->appendChild(new \DOMElement('cemail'));
				// $cemail->appendChild(new \DOMCdataSection($r->getEventResponsibleRepresentativeEmailAddress()));
				
				//add ctty
				$ctty = $e->appendChild(new \DOMElement('ctty'));

				//add location
				$location = $e->appendChild(new \DOMElement('location'));
				$location->appendChild(new \DOMCdataSection($eventsStart->Event[$i]->LocationName));
				
				//add start date
				$startDate = $e->appendChild(new \DOMElement('startdate'));
				$startDate->appendChild(new \DOMText(date("M j Y g:00A", ((int)$eventsStart->Event[$i]->StartDateTime)/1000)));
				
				//add end date
				$endDate = $e->appendChild(new \DOMElement('enddate'));
				$endDate->appendChild(new \DOMText(date("M j Y g:00A", ((int)$eventsStart->Event[$i]->StartDateTime)/1000)));
				
				// print_r("Here");
				// $root .= '<item>';
// 				$root .= '<title>';
// 				
// 				$root .= $eventsStart->event[$i]->name;
// 				$root .= '</title>';
// 				
// 				$root .= '</item>';
			}
			
			for($i = 0; $i < count($campusEvents->Event); $i++)
			{
				//create item
				$e = $c->appendChild(new \DOMElement('item'));
				
				//add title
				$title = $e->appendChild(new \DOMElement('title'));
				$title->appendChild(new \DOMCdataSection($campusEvents->Event[$i]->EventName));
				
				$link = $e->appendChild(new \DOMElement('link'));
				
				//add description
				$description = $e->appendChild(new \DOMElement('description'));
				$description->appendChild(new \DOMCdataSection($campusEvents->Event[$i]->Description));
				
				//add status
				$status = $e->appendChild(new \DOMElement('status'));
				$status->appendChild(new \DOMText("Y"));
				
				//add cost
				$cost = $e->appendChild(new \DOMElement('cost'));
				// $cost->appendChild(new \DOMText($r->getEventCost()));
				
				//add cname
				// $cname = $e->appendChild(new \DOMElement('cname'));
				// $cname->appendChild(new \DOMCdataSection($r->getEventResponsibleRepresentativeName()));
				
				//add cphone
				$cphone = $e->appendChild(new \DOMElement('cphone'));
				
				//add cemail
				$cemail = $e->appendChild(new \DOMElement('cemail'));
				// $cemail->appendChild(new \DOMCdataSection($r->getEventResponsibleRepresentativeEmailAddress()));
				
				//add ctty
				$ctty = $e->appendChild(new \DOMElement('ctty'));

				//add location
				$location = $e->appendChild(new \DOMElement('location'));
				$location->appendChild(new \DOMCdataSection($campusEvents->Event[$i]->LocationName));
				
				//add start date
				$startDate = $e->appendChild(new \DOMElement('startdate'));
				$startDate->appendChild(new \DOMText(date("M j Y g:00A", ((int)$campusEvents->Event[$i]->StartDateTime)/1000)));
				
				//add end date
				$endDate = $e->appendChild(new \DOMElement('enddate'));
				$endDate->appendChild(new \DOMText(date("M j Y g:00A", ((int)$campusEvents->Event[$i]->EndDateTime)/1000)));

			}
		}
		// $root .= $events;
		// $xml = new \SimpleXMLElement('<root/>');
// 		array_flip($events);
// 		array_walk_recursive($events, array ($xml, 'addChild'));
// 		$root .= $xml->asXML();
// 		
		// $root .= '</channel>';
		// $root .= '</rss>';
		return $d->saveXML();
	}

    /**
     *  Query the CollegiateLink API 
     * 
     * @throws ServiceException 
     *
     * @return results of API query in XML format
     */
    public function queryEventsAPI($startdate, $enddate, $type)
    {
		
        //pre-add event
        $this->getEventManager()->trigger(__FUNCTION__ . EventHookType::PRE,
                $this, array('serviceEntity' => $this->serviceEntity));
		$eventsResults = $this->getEvents($startdate, $enddate, $type);
		// print_r("Events:");
		// print_r($eventsResults);
        /*$currentTimestamp = time();
        $apiTimestamp = $this->serviceEntity->getApiTimestamp();
        
        if (abs($currentTimestamp - $apiTimestamp) > 5) {
            throw new ServiceException('Invalid Timestamp');
        }
        
        $requestArray = array(
		    'responsibleRepresentativeName' => $this->serviceEntity->getResponsibleRepresentativeName(),
		    'responsibleRepresentativeEmail' => $this->serviceEntity->getResponsibleRepresentativeEmail(),
		    'responsibleRepresentativePhone' => $this->serviceEntity->getResponsibleRepresentativePhone(),
		    'eventName' => $this->serviceEntity->getEventName(),
		    'eventDescription' => $this->serviceEntity->getEventDescription(),
		    'eventBuildingNumber' => $this->serviceEntity->getEventBuildingNumber(),
		    'eventRoomNumber' => $this->serviceEntity->getEventRoomNumber(),
		    'eventOtherLocation' => $this->serviceEntity->getEventOtherLocation(),
		    'reservationStartTime' => $this->serviceEntity->getReservationStartTime(),
		    'eventStartTime' => $this->serviceEntity->getEventStartTime(),
		    'eventEndTime' => $this->serviceEntity->getEventEndTime(),
		    'reservationEndTime' => $this->serviceEntity->getReservationEndTime(),
		    'apiTimestamp' => (string)$this->serviceEntity->getApiTimestamp(),
		    );
		   */ 
		// $requestArrayString = implode("+", $requestArray);
		// $serverApiSignature = hash_hmac('sha256', $requestArrayString, 'ad22ef55-e1d7-44ed-bfd3-db9482308e15');
		
		// $clientApiSignature = $this->serviceEntity->getApiSignature();
		/*
		if ($serverApiSignature != $clientApiSignature) {
			throw new ServiceException('Invalid Signature');
		}
		*/
		// $fmsModel = new \FMS\Model\FMSModel;
		
		// $wasSuccessful = $fmsModel->create($this->serviceEntity);

        //post-add event
        $this->getEventManager()->trigger(__FUNCTION__ . EventHookType::POST,
                $this,
                array('serviceEntity' => $this->serviceEntity));
                
		
		return $eventsResults;
    }

}

?>