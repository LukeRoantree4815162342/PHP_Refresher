<?php

/*
 *	Copyright 2015 RhubarbPHP
 *
 *  Licensed under the Apache License, Version 2.0 (the "License");
 *  you may not use this file except in compliance with the License.
 *  You may obtain a copy of the License at
 *
 *     http://www.apache.org/licenses/LICENSE-2.0
 *
 *  Unless required by applicable law or agreed to in writing, software
 *  distributed under the License is distributed on an "AS IS" BASIS,
 *  WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
 *  See the License for the specific language governing permissions and
 *  limitations under the License.
 */

namespace Rhubarb\Stem\Repositories\MySql\Aggregates;

require_once __DIR__ . '/../../../Aggregates/CountDistinct.php';

use Rhubarb\Stem\Aggregates\Aggregate;
use Rhubarb\Stem\Aggregates\CountDistinct;
use Rhubarb\Stem\Repositories\Repository;
use Rhubarb\Stem\Sql\SelectExpression;
use Rhubarb\Stem\Sql\SqlStatement;

class MySqlCountDistinct extends CountDistinct
{
    use MySqlAggregateTrait;

    protected static function calculateByRepository(Repository $repository, Aggregate $originalAggregate, SqlStatement $sqlStatement, &$namedParams)
    {
        if (self::canAggregateInMySql($repository, $originalAggregate->aggregatedColumnName)) {
            $aliasName = $originalAggregate->getAlias();
            $columnName = $originalAggregate->getAggregateColumnName();

            $originalAggregate->calculated = true;

            $prefix = "`".$sqlStatement->getAlias()."`.";

            $sqlStatement->columns[] = new SelectExpression("COUNT( DISTINCT {$prefix}`{$columnName}` ) AS `{$aliasName}`");
        }
    }
}