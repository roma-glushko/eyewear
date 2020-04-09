<?php

declare(strict_types=1);

namespace Eyewear\Collector\CartRule;

use Eyewear\Collector\CollectorInterface;
use Eyewear\Magento\Edition\EditionInterface;
use PDO;

/**
 *
 */
class CartRuleCountCollector implements CollectorInterface
{
    /**
     * @param PDO $connection
     *
     * @return array
     */
    public function collect(PDO $connection): array
    {
        $allCartRuleCount = $connection->query(
            'SELECT COUNT(DISTINCT rule_id) FROM salesrule'
        )->fetchColumn();

        $activeCartRuleCount = $connection->query(
            'SELECT COUNT(DISTINCT rule_id) FROM salesrule WHERE is_active = 1'
        )->fetchColumn();

        $disabledCartRuleCount = $connection->query(
            'SELECT COUNT(DISTINCT rule_id) FROM salesrule WHERE is_active = 0'
        )->fetchColumn();

        $nonCouponCartRuleCount = $connection->query(
            'SELECT COUNT(DISTINCT rule_id)
            FROM salesrule WHERE is_active = 1 AND rule_id NOT IN (SELECT DISTINCT rule_id FROM salesrule_coupon)'
        )->fetchColumn();

        $couponCartRuleCount = $connection->query(
            'SELECT COUNT(DISTINCT rule_id)
            FROM salesrule WHERE is_active = 1 AND rule_id IN (SELECT DISTINCT rule_id FROM salesrule_coupon)'
        )->fetchColumn();

        return [
            'cart-rules' => [
                'all-cart-rule-count' => (int) $allCartRuleCount,
                'active-cart-rule-count' => (int) $activeCartRuleCount,
                'disabled-cart-rule-count' => (int) $disabledCartRuleCount,
                'coupon-cart-rule-count' => (int) $couponCartRuleCount,
                'non-coupon-cart-rule-count' => (int) $nonCouponCartRuleCount,
            ],
        ];
    }
}