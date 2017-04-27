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

namespace Rhubarb\Stem\Repositories\MySql\Schema;

use Rhubarb\Stem\Schema\Index;

/**
 * Schema details for an index
 */
class MySqlIndex extends Index
{
    const PRIMARY = 1;
    const UNIQUE = 2;
    const FULLTEXT = 3;

    /**
     * Creates an index.
     *
     * @param string $indexName If the type is INDEX::PRIMARY then this will be force to PRIMARY
     * @param int $indexType One of Index::INDEX, MySqlIndex::PRIMARY, MySqlIndex::UNIQUE or MySqlIndex::FULLTEXT
     * @param null $columnNames If null, then an array with just the index name is assumed.
     */
    public function __construct($indexName, $indexType = self::INDEX, $columnNames = null)
    {
        parent::__construct($indexName, $indexType, $columnNames);

        if ($this->indexType == self::PRIMARY) {
            $this->indexName = "Primary";
        }
    }

    /**
     * Returns the definition for this index.
     * @return string
     */
    public function getDefinition()
    {
        $columnNames = " (`" . implode("`,`", $this->columnNames) . "`)";
        switch ($this->indexType) {
            case self::PRIMARY:
                return "PRIMARY KEY" . $columnNames;
                break;
            case self::INDEX:
                return "KEY `" . $this->indexName . "`" . $columnNames;
                break;
            case self::UNIQUE:
                return "UNIQUE `" . $this->indexName . "`" . $columnNames;
                break;
            case self::FULLTEXT:
                return "FULLTEXT KEY `" . $this->indexName . "`" . $columnNames;
                break;
        }

        return "";
    }

    protected static function fromGenericIndexType(Index $genericIndex)
    {
        return new self($genericIndex->indexName, $genericIndex->indexType, $genericIndex->columnNames);
    }
}
