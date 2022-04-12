<?php
/**
 * codekunst GmbH <www.codekunst.com>
 * @author e <hello@codekunst.com>
 */

namespace App\Tax;


class TaxGroup
{

    const TAX_GROUPS = [
        "book" => 0.09,
        "car" => 0.4,
    ];

    public function getTax($group)
    {
        if (!array_key_exists($group, self::TAX_GROUPS)) {
            throw new \RuntimeException("Tax group is unknown");
        }

        return self::TAX_GROUPS[$group];
    }

}