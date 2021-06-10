<?php

namespace GildedRose\Item;

use GildedRose\Item;

final class AgedBrie extends Item
{
    public function update(): void
    {
        $this->sell_in -= 1;
        $this->quality += 1;

        if ($this->sell_in < 0) {
            $this->quality += 1;
        }

        if ($this->quality > 50) {
            $this->quality = 50;
        }
    }
}
