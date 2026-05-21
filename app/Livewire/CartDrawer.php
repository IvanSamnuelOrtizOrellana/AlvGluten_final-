<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\Attributes\On;

class CartDrawer extends Component
{
    #[On('cart-updated')]
    public function refresh(): void
    {
        // Vacío a propósito — solo necesita que Livewire dispare el re-render
    }

    public function increment(int $productId): void
    {
        $user = auth()->user();
        $item = $user->cartProducts()->where('product_id', $productId)->first();

        if ($item) {
            $user->cartProducts()->updateExistingPivot($productId, [
                'quantity' => $item->pivot->quantity + 1,
            ]);
        }
        $this->dispatch('cart-counter-sync');
    }

    public function decrement(int $productId): void
    {
        $user = auth()->user();
        $item = $user->cartProducts()->where('product_id', $productId)->first();

        if ($item) {
            if ($item->pivot->quantity <= 1) {
                // Si llega a 0, elimina del carrito
                $user->cartProducts()->detach($productId);
            } else {
                $user->cartProducts()->updateExistingPivot($productId, [
                    'quantity' => $item->pivot->quantity - 1,
                ]);
            }
        }
        $this->dispatch('cart-counter-sync');
    }

    public function remove(int $productId): void
    {
        // detach() elimina la fila completa de la tabla pivote
        auth()->user()->cartProducts()->detach($productId);
        $this->dispatch('cart-counter-sync');
    }

    public function render()
    {
        $items = auth()->check()
            ? auth()->user()->cartProducts()->with('category')->get()
            : collect();

        $total = $items->sum(fn($item) => $item->price * $item->pivot->quantity);
        $totalItems = $items->sum(fn($item) => $item->pivot->quantity);

        return view('livewire.cart-drawer', compact('items', 'total', 'totalItems'));
    }
}