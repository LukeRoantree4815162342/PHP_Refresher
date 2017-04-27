<?php

namespace HackTheHub\Leaves\Event;

use Rhubarb\Crown\Layout\LayoutModule;
use Rhubarb\Leaf\Crud\Leaves\CrudLeaf;
use Rhubarb\Leaf\Crud\Leaves\ModelBoundLeaf;

class EventItem extends CrudLeaf
{
    protected function getViewClass()
    {
        return EventItemView::class;
    }

    protected function createModel()
    {
        $model = new EventItemModel();
        return $model;
    }
    
}