<?php

namespace HackTheHub\Leaves\Event;

use Rhubarb\Leaf\Crud\Leaves\ModelBoundLeaf;
use Rhubarb\Leaf\Leaves\LeafModel;

class EventCollection extends ModelBoundLeaf
{
    protected function getViewClass()
    {
        return EventCollectionView::class;
    }

    protected function createModel()
    {
        return new LeafModel();
    }
}