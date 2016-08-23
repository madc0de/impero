<?php namespace Derive\Basket\Service;

use Derive\Basket\Service\Summary\Item;

class Summary
{

    protected $items = [];

    public function addItem(Item $item)
    {
        $this->items = $item;

        return $this;
    }

    public function getSum()
    {
        $sum = 0.0;
        $this->items->each(
            function(Item $item) use (&$sum) {
                $sum += $item->getTotal();
            }
        );

        return $sum;
    }

    public function getProcessingCost()
    {
        $min = config('defaults.derive.basket.processingCost.min');
        $max = config('defaults.derive.basket.processingCost.max');
        $ratio = config('defaults.derive.basket.processingCost.ratio');

        $sum = $this->getSum();
        $cost = $sum * $ratio;

        if ($cost < $min) {
            return $min;

        } else if ($cost > $max) {
            return $max;

        } else {
            return $cost;

        }
    }

}