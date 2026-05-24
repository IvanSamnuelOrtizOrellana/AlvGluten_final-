<?php

namespace App\Livewire;

use Livewire\Attributes\Layout;
use Livewire\Component;
use Livewire\WithPagination;

#[Layout('components.layouts.app')]
class MisPedidos extends Component
{
    use WithPagination;

    public function render()
    {
        // with('items') = Eager Loading
        // Sin esto, cada orden dispara una query extra → problema N+1
        $orders = auth()->user()
            ->orders()
            ->with('items')
            ->paginate(10);

        return view('livewire.mis-pedidos', compact('orders'));
    }
}