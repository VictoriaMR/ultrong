<?php

namespace App\Models;

use frame\Query;

/**
 * 封装一些常用的ORM方法，所有Model以此为基类
 */
class Base extends Query
{
    public function __construct()
    {
        $this->_table = $this->table;
        $this->_connect = $this->connect;
    }

    /**
     * 通过主键获取数据
     *
     * @param mix $id 主键值
     * @return App\Model\Base
     */
    public function loadData($id)
    {
        if (empty($id)) return [];
        return $this->where($this->primaryKey, (int) $id)
                    ->find();
    }

    /**
     * 通过主键更新数据
     *
     * @param mix $id
     * @param array $data
     * @return bool
     */
    public function updateDataById($id, $data)
    {
        return $this->where($this->primaryKey, $id)->update($data);
    }

    public function deleteDataById($id)
    {
        return $this->where($this->primaryKey, $id)->delete();
    }

    public function addDataGetId($data)
    {
        return $this->insertGetId($data);
    }

    public function addData($data)
    {
        return $this->insert($data);
    }

    public function getPaginationList($total, $list, $page = 1, $pagesize = 10)
    {
        return [
            'total' => $total,
            'pagesize' => $pagesize,
            'page' => $page,
            'page_total' => ceil($total / $pagesize),
            'list' => $list,
        ];
    }
}