<?php

namespace Rhubarb\Leaf\SearchPanel\Leaves;

use Rhubarb\Crown\Events\Event;
use Rhubarb\Leaf\Leaves\LeafModel;

class SearchPanelModel extends LeafModel
{
    /**
     * @var Event
     */
    public $searchedEvent;

    /**
     * True if the search should be submitted instantly without pressing the search button.
     *
     * @var bool
     */
    public $autoSubmit = false;

    /**
     * The binding source for controls in the panel
     *
     * @var string[]
     */
    public $searchValues = [];

    /**
     * The number of columns to use in the panel.
     *
     * @var int
     */
    public $searchControlsColumnCount = 6;

    /**
     * An array of control leaves.
     * 
     * @var array
     */
    public $searchControls = [];

    public function __construct()
    {
        parent::__construct();

        $this->searchedEvent = new Event();
    }

    public function getSearchValue($name, $defaultValue = false)
    {
        if (isset($this->searchValues[$name])){
            return $this->searchValues[$name];
        }

        return $defaultValue;
    }

    /**
     * Return the list of properties that can be exposed publically
     *
     * @return array
     */
    protected function getExposableModelProperties()
    {
        $list = parent::getExposableModelProperties();
        $list[] = "autoSubmit";

        return $list;
    }


    public function getBoundValue($propertyName, $index = null)
    {
        if ($index !== null ){
            if (isset($this->searchValues[$propertyName][$index])){
                return $this->searchValues[$propertyName][$index];
            } else {
                return null;
            }
        } else {
            return isset($this->searchValues[$propertyName]) ? $this->searchValues[$propertyName] : null;
        }
    }

    public function setBoundValue($propertyName, $propertyValue, $index = null)
    {
        if ($index !== null){
            if (!isset($this->searchValues[$propertyName]) || !is_array($this->searchValues[$propertyName])){
                $this->searchValues[$propertyName] = [];
            }

            $this->searchValues[$propertyName][$index] = $propertyValue;
        } else {
            $this->searchValues[$propertyName] = $propertyValue;
        }
    }
}