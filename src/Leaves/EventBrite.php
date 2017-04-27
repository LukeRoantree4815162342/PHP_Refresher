<?php
/**
 * Created by PhpStorm.
 * User: craig
 * Date: 9/10/16
 * Time: 2:15 PM
 */

namespace HackTheHub\Leaves;

use HackTheHub\Models\Event\Event;
use Rhubarb\Crown\Http\CurlHttpClient;
use Rhubarb\Crown\Http\HttpRequest;
use Rhubarb\Stem\Filters\Equals;

class EventBrite
{
    private $oauthToken = "Y5VZCJACLKIAVSOACQFF";
    private $baseUrl = "https://www.eventbriteapi.com/v3";
    private $distanceString = "&location.latitude=54.6005571000&location.longitude=-5.8798087000&location.within=100mi";

    private $categories = array(
        'Food' => 110,
        'Music' => 103
    );

    private $musicSubcategories = array(
        'Country' => 3004,
        'Hip hop' => 3008,
        'Jazz' => 3002,
        'Pop' => 3013,
        'Reggae' => 3015,
        'R&B' => 3014,
        'Rock' => 3017,
        'Alternative' => 3001,
        'Metal' => 3011
    );

    public function __construct()
    {
        $this->getFoodEvents();
        $this->getMusicEvents();
    }

    public function getFoodEvents()
    {
        // https://www.eventbriteapi.com/v3/events/search/?location.latitude=54.6005571000&location.longitude=-5.8798087000&location.within=100mi&categories=103&token=Y5VZCJACLKIAVSOACQFF
        $url = $this->baseUrl . "/events/search/?categories={$this->categories['Food']}&{$this->distanceString}&token={$this->oauthToken}";
        $response = $this->sendRequest($url, 'get');
        $this->saveNewEvents($response, 1);
    }

    public function getMusicEvents()
    {
        $url = $this->baseUrl . "/events/search/?categories={$this->categories['Music']}&{$this->distanceString}&token={$this->oauthToken}";
        $response = $this->sendRequest($url, 'get');
        $this->saveNewEvents($response, 7);
    }

    public function getEventsByCity($city)
    {
        $url = $this->baseUrl . "/events/search/?venue.city={$city}&token={$this->oauthToken}";
        $response = $this->sendRequest($url, 'get');
        $this->saveNewEvents($response);
    }

    private function saveNewEvents($response, $categoryID)
    {
        if ($response->getResponseCode() == 200) {
            $events = json_decode($response->getResponseBody());

            foreach ($events->events as $event) {
                $newEvent = new Event();
                $newEvent->Name = $event->name->text;
                $newEvent->Description = $event->description->text;
                $newEvent->DateTimeStart = str_replace('T', ' ', $event->start->local);
                $newEvent->DateTimeEnd = str_replace('T', ' ', $event->end->local);
                $newEvent->CategoryID = $categoryID;
                $newEvent->TicketLink = $event->url;
                $newEvent->Cost = ((rand(1, 10)*5 - 1) + ((rand(0,1)==1) ? 0.95 : 0.99));

                $location = $this->getLatAndLong($event->venue_id);
                $newEvent->Latitude = $location['lat'];
                $newEvent->Longitude = $location['long'];

                try
                {
                    Event::findFirst(new Equals('Name', $event->name->text));
                }
                catch(\Exception $e)
                {
                    $newEvent->save();
                }
            }
        }
    }

    private function getLatAndLong($venueID)
    {
        // https://www.eventbriteapi.com/v3/venues/16510196/?token=Y5VZCJACLKIAVSOACQFF
        $url = $this->baseUrl . "/venues/{$venueID}/?token={$this->oauthToken}";
        $response = $this->sendRequest($url, 'get');
        $venue = json_decode($response->getResponseBody());

        $location = array(
            'lat' => $venue->latitude,
            'long' => $venue->longitude
        );

        return $location;
    }

    private function sendRequest( $url, $method='get' )
    {
        $request = new HttpRequest($url, $method);
        $curlhandler = new CurlHttpClient();

        return $curlhandler->getResponse($request);
    }
}