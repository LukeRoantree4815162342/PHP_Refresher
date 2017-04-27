<?php

namespace HackTheHub\Models\Event;

use Rhubarb\Stem\Models\Model;
use Rhubarb\Stem\Repositories\MySql\Schema\MySqlModelSchema;
use Rhubarb\Stem\Schema\Columns\AutoIncrementColumn;
use Rhubarb\Stem\Schema\Columns\ForeignKeyColumn;
use Rhubarb\Stem\Schema\Columns\StringColumn;

class Category extends Model
{
    protected function createSchema()
    {
        $schema = new MySqlModelSchema('tblCategory');

        $schema->addColumn(
            new AutoIncrementColumn('CategoryID'),
            new StringColumn('Name', 50),
            new ForeignKeyColumn('ParentCategoryID')
        );

        return $schema;
    }
}