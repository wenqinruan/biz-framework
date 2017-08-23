<?php

namespace Codeages\Biz\Framework\Provider;

use Codeages\Biz\Framework\Pay\Status\ClosedStatus;
use Codeages\Biz\Framework\Pay\Status\ClosingStatus;
use Codeages\Biz\Framework\Pay\Status\PaidStatus;
use Codeages\Biz\Framework\Pay\Status\PayingStatus;
use Codeages\Biz\Framework\Pay\Status\PaymentTradeContext;
use Codeages\Biz\Framework\Pay\Status\RefundedStatus;
use Codeages\Biz\Framework\Pay\Status\RefundingStatus;
use Pimple\Container;
use Pimple\ServiceProviderInterface;

class PayServiceProvider implements ServiceProviderInterface
{
    public function register(Container $biz)
    {
        $biz['migration.directories'][] = dirname(dirname(__DIR__)).'/migrations/pay';
        $biz['autoload.aliases']['Pay'] = 'Codeages\Biz\Framework\Pay';

        $this->registerStatus($biz);
    }

    private function registerStatus($biz)
    {
        $biz['payment_trade_context'] = function ($biz) {
            return new PaymentTradeContext($biz);
        };

        $statusArray = array(
            PayingStatus::class,
            ClosingStatus::class,
            ClosedStatus::class,
            PaidStatus::class,
            RefundingStatus::class,
            RefundedStatus::class,
        );

        foreach ($statusArray as $status) {
            $biz['payment_trade.'.$status::NAME] = function ($biz) use ($status) {
                return new $status($biz);
            };
        }
    }
}
