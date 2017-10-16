<?php

namespace Codeages\Biz\Framework\Pay\Dao\Impl;

use Codeages\Biz\Framework\Pay\Dao\PaymentTradeDao;
use Codeages\Biz\Framework\Dao\GeneralDaoImpl;

class PaymentTradeDaoImpl extends GeneralDaoImpl implements PaymentTradeDao
{
    protected $table = 'biz_payment_trade';

    public function getByOrderSnAndPlatform($orderSn, $platform)
    {
        return $this->getByFields(array(
            'order_sn' => $orderSn,
            'platform' => $platform
        ));
    }

    public function findByOrderSns($orderSns)
    {
        return $this->findInField('order_sn', $orderSns);
    }

    public function findByOrderSn($orderSn)
    {
        return $this->findByFields(array(
            'order_sn' => $orderSn,
        ));
    }

    public function getByTradeSn($sn)
    {
        return $this->getByFields(array(
            'trade_sn' => $sn,
        ));
    }

    public function findByTradeSns($sns)
    {
        return $this->findInField('trade_sn', $sns);      
    }

    public function declares()
    {
        return array(
            'timestamps' => array('created_time', 'updated_time'),
            'serializes' => array(
                'platform_created_result' => 'json',
                'notify_data' => 'json',
                'platform_created_params' => 'json'
            ),
            'conditions' => array(
                'order_sn IN (:order_sns)',
            ),
                
        );
    }
}