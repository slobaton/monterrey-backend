<?php
namespace App\Helpers;

class QueryBuilderHelpers
{
    public static function isJoined($query, $table) {
        $joins = $query->getQuery()->joins;

        if($joins == null) {
            return false;
        }

        foreach ($joins as $join) {
            if ($join->table == $table) {
                return true;
            }
        }
        return false;
    }
}
