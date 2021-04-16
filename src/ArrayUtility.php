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

    /**
     * 将一个平面的二维数组按照指定的字段转换为树状结构.
     *
     * 用法：
     * <code>
     * $rows = array(
     *     array('id' => 1, 'value' => '1-1', 'parent' => 0),
     *     array('id' => 2, 'value' => '2-1', 'parent' => 0),
     *     array('id' => 3, 'value' => '3-1', 'parent' => 0),
     *
     *     array('id' => 7, 'value' => '2-1-1', 'parent' => 2),
     *     array('id' => 8, 'value' => '2-1-2', 'parent' => 2),
     *     array('id' => 9, 'value' => '3-1-1', 'parent' => 3),
     *     array('id' => 10, 'value' => '3-1-1-1', 'parent' => 9),
     * );
     *
     * $tree = Util_Array::tree($rows, 'id', 'parent', 'nodes');
     *
     * print_r($tree);
     *   // 输出结果为：
     *   // array(
     *   //   array('id' => 1, ..., 'nodes' => array()),
     *   //   array('id' => 2, ..., 'nodes' => array(
     *   //        array(..., 'parent' => 2, 'nodes' => array()),
     *   //        array(..., 'parent' => 2, 'nodes' => array()),
     *   //   ),
     *   //   array('id' => 3, ..., 'nodes' => array(
     *   //        array('id' => 9, ..., 'parent' => 3, 'nodes' => array(
     *   //             array(..., , 'parent' => 9, 'nodes' => array(),
     *   //        ),
     *   //   ),
     *   // )
     * </code>
     *
     * 如果要获得任意节点为根的子树，可以使用 $refs 参数：
     * <code>
     * $refs = null;
     * $tree = Util_Array::tree($rows, 'id', 'parent', 'nodes', $refs);
     *
     * // 输出 id 为 3 的节点及其所有子节点
     * $id = 3;
     * print_r($refs[$id]);
     * </code>
     *
     * @param array  $arr           数据源
     * @param string $key_node_id   节点ID字段名
     * @param string $key_parent_id 节点父ID字段名
     * @param string $key_childrens 保存子节点的字段名
     * @param bool   $refs          是否在返回结果中包含节点引用
     *
     * return array 树形结构的数组
     */
    public static function tree($arr, $key_node_id, $key_parent_id = 'parent_id', $key_childrens = 'childrens', &$refs = null)
    {
        $refs = array();
        foreach ($arr as $offset => $row) {
            $arr[$offset][$key_childrens] = null;
            $refs[$row[$key_node_id]] = &$arr[$offset];
        }

        $tree = array();
        foreach ($arr as $offset => $row) {
            $parent_id = $row[$key_parent_id];
            if ($parent_id) {
                if (!isset($refs[$parent_id])) {
                    $tree[] = &$arr[$offset];
                    continue;
                }
                $parent = &$refs[$parent_id];
                $parent[$key_childrens][] = &$arr[$offset];
            } else {
                $tree[] = &$arr[$offset];
            }
        }

        return $tree;
    }
}