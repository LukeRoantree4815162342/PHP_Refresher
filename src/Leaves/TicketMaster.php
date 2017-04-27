<?php
/**
 * Created by PhpStorm.
 * User: craig
 * Date: 9/10/16
 * Time: 7:06 PM
 */

namespace HackTheHub\Leaves;


use HackTheHub\Models\Event\Event;
use Rhubarb\Crown\Http\CurlHttpClient;
use Rhubarb\Crown\Http\HttpRequest;

class TicketMaster
{
    private $baseUrl = 'https://app.ticketmaster.com/discovery/v2/events.json?city=belfast';
    private $apiKey = '&apikey=Dplndqi756zULINCrKCZdlVJMuta41sz';

    public function __construct()
    {
        $this->getEvents();
    }

    public function getEvents()
    {
        $url = $this->baseUrl . $this->apiKey;
        $response = $this->sendRequest($url, 'get');

        if($response->getResponseCode() == 200)
        {
            $events = json_decode($response->getResponseBody());

            foreach($events->_embedded->events as $event)
            {
                $newEvent = new Event();
                $newEvent->Name = $event->name;
                $newEvent->Description = '';
                $newEvent->DateTimeStart = $event->dates->start->localDate . ' ' . $event->dates->start->localTime;
                $newEvent->DateTimeEnd = $event->dates->start->localDate . ' 23:59:59';
                $newEvent->CategoryID = 7;
                $newEvent->TicketLink = $event->url;

                $newEvent->Latitude = '';
                $newEvent->Longitude = '';
                $newEvent->save();
            }
        }
    }

    private function sendRequest($url, $method = 'get')
    {
        $request = new HttpRequest($url, $method);
        $curlHandler = new CurlHttpClient();

        return $curlHandler->getResponse($request);
    }
}