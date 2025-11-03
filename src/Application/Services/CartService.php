<?php

namespace Application\Services;

class CartService
{
    private const CART_SESSION_KEY = 'shopping_cart';

    public function getCart(): array
    {
        return session()->get(self::CART_SESSION_KEY, []);
    }

    public function addItem(array $item): void
    {
        $cart = $this->getCart();
        $key = $this->generateItemKey($item['shoe_id'], $item['size']);

        if (isset($cart[$key])) {
            $cart[$key]['quantity'] += $item['quantity'];
            $cart[$key]['subtotal'] = $cart[$key]['quantity'] * $cart[$key]['price'];
        } else {
            $cart[$key] = $item;
        }

        session()->put(self::CART_SESSION_KEY, $cart);
    }

    public function updateQuantity(string $key, int $quantity): void
    {
        $cart = $this->getCart();

        if (isset($cart[$key])) {
            if ($quantity <= 0) {
                unset($cart[$key]);
            } else {
                $cart[$key]['quantity'] = $quantity;
                $cart[$key]['subtotal'] = $quantity * $cart[$key]['price'];
            }
            session()->put(self::CART_SESSION_KEY, $cart);
        }
    }

    public function removeItem(string $key): void
    {
        $cart = $this->getCart();
        
        if (isset($cart[$key])) {
            unset($cart[$key]);
            session()->put(self::CART_SESSION_KEY, $cart);
        }
    }

    public function clear(): void
    {
        session()->forget(self::CART_SESSION_KEY);
    }

    public function getItemCount(): int
    {
        $cart = $this->getCart();
        return array_sum(array_column($cart, 'quantity'));
    }

    public function getSubtotal(): float
    {
        $cart = $this->getCart();
        return array_sum(array_column($cart, 'subtotal'));
    }

    private function generateItemKey(int $shoeId, string $size): string
    {
        return "shoe_{$shoeId}_size_{$size}";
    }
}
