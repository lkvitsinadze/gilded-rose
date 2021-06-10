<?php

namespace GildedRose\Item;

use GildedRose\Item;

final class Conjured extends Item
{
    public function update(): void
    {
        $this->quality -= 2;
        $this->sell_in -= 1;

        if ($this->sell_in < 0) {
            $this->quality -= 2;
        }

        if ($this->quality < 0) {
            $this->quality = 0;
        }
    }
}
