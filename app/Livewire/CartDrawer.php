
namespace App\Livewire;

use Livewire\Component;
use Livewire\Attributes\On;

class CartDrawer extends Component
{
#[On('cart-updated')]  // escucha el evento de Catalog.php
public function refresh(): void
{

// provoca un re-render automático del componente
}

public function render()
{
$items = auth()->check()
? auth()->user()->cartProducts()->with('category')->get()
: collect();

$total = $items->sum('price');

return view('livewire.cart-drawer', compact('items', 'total'));
}
}