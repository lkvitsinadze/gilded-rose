<?php

namespace GildedRose\Item;

use GildedRose\Item;

final class BackstagePasses extends Item
{
    public function update(): void
    {
        $this->quality += 1;
        $this->sell_in -= 1;

        if ($this->sell_in < 5) {
            $this->quality += 2;
        } else if ($this->sell_in < 10) {
            $this->quality += 1;
        }

        if ($this->sell_in < 0) {
            $this->quality = 0;
        }

        if ($this->quality > 50) {
            $this->quality = 50;
        }
    }
}
