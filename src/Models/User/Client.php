<?php
namespace HackTheHub\Models\User;
use Rhubarb\Stem\Models\Model;
use Rhubarb\Stem\Repositories\MySql\Schema\Columns\MySqlEnumColumn;
use Rhubarb\Stem\Repositories\MySql\Schema\MySqlModelSchema;
use Rhubarb\Stem\Schema\Columns\AutoIncrementColumn;
use Rhubarb\Stem\Schema\Columns\BooleanColumn;
use Rhubarb\Stem\Schema\Columns\DateTimeColumn;
use Rhubarb\Stem\Schema\Columns\ForeignKeyColumn;

class Client extends Model
{
    protected function createSchema()
    {
        $model = new MySqlModelSchema('tblClient');

        $model->addColumn(
            new AutoIncrementColumn('ClientID'),
            new MySqlEnumColumn('UserType', 'Client', ['Client', 'Organizer'] ),
            new BooleanColumn('DemoPreference', false),
            new ForeignKeyColumn('UserID', null)
        );
        return $model;
    }
}
