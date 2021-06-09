<?php
/**
 * codekunst GmbH <www.codekunst.com>
 * @author e <hello@codekunst.com>
 */

namespace App\Model;


/**
 * Interface SalableInterface
 * @package App\Model
 */
interface SalableInterface
{
    const TAX_PERCENTAGE = 0.10;

    public function getPrice();
}