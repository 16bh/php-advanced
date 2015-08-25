<?php

/**
 * 测试代码生成
 * @author:  chenxi
 * @date:    2015-05-08
 * @version: $Id$
 */
class Model_Test extends Model_Base
{
    /**
     * @var int
     */
    private $Id = 0;

    /**
     * @var int
     */
    private $Dtt = 0;

    /**
     * @var int
     */
    private $LoginId = 0;

    /**
     * @var int
     */
    private $AdminId = 0;

    /**
     * @var string
     */
    private $Reason = '';

    private $_pairs = array();


    /**
     * @param int $Id
     */
    public function setId($Id)
    {
        $this->Id = $this->_pairs['Id'] = (int)$Id;
        return $this;
    }

    /**
     * @param int $Dtt
     */
    public function setDtt($Dtt)
    {
        $this->Dtt = $this->_pairs['Dtt'] = (int)$Dtt;
        return $this;
    }

    /**
     * @param int $LoginId
     */
    public function setLoginId($LoginId)
    {
        $this->LoginId = $this->_pairs['LoginId'] = (int)$LoginId;
        return $this;
    }

    /**
     * @param int $AdminId
     */
    public function setAdminId($AdminId)
    {
        $this->AdminId = $this->_pairs['AdminId'] = (int)$AdminId;
        return $this;
    }

    /**
     * @param string $Reason
     */
    public function setReason($Reason)
    {
        $this->Reason = $this->_pairs['Reason'] = $Reason;
        return $this;
    }

    public function getList()
    {
        $where = 'WHERE 1 ';
        $where .= ' AND';
    }


    public function alter()
    {
        try {

        } catch (Database_Exception $e) {
            return false;
        }
    }
}