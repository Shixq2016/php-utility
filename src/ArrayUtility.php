<?php

namespace Es3\Utility;

class ArrayUtility
{
    /**
     * 将一个二维数组按照指定字段的值分组.
     *
     * 用法：
     * <code>
     * $rows = array(
     *     array('id' => 1, 'value' => '1-1', 'parent' => 1),
     *     array('id' => 2, 'value' => '2-1', 'parent' => 1),
     *     array('id' => 3, 'value' => '3-1', 'parent' => 1),
     *     array('id' => 4, 'value' => '4-1', 'parent' => 2),
     *     array('id' => 5, 'value' => '5-1', 'parent' => 2),
     *     array('id' => 6, 'value' => '6-1', 'parent' => 3),
     * );
     * $values = Util_Array::group_by($rows, 'parent');
     *
     * print_r($values);
     *   // 按照 parent 分组的输出结果为
     *   // array(
     *   //   1 => array(
     *   //        array('id' => 1, 'value' => '1-1', 'parent' => 1),
     *   //        array('id' => 2, 'value' => '2-1', 'parent' => 1),
     *   //        array('id' => 3, 'value' => '3-1', 'parent' => 1),
     *   //   ),
     *   //   2 => array(
     *   //        array('id' => 4, 'value' => '4-1', 'parent' => 2),
     *   //        array('id' => 5, 'value' => '5-1', 'parent' => 2),
     *   //   ),
     *   //   3 => array(
     *   //        array('id' => 6, 'value' => '6-1', 'parent' => 3),
     *   //   ),
     *   // )
     * </code>
     *
     * @param array  $arr       数据源
     * @param string $key_field 作为分组依据的键名
     *
     * @return array 分组后的结果
     */
    public static function groupBy($arr, $key_field)
    {
        $ret = array();
        foreach ($arr as $row) {
            $key = $row[$key_field];
            $ret[$key][] = $row;
        }

        return $ret;
    }

    public static function groupByMultiField($arr, $multi_key_field)
    {
        $ret = array();
        foreach ($arr as $row) {
            $key = array();
            foreach ($multi_key_field as $key_field) {
                $key[] = $row[$key_field];
            }
            $key = implode('_', $key);
            $ret[$key][] = $row;
        }

        return $ret;
    }

    public static function groupByArray($arr, $key_field_arr)
    {
        $ret = array();
        foreach ($arr as $row) {
            $key_arr = [];
            foreach ($key_field_arr as $v) {
                $key_arr[] = $row[$v];
            }
            $key = implode('_', $key_arr);
            $ret[$key][] = $row;
        }

        return $ret;
    }
}