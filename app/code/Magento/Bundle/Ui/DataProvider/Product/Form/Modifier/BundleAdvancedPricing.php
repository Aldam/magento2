<?php
/**
 * Copyright © 2015 Magento. All rights reserved.
 * See COPYING.txt for license details.
 */
namespace Magento\Bundle\Ui\DataProvider\Product\Form\Modifier;

use Magento\Catalog\Ui\DataProvider\Product\Form\Modifier\AbstractModifier;
use Magento\Catalog\Model\AttributeConstantsInterface as Constants;

/**
 * Customize Advanced Pricing modal panel
 */
class BundleAdvancedPricing extends AbstractModifier
{
    const CODE_MSRP = 'msrp';
    const CODE_MSRP_DISPLAY_ACTUAL_PRICE_TYPE = 'msrp_display_actual_price_type';
    const CODE_ADVANCED_PRICING = 'advanced-pricing';
    const CODE_RECORD = 'record';

    /**
     * {@inheritdoc}
     */
    public function modifyMeta(array $meta)
    {
        $groupCode = $this->getGroupCodeByField($meta, self::CODE_ADVANCED_PRICING);
        if ($groupCode) {
            $parentNode = &$meta[$groupCode]['children'][self::CODE_ADVANCED_PRICING]['children'];
            if (isset($parentNode['container_' . self::CODE_MSRP])
                && isset($parentNode['container_' . self::CODE_MSRP_DISPLAY_ACTUAL_PRICE_TYPE])
            ) {
                unset($parentNode['container_' . self::CODE_MSRP]);
                unset($parentNode['container_' . self::CODE_MSRP_DISPLAY_ACTUAL_PRICE_TYPE]);
            }
            if (isset($parentNode['container_' . Constants::CODE_SPECIAL_PRICE])) {
                $currentNode = &$parentNode['container_' . Constants::CODE_SPECIAL_PRICE]['children'];
                $currentNode[Constants::CODE_SPECIAL_PRICE]['arguments']['data']['config']['addbefore']  = "%";
            }
            $parentNodeChildren = &$parentNode[Constants::CODE_TIER_PRICE]['children'];
            if (isset( $parentNodeChildren[self::CODE_RECORD]['children'][Constants::CODE_PRICE])) {
                $currentNode = &$parentNodeChildren[self::CODE_RECORD]['children'][Constants::CODE_PRICE];
                $currentNode['arguments']['data']['config']['label'] = __('Percent Discount');
            }
        }

        return $meta;
    }

    /**
     * {@inheritdoc}
     */
    public function modifyData(array $data)
    {
        return $data;
    }
}
