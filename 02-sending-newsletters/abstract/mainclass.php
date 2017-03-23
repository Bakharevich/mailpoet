<?php
abstract class Mainclass {
    public function fire($name, $params)
    {
        $obj = new $name;
        $result = $obj->fire($params);

        return $result;
    }
}