<?php

namespace HackTheHub\Leaves;


use Rhubarb\Crown\Events\Event;
use Rhubarb\Leaf\Leaves\LeafModel;

class IndexModel extends LeafModel
{
    /**
     * @var Event
     */
    public $getEventsEvent;

    public function __construct()
    {
        $this->getEventsEvent = new Event();
    }
}