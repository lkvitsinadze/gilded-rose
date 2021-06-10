<?php

namespace GildedRose\Item;

use GildedRose\Item;

final class NormalItem extends Item
{
    public function update(): void
    {
        $this->quality -= 1;
        $this->sell_in -= 1;

        if ($this->sell_in < 0) {
            $this->quality -= 1;
        }

        if ($this->quality < 0) {
            $this->quality = 0;
        }
    }
}
