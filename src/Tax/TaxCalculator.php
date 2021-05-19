<?php
/**
 * codekunst GmbH <www.codekunst.com>
 * @author e <hello@codekunst.com>
 */

namespace App\Tax;


class TaxCalculator
{
    private TaxGroup $taxGroup;

    public function __construct(TaxGroup $taxGroup)
    {
        $this->taxGroup = $taxGroup;
    }

    public function calculateTax($price, $group)
    {
        return $price * $this->taxGroup->getTax($group);
    }
}