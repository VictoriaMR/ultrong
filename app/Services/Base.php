<?php

namespace App\Services;

/**
 * 业务模型基类.
 */
class Base
{
    /**
     * 关联数据Model.
     *
     * var App\Model\Base
     */
    protected $baseModel = null;

    /**
     * 常量映射关系表.
     */
    protected static $constantMap = [];

    /**
     * 通过主键获取资料.
     *
     * @param mix $id 主键值
     *
     * @return array
     */
    public function loadData($id)
    {
        return $this->baseModel->loadData($id);
    }

    /**
     * 新增数据.
     *
     * @param array $data 新增数据
     */
    public function insert($data)
    {
        return $this->baseModel->insert($data);
    }

    public function update($data)
    {
        return $this->baseModel->update($data);
    }

    public function where($column, $operator = null, $value = null)
    {
        return $this->baseModel->where($column, $operator, $value);
    }

    /**
     * 新增数据.
     *
     * @param array $data 新增数据
     */
    public function insertGetId($data)
    {
        return $this->baseModel->insertGetId($data);
    }

    /**
     * 通过主键更新数据.
     *
     * @param mix   $id
     * @param array $data
     *
     * @return bool
     */
    public function updateDataById($id, $data)
    {
        return $this->baseModel->updateDataById($id, $data);
    }

    /**
     * 通过属性获取资料.
     *
     * @param string $attribute 属性名
     * @param mix    $value     属性值
     *
     * @return array
     */
    public function loadDataByAttribute($attribute, $value)
    {
        return $this->baseModel->loadDataByAttribute($attribute, $value); 
    }

    /**
     * @method 获取条件总数
     * @author Victoria
     * @date   2020-05-31
     * @return integer
     */
    public function getDataCount($where = [])
    {
        return $this->baseModel->getDataCount($where);
    }

    /**
     * @method 获取数据
     * @author Victoria
     * @date   2020-04-13
     * @return array
     */
    public function getDataList($data = [], $field=[], $page=[], $orderBy=[])
    {
        return $this->baseModel->getDataList($data, $field, $page, $orderBy);
    }

    /**
     * @method 是否存在数据
     * @author Victoria
     * @date   2020-04-25
     * @return boolean  
     */
    public function isExistData($proId)
    {
        return $this->baseModel->isExistData($proId);
    }

    /**
     * 通过属性值更新数据.
     *
     * @param mix   $id
     * @param array $data
     *
     * @return bool
     */
    public function updateDataByAttribute($attribute, $value, $data)
    {
        return $this->baseModel->updateDataByAttribute($attribute, $value, $data);
    }

    /**
     * 通过filter更新数据.
     *
     * @param array $filter 更新条件 
     * @param array $data   更新数据
     */
    public function updateDataByFilter($filter, $data)
    {
        return $this->baseModel->updateDataByFilter($filter, $data);
    }

    /**
     * 通过主键进行删除.
     *
     * @param $id 主键值
     */
    public function deleteById($id)
    {
        return $this->baseModel->deleteById($id);
    }

    /**
     *  获取Model.
     */
    public function getBaseModel()
    {
        return $this->baseModel;
    }

    /**
     * 获取常量继承方法
     * @author   Mingrong
     * @DateTime 2020-01-10
     * @param    [type]     $const [description]
     * @param    string     $model [description]
     * @return   
     */
    public static function constant($const, $model = 'base')
    {
        $namespace = 'static';

        if (isset(static::$constantMap[$model])) {
            $namespace = static::$constantMap[$model];
        }

        return constant($namespace.'::'.$const);
    }

    /**
     * @method 返回页码总数格式
     * @author Victoria
     * @date   2020-04-13
     * @return array
     */
    public function getPaginationList($total, $list, $page, $pagesize)
    {
        return $this->baseModel->getPaginationList($total, $list, $page, $pagesize);
    }

    /**
     * @method 获取随机数
     * @author Victoria
     * @date   2020-01-10
     * @return string salt
     */
    public function getSalt($len = 4)
    {
        $chars = array(
            'a', 'b', 'c', 'd', 'e', 'f', 'g', 'h', 'i', 'j', 'k',
            'l', 'm', 'n', 'o', 'p', 'q', 'r', 's', 't', 'u', 'v',
            'w', 'x', 'y', 'z', 'A', 'B', 'C', 'D', 'E', 'F', 'G',
            'H', 'I', 'J', 'K', 'L', 'M', 'N', 'O', 'P', 'Q', 'R',
            'S', 'T', 'U', 'V', 'W', 'X', 'Y', 'Z', '0', '1', '2',
            '3', '4', '5', '6', '7', '8', '9'
        );
 
        $charsLen = count($chars) - 1;
        shuffle($chars);                            //打乱数组顺序
        $str = '';
        for($i=0; $i<$len; $i++){
            $str .= $chars[mt_rand(0, $charsLen)];    //随机取出一位
        }
        return $str;
    }

    /**
     * @method 获取密码与随机值的组合
     * @author Victoria
     * @date   2020-01-10
     * @return string password
     */
    public function getPasswd($password, $salt)
    {
        $passwordArr = str_split($password);
        $saltArr = str_split($salt);
        $countpwd = count($passwordArr);
        $countSalt = count($saltArr);

        $password = '';
        if ($countSalt > $countpwd) {
            foreach ($saltArr as $key => $value) {
                $password .= $passwordArr[$key] ?? '' . $value;
            }
        } else {
            $i = 0;
            $sign = floor($countpwd / $countSalt);
            foreach ($passwordArr as $key => $value) {
                $password .= $value;
                if ($key % $sign == 0) {
                    if (empty($saltArr[$i])) $i = 0;

                    $password .= $saltArr[$i];
                    $i ++;
                }
            }
        }

        return $password;
    }

    public function pathUrl($url, $prev = '')
    {
        if (empty($prev)) return $url;
        $temp = [];
        $arr = explode('/', $url);
        $count = count($arr);
        foreach ($arr as $key => $value) {
            $temp[] = $value;
            if ($count == $key + 2) {
                $temp[] = $prev;
            }
        }
        return implode('/', $temp);
    }
}