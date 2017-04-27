<?php

namespace HackTheHub\Leaves\RestResource;

use Rhubarb\RestApi\Resources\ModelRestResource;

class EventResource extends ModelRestResource
{
    public function getModelName()
    {
        return 'Event';
    }

    protected function getSummaryColumns()
    {
        $columns = parent::getSummaryColumns();
        $columns['Latitude'] = 'Latitude';
        $columns['Longitude'] = 'Longitude';

        return $columns;
    }


}