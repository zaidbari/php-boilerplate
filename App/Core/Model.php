<?php

namespace App\Core;

use App\Traits\Logs;
use ClanCats\Hydrahon\Builder;
use ClanCats\Hydrahon\Query\Sql\FetchableInterface;
use ClanCats\Hydrahon\Query\Sql\Insert;
use PDO;

abstract class Model
{
    use Logs;

    /**
     * @throws \ClanCats\Hydrahon\Exception
     * 
     * @return Builder
     */
    protected static function db() : Builder
    {
        $connection = new PDO(
            'mysql:host=' .
            $_ENV['DB_HOST'] . ';dbname=' .
            $_ENV['DB_NAME'] . ';charset=utf8',
            $_ENV['DB_USERNAME'],
            $_ENV['DB_PASSWORD']
        );

        return new Builder('mysql', function ( $query, $queryString, $queryParameters ) use ( $connection ) {
            $statement = $connection->prepare($queryString);
            $statement->execute($queryParameters);
            if ($query instanceof FetchableInterface ) { 
                return $statement->fetchAll(\PDO::FETCH_ASSOC);
            } elseif ($query instanceof Insert ) { 
                return $connection->lastInsertId();
            } else {
                return $statement->rowCount();
            }
            
        });

    }
}
