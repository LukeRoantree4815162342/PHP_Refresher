<?php

namespace HackTheHub\Models;

use HackTheHub\Leaves\Event\EventItemModel;
use HackTheHub\Models\Event\Category;
use HackTheHub\Models\Event\Event;
use HackTheHub\Models\User\Client;
use HackTheHub\Models\User\Organizer;
use Rhubarb\Scaffolds\Authentication\User;
use Rhubarb\Stem\Schema\SolutionSchema;

class HackTheHubSolutionSchema extends SolutionSchema
{
    public function __construct()
    {
        parent::__construct();
        $this->addModel('Client', Client::class, 1);
        $this->addModel('Organizer', Organizer::class, 1);
        $this->addModel('Event', Event::class, 1.8);
        $this->addModel('Category', Category::class, 1.2);
        $this->addModel('User', User::class, 1);
    }

    protected function defineRelationships()
    {
        $this->declareOneToManyRelationships(
            [
                'Category' => [
                    'Events' => 'Event.CategoryID',
                    'ChildCategories' => 'Category.ParentCategoryID:ParentCategory',
                ],
            ]
        );
        $this->declareOneToOneRelationships(
            [
                'User' => [
                  'Organizers' => 'Organizer.UserID',
                  'Client' => 'Client.UserID',
                ],
            ]
        );
    }
}
