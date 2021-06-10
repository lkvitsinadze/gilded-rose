<?php

declare(strict_types=1);

namespace GildedRose;

use GildedRose\Item\AgedBrie;
use GildedRose\Item\BackstagePasses;
use GildedRose\Item\NormalItem;
use GildedRose\Item\Sulfuras;

final class GildedRose
{
    /**
     * @var array
     */
    private static $itemClasses = [
        'normal' => NormalItem::class,
        'Aged Brie' => AgedBrie::class,
        'Sulfuras, Hand of Ragnaros' => Sulfuras::class,
        'Backstage passes to a TAFKAL80ETC concert' => BackstagePasses::class,
    ];

    /**
     * @var array
     */
    private $items;

    public function __construct(array &$items)
    {
        $this->setItems($items);
    }

    private function setItems(array &$items): void
    {
        $this->items = &$items;

        foreach ($items as $key => $item) {
            if (array_key_exists($item->name, self::$itemClasses)) {
                $class = self::$itemClasses[$item->name];
            }
            else {
                $class = NormalItem::class;
            }

            $this->items[$key] = new $class($item->name, $item->sell_in, $item->quality);
        }
    }

    public function updateQuality(): void
    {
        foreach ($this->items as $item) {
            $item->update();
        }
    }
}
