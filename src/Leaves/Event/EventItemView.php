<?php

namespace HackTheHub\Leaves\Event;

use HackTheHub\Models\Event\Category;
use HackTheHub\Models\Event\Event;
use Rhubarb\Leaf\Controls\Common\Buttons\Button;
use Rhubarb\Leaf\Controls\Common\SelectionControls\DropDown\DropDown;
use Rhubarb\Leaf\Controls\Common\Text\TextBox;
use Rhubarb\Leaf\Crud\Leaves\CrudView;
use Rhubarb\Leaf\Views\View;

class EventItemView extends CrudView
{
    public function createSubLeaves()
    {
        $lat = new TextBox("Latitude");
        $long = new TextBox("Longitude");
        $name = new TextBox("Name");
        $name = new TextBox("Name");
        $dateStart = new TextBox("DateTimeStart");
        $dateEnd = new TextBox("DateTimeEnd");
        $description = new TextBox("Description");
        $category = new DropDown("Category");
        $categories = Category::find();
        $categoriesList = [];
        foreach ($categories as $categoryName){
            $categoriesList[$categoryName->UniqueIdentifier] = $categoryName->Name;
        }
        $category->setSelectionItems($categoriesList);
        $cost = new TextBox("Cost");
        $ticketLink = new TextBox("TicketLink");
        $this->registerSubLeaf($lat);
        $this->registerSubLeaf($long);
        $this->registerSubLeaf($category);
        $this->registerSubLeaf($name);
        $this->registerSubLeaf($dateStart);
        $this->registerSubLeaf($dateEnd);
        $this->registerSubLeaf($description);
        $this->registerSubLeaf($cost);
        $this->registerSubLeaf($ticketLink);

        parent::createSubLeaves(); // TODO: Change the autogenerated stub
    }
    

    protected function printViewContent()
    {
        echo "<style>@import 'https://fonts.googleapis.com/css?family=Roboto:300,400,500';

body{
    margin: 0px;
    padding:0px;
    font-family: Roboto;
    font-weight: 400;
    color: white;
    font-size: 18px;
    background-color: #3498db;
}

input[type='submit']
{
font-family: Roboto;
background-color: #2ecc71;
border: 3px solid #2980b9;
padding: 15px;
font-size: 25px;
color: white;
transition: 0.5s;
}</style>";
        print "<center><head><link rel='stylesheet' href='styleEventItemView.css'><h3>Register Your new Event!</h3></head></center>";
        print "<body><center><div>Location Details<div>";
        print "Latitude: " . "<br>" . $this->leaves["Latitude"] . "<br><br>" ;
        print "Longitude: " . "<br>" . $this->leaves["Longitude"] . "<br><br>";
        print "</div>";
        print "<div>Timing Details<div>";
        print "When will your event happen?" . "<br>" . $this->leaves["DateTimeStart"] . "<br><br>";
        print "And When will it end?" . "<br>" . $this->leaves["DateTimeEnd"] . "<br><br>";
        print "</div>";
        print "<div>Pricing<div>";
        print "How much is a ticket to your event?" . "<br>£" . $this->leaves["Cost"] . "<br><br>";
        print "And where should someone get a ticket online?" . "<br>" . $this->leaves["TicketLink"] . "<br><br>";
        print "</div>";
        print "<div>General Info<div>";
        print "Which category best describes your event?" . "<br>" . $this->leaves["Category"] . "<br><br>";
        print "What is the name of your event?" . "<br>" . $this->leaves["Name"] . "<br><br>";
        print "How would you describe your event?" . "<br>" . $this->leaves["Description"] . "<br><br>";
        print "</div>";
        print "<br>" . $this->leaves["Save"];
        print "</div></center></body>";
    }
}