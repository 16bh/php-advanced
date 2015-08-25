<?php

/**
 * @author: chenxi
 * @date: 2015-08-08
 * @version: $Id$
 */
interface Icurd
{
    public function create($data);

    public function read();

    public function update($data);

    public function delete();
}

class User implements Icurd
{
    private $_userId = NULL;
    private $_username = NULL;

    public function __construct($data)
    {
        $this->_userId = uniqid();//uniqid() 函数基于以微秒计的当前时间，生成一个唯一的 ID。
        $this->_username = $data['username'];
    }

    public function create($data)
    {
        self::__construct($data);
    }

    public function read()
    {
        return array('userId'=>$this->_userId, 'username'=>$this->_username);
    }

    public function update($data)
    {
        $this->_username = $data['username'];
    }

    public function delete()
    {
        $this->_userId = NULL;
        $this->_username = NULL;
    }
}