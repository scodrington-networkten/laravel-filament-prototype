<?php
/**
 * @author Simon Codrington <scodrington@networkten.com.au>
 */

namespace App\helpers;

class Helper
{

    public static function test()
    {
        return true;
    }

    /**
     * Given an array of items and a callback, return the matched item from the collection
     * @param iterable|null $items collection of items to check
     * @param callable $callback callback to be applied, checked against each record
     *
     * @return mixed|null
     */
    public static function array_find(iterable|null $items , callable $callback) : mixed{

        if($items === null){ return null;}

        foreach ($items as $item) {
            if($callback($item)){
                return $item;
            }
        }
        return null;
    }

}
