<?php


namespace app\components\helpers;

use yii\helpers\ArrayHelper as HelpersArrayHelper;

class ArrayHelper extends HelpersArrayHelper
{
    /**
     * Get all values from specific key in a multidimensional array
     *
     * @param string $key key(s) of value you wish to extract
     * @param array $arr where you want
     *
     * @return null|string|array
     */
    public static function arrayValueRecursiveForSearchMenu(string $key, array $arr)
    {

        $val = array();
        array_walk_recursive($arr, function ($v, $k) use ($key, &$val) {
            if ($k == $key) {
                if (substr($v, 0, 1) == '/') {
                    $explode = array_map(
                        function ($el) {
                            return ucwords(str_replace('-', ' ', $el));
                        },
                        array_values(
                            array_filter(
                                explode("/", $v)
                            )
                        )
                    );
                    array_pop($explode);
                    $val[$v] = implode(" - ", $explode);
                }
            }
        });
        asort($val);
        return count($val) > 1 ? $val : array_pop($val);
    }
}