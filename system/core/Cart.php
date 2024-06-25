<?php
namespace Shibaji\Core;

class Cart
{
    private $items = [];

    /**
     * Add an item to the cart.
     *
     * @param string $productId The unique identifier of the product.
     * @param string $name The name of the product.
     * @param float $price The price of the product.
     * @param int $quantity The quantity of the product to add.
     */
    public function addItem($productId, $name, $price, $quantity = 1)
    {
        if (isset($this->items[$productId])) {
            $this->items[$productId]['quantity'] += $quantity;
        } else {
            $this->items[$productId] = [
                'name' => $name,
                'price' => $price,
                'quantity' => $quantity,
            ];
        }
    }

    /**
     * Remove an item from the cart.
     *
     * @param string $productId The unique identifier of the product.
     */
    public function removeItem($productId)
    {
        if (isset($this->items[$productId])) {
            unset($this->items[$productId]);
        }
    }

    /**
     * Update the quantity of an item in the cart.
     *
     * @param string $productId The unique identifier of the product.
     * @param int $quantity The new quantity of the product.
     */
    public function updateQuantity($productId, $quantity)
    {
        if (isset($this->items[$productId])) {
            if ($quantity <= 0) {
                $this->removeItem($productId);
            } else {
                $this->items[$productId]['quantity'] = $quantity;
            }
        }
    }

    /**
     * Get all items in the cart.
     *
     * @return array The items in the cart.
     */
    public function getItems()
    {
        return $this->items;
    }

    /**
     * Calculate the total cost of items in the cart.
     *
     * @return float The total cost.
     */
    public function getTotal()
    {
        $total = 0;
        foreach ($this->items as $item) {
            $total += $item['price'] * $item['quantity'];
        }
        return $total;
    }

    /**
     * Clear all items from the cart.
     */
    public function clear()
    {
        $this->items = [];
    }
}