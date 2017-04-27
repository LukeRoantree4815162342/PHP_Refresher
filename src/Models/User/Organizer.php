<?php
namespace HackTheHub\Models\User;
use Rhubarb\Stem\Models\Model;
use Rhubarb\Stem\Repositories\MySql\Schema\Columns\MySqlEnumColumn;
use Rhubarb\Stem\Repositories\MySql\Schema\MySqlModelSchema;
use Rhubarb\Stem\Schema\Columns\AutoIncrementColumn;
use Rhubarb\Stem\Schema\Columns\ForeignKeyColumn;
use Rhubarb\Stem\Schema\Columns\IntegerColumn;
use Rhubarb\Stem\Schema\Columns\StringColumn;

/**
 * Created by PhpStorm.
 * User: Luke
 * Date: 10/09/2016
 * Time: 14:29
 */
class Organizer extends Model
{
    protected function createSchema()
    {
        $model = new MySqlModelSchema('tblOrganizer');

        $model->addColumn(
            new AutoIncrementColumn('OrganizerID'),
            new StringColumn('OrganizationName', 100),
            new ForeignKeyColumn('UserID', null),
            new StringColumn('AddressLine1', 200),
            new StringColumn('AddressLine2', 200),
            new StringColumn('AddressLine3', 200),
            new StringColumn('AddressTown', 200),
            new StringColumn('AddressCity', 200),
            new MySqlEnumColumn('CompanySize', 'Please select a company size', ['Please select a company size','0-10', '10-20', '20-50', '50-100', '100+'])
        );
        return $model;
    }
}