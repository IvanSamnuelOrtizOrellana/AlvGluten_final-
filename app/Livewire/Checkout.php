<?php

namespace App\Livewire;

use App\Mail\ConfirmacionPedido;
use App\Models\Order;
use Livewire\Attributes\Layout;
use Livewire\Component;
use Illuminate\Support\Facades\Mail;

#[Layout('components.layouts.app')]
class Checkout extends Component
{
    //verifica que el carrito no este vacio
    public function mount(): void
    {
        if (!auth()->check()) {
            $this->redirect(route('login'));
            return;
        }

        if (auth()->user()->cartProducts()->count() === 0) {
            $this->redirect(route('home'));
        }
    }

    public function confirmarOrden(): void
    {
        $user  = auth()->user();
        $items = $user->cartProducts()->with('category')->get();

        if ($items->isEmpty()) {
            $this->redirect(route('home'));
            return;
        }

        $total = $items->sum(fn($p) => $p->price * $p->pivot->quantity);

        // crea la orden en la base de datos
        $order = Order::create([
            'user_id' => $user->id,
            'total'   => $total,
            'status'  => 'confirmado',
        ]);

        // crea los items de la orden y guarda en el momento exacto en el que se hizo la orden: el precio y el nombre
        foreach ($items as $item) {
            $order->items()->create([
                'product_id'   => $item->id,
                'product_name' => $item->name,        // snapshot
                'unit_price'   => $item->price,       // snapshot
                'quantity'     => $item->pivot->quantity,
            ]);
        }

        // vacia el carrito de usuario
        $user->cartProducts()->detach();

        // correo de confirmacion
        Mail::to($user->email)->send(new ConfirmacionPedido($order));

        // mensaje de exito
        session()->flash('orden_confirmada', $order->id);
        $this->redirect(route('checkout.exito'), navigate: true);
    }

    public function render()
    {
        $items = auth()->user()->cartProducts()->with('category')->get();
        $total = $items->sum(fn($p) => $p->price * $p->pivot->quantity);

        return view('livewire.checkout', compact('items', 'total'));
    }
}