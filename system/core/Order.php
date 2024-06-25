<?php
namespace Shibaji\Core;

class Order
{
    private $orderId;
    private $items = [];
    private $customerName;
    private $customerEmail;
    private $totalAmount = 0;
    private $status = 'Pending';

    /**
     * Constructor to initialize the order with customer details.
     *
     * @param string $customerName The name of the customer.
     * @param string $customerEmail The email of the customer.
     */
    public function __construct($customerName, $customerEmail)
    {
        $this->orderId = uniqid('order_');
        $this->customerName = $customerName;
        $this->customerEmail = $customerEmail;
    }

    /**
     * Adds an item to the order.
     *
     * @param string $productId The unique identifier of the product.
     * @param string $productName The name of the product.
     * @param float $price The price of the product.
     * @param int $quantity The quantity of the product.
     */
    public function addItem($productId, $productName, $price, $quantity)
    {
        $this->items[$productId] = [
            'name' => $productName,
            'price' => $price,
            'quantity' => $quantity,
        ];
        $this->totalAmount += $price * $quantity;
    }

    /**
     * Removes an item from the order.
     *
     * @param string $productId The unique identifier of the product.
     */
    public function removeItem($productId)
    {
        if (isset($this->items[$productId])) {
            $itemTotal = $this->items[$productId]['price'] * $this->items[$productId]['quantity'];
            unset($this->items[$productId]);
            $this->totalAmount -= $itemTotal;
        }
    }

    /**
     * Updates the quantity of an item in the order.
     *
     * @param string $productId The unique identifier of the product.
     * @param int $quantity The new quantity of the product.
     */
    public function updateQuantity($productId, $quantity)
    {
        if (isset($this->items[$productId])) {
            $currentQuantity = $this->items[$productId]['quantity'];
            $pricePerItem = $this->items[$productId]['price'];

            // Adjust total amount based on quantity change
            $this->totalAmount -= $pricePerItem * $currentQuantity;
            $this->items[$productId]['quantity'] = $quantity;
            $this->totalAmount += $pricePerItem * $quantity;
        }
    }

    /**
     * Sets the status of the order.
     *
     * @param string $status The new status of the order.
     */
    public function setStatus($status)
    {
        $this->status = $status;
    }

    /**
     * Gets the status of the order.
     *
     * @return string The status of the order.
     */
    public function getStatus()
    {
        return $this->status;
    }

    /**
     * Retrieves the total amount of the order.
     *
     * @return float The total amount of the order.
     */
    public function getTotalAmount()
    {
        return $this->totalAmount;
    }

    /**
     * Retrieves details of all items in the order.
     *
     * @return array An array of items in the order.
     */
    public function getItems()
    {
        return $this->items;
    }

    /**
     * Retrieves the customer's name.
     *
     * @return string The name of the customer.
     */
    public function getCustomerName()
    {
        return $this->customerName;
    }

    /**
     * Retrieves the customer's email.
     *
     * @return string The email of the customer.
     */
    public function getCustomerEmail()
    {
        return $this->customerEmail;
    }

    /**
     * Retrieves the unique identifier of the order.
     *
     * @return string The order ID.
     */
    public function getOrderId()
    {
        return $this->orderId;
    }
}