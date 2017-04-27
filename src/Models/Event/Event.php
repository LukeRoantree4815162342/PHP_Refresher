<?php

namespace HackTheHub\Models\Event;

use Rhubarb\Stem\Models\Model;
use Rhubarb\Stem\Repositories\MySql\Schema\MySqlModelSchema;
use Rhubarb\Stem\Schema\Columns\AutoIncrementColumn;
use Rhubarb\Stem\Schema\Columns\DateTimeColumn;
use Rhubarb\Stem\Schema\Columns\DecimalColumn;
use Rhubarb\Stem\Schema\Columns\ForeignKeyColumn;
use Rhubarb\Stem\Schema\Columns\IntegerColumn;
use Rhubarb\Stem\Schema\Columns\MoneyColumn;
use Rhubarb\Stem\Schema\Columns\StringColumn;

class Event extends Model
{
    protected function createSchema()
    {
        $model = new MySqlModelSchema('tblEvent');

        $model->addColumn(
            new AutoIncrementColumn('EventID'),
            new StringColumn('Name', 100),
            new StringColumn('Description', 800),
            new DecimalColumn( 'Latitude', 20, 10 ),
            new DecimalColumn( 'Longitude', 20, 10 ),
            new ForeignKeyColumn('OrganizerID'),
            new DateTimeColumn('DateTimeStart'),
            new DateTimeColumn('DateTimeEnd'),
            new ForeignKeyColumn('CategoryID'),
            new MoneyColumn('Cost'),
            new StringColumn('TicketLink', 200)
        );

        return $model;
    }

    public function getMarkerImage()
    {
        if($this->CategoryID == 1) {
            return '/static/food1.png';
        } else if( $this->CategoryID == 7) {
            return '/static/music.png';
        } else if( $this->CategoryID == 19) {
            return '/static/sport1.png';
        }
    }
}