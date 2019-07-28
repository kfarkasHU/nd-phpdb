<?php

require_once("/../selectexpression.php");

class FindHelper {
    public static function ApplyFilter($array, $filter) {
        $result = $array;

        // order
        if($filter->OrderByColName && $filter->OrderByType) {
            for($i = count($result) - 1; $i > 0; $i--) {
                for($j = 0; $j < $i; $j++) {
                    $colName = $filter->OrderByColName;

                    if(self::ApplyDirection(
                        $result[$j]->Data["$colName"],
                        $result[$j + 1]->Data["$colName"],
                        $filter->OrderByType))
                    {
                        $temp = $result[$j + 1];
                        $result[$j+1] = $result[$j];
                        $result[$j] = $temp;
                    }
                }
            }
        }

        // filter
        $filteredData = array();
        foreach($filter->ColValues as $colVal) {
            $currentPropertyName = $colVal->ColName;
            $currentPropertyValue = $colVal->ColValue;

            foreach($result as $item) {
                switch($colVal->Operator) {
                    case Operator::EQUALS: 
                        if($item->Data["$currentPropertyName"] == $currentPropertyValue)
                        $filteredData = self::AddIfNotAdded($filteredData, $item);

                        break;
                }
            }
        }

        if(count($filter->ColValues) > 0)
            $result = $filteredData;

        // take
        if(!is_null($filter->Limit) && $filter->Limit > 0) {
            $result = array_splice($result, 0, $filter->Limit);
        }

        if(count($result) == 1)
            return $result[0];

        return $result;
    }

    private static function ApplyDirection($left, $right, $orderByType) {
        if($orderByType == OrderByType::ASC) {
            return $left > $right;
        }
        else if($orderByType == OrderByType::DESC) {
            return $left < $right;
        }
    }

    private static function AddIfNotAdded(array $array, $item) {
        if(!in_array($item, $array)) {
            array_push($array, $item);
        }

        return $array;
    }
}

?>
