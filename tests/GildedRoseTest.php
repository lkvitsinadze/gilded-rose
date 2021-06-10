<?php

declare(strict_types=1);

namespace Tests;

use GildedRose\GildedRose;
use GildedRose\Item;
use PHPUnit\Framework\TestCase;

class GildedRoseTest extends TestCase
{
    public function test_update_normal_item_before_sell_date(): void
    {
        $items = [new Item('normal', 10, 10)];
        $gildedRose = new GildedRose($items);
        $gildedRose->updateQuality();
        $this->assertSame(9, $items[0]->quality);
    }

    public function test_sell_in_days_decrease_on_update(): void
    {
        $items = [new Item('normal', 5, 50)];
        $gildedRose = new GildedRose($items);
        $gildedRose->updateQuality();
        $this->assertSame(4, $items[0]->sell_in);
    }

    public function test_update_normal_item_on_sell_date(): void
    {
        $items = [new Item('normal', 0, 10)];
        $gildedRose = new GildedRose($items);
        $gildedRose->updateQuality();
        $this->assertSame(8, $items[0]->quality);
    }

    public function test_update_normal_item_after_sell_date(): void
    {
        $items = [new Item('normal', -4, 10)];
        $gildedRose = new GildedRose($items);
        $gildedRose->updateQuality();
        $this->assertSame(8, $items[0]->quality);
    }

    public function test_quality_is_never_negative(): void
    {
        $items = [new Item('normal', 5, 0)];
        $gildedRose = new GildedRose($items);
        $gildedRose->updateQuality();
        $this->assertGreaterThanOrEqual(0, $items[0]->quality);
    }

    public function test_aged_brie_increases_quality(): void
    {
        $items = [new Item('Aged Brie', 5, 5)];
        $gildedRose = new GildedRose($items);
        $gildedRose->updateQuality();
        $this->assertGreaterThan(5, $items[0]->quality);
    }

    public function test_aged_brie_quality_not_exceeds_maximum_quality(): void
    {
        $items = [new Item('Aged Brie', 5, 50)];
        $gildedRose = new GildedRose($items);
        $gildedRose->updateQuality();
        $this->assertSame(50, $items[0]->quality);
    }

    public function test_aged_brie_quality_not_exceeds_maximum_quality_on_sell_date(): void
    {
        $items = [new Item('Aged Brie', 0, 50)];
        $gildedRose = new GildedRose($items);
        $gildedRose->updateQuality();
        $this->assertSame(50, $items[0]->quality);
    }

    public function test_aged_brie_quality_not_exceeds_maximum_quality_after_sell_date(): void
    {
        $items = [new Item('Aged Brie', -2, 50)];
        $gildedRose = new GildedRose($items);
        $gildedRose->updateQuality();
        $this->assertSame(50, $items[0]->quality);
    }

    public function test_aged_brie_quality_after_sell_date(): void
    {
        $items = [new Item('Aged Brie', 0, 10)];
        $gildedRose = new GildedRose($items);
        $gildedRose->updateQuality();
        $this->assertSame(12, $items[0]->quality);
        $this->assertSame(-1, $items[0]->sell_in);
    }

    public function test_sulfuras_quality_and_sell_in_never_changes(): void
    {
        $items = [new Item('Sulfuras, Hand of Ragnaros', 5, 10)];
        $gildedRose = new GildedRose($items);
        $gildedRose->updateQuality();
        $this->assertSame(10, $items[0]->quality);
        $this->assertSame(5, $items[0]->sell_in);
    }

    public function test_backstage_passes_quality_increases(): void
    {
        $items = [new Item('Backstage passes to a TAFKAL80ETC concert', 11, 10)];
        $gildedRose = new GildedRose($items);
        $gildedRose->updateQuality();
        $this->assertSame(11, $items[0]->quality);
    }

    public function test_backstage_passes_quality_before_10_day_sell_end(): void
    {
        $items = [new Item('Backstage passes to a TAFKAL80ETC concert', 10, 10)];
        $gildedRose = new GildedRose($items);
        $gildedRose->updateQuality();
        $this->assertSame(12, $items[0]->quality);
    }

    public function test_backstage_passes_quality_before_5_sell_end(): void
    {
        $items = [new Item('Backstage passes to a TAFKAL80ETC concert', 5, 10)];
        $gildedRose = new GildedRose($items);
        $gildedRose->updateQuality();
        $this->assertSame(13, $items[0]->quality);
    }

    public function test_backstage_passes_quality_on_sell_date(): void
    {
        $items = [new Item('Backstage passes to a TAFKAL80ETC concert', 0, 10)];
        $gildedRose = new GildedRose($items);
        $gildedRose->updateQuality();
        $this->assertSame(13, $items[0]->quality);
    }

    public function test_backstage_passes_quality_after_sell_date(): void
    {
        $items = [new Item('Backstage passes to a TAFKAL80ETC concert', -4, 10)];
        $gildedRose = new GildedRose($items);
        $gildedRose->updateQuality();
        $this->assertSame(0, $items[0]->quality);
    }

    public function test_conjured_items_quality_before_sell_end_date(): void
    {
        $items = [new Item('Conjured Mana Cake', 10, 10)];
        $gildedRose = new GildedRose($items);
        $gildedRose->updateQuality();
        $this->assertSame(8, $items[0]->quality);
    }

    public function test_conjured_items_quality_before_on_sell_end_date(): void
    {
        $items = [new Item('Conjured Mana Cake', 0, 10)];
        $gildedRose = new GildedRose($items);
        $gildedRose->updateQuality();
        $this->assertSame(6, $items[0]->quality);
    }

    public function test_conjured_items_quality_before_after_sell_end_date(): void
    {
        $items = [new Item('Conjured Mana Cake', -5, 10)];
        $gildedRose = new GildedRose($items);
        $gildedRose->updateQuality();
        $this->assertSame(6, $items[0]->quality);
    }

    public function test_conjured_items_quality_never_less_than_zero(): void
    {
        $items = [new Item('Conjured Mana Cake', -5, 1)];
        $gildedRose = new GildedRose($items);
        $gildedRose->updateQuality();
        $this->assertSame(0, $items[0]->quality);
    }
}
