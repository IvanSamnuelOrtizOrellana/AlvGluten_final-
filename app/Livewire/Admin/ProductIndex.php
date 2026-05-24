<?php

namespace App\Livewire\Admin;

use App\Models\Product;
use Livewire\Attributes\Computed;
use Livewire\Attributes\Layout;
use Livewire\Component;
use Livewire\WithPagination;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Storage;

#[Layout('components.layouts.admin')]
class ProductIndex extends Component
{
    use WithPagination;

    public string $search = '';
    public bool $mostrarEliminados = false;

    #[Computed]
    public function products()
    {
        $query = $this->mostrarEliminados
            ? Product::withTrashed()
            : Product::query();

        return $query
            ->with('category')
            ->when($this->search, fn($q) =>
            $q->where('name', 'like', "%{$this->search}%")
            )
            ->latest()
            ->paginate(10);
    }

    public function softDelete(int $id): void
    {
        Gate::authorize('es-admin');
        $product = Product::findOrFail($id);
        $product->delete(); // Soft delete: pone deleted_at, NO borra el registro
        session()->flash('success', "Producto \"{$product->name}\" eliminado.");
    }

    public function restore(int $id): void
    {
        Gate::authorize('es-admin');
        Product::withTrashed()->findOrFail($id)->restore();
        session()->flash('success', 'Producto restaurado correctamente.');
    }

    public function forceDelete(int $id): void
    {
        Gate::authorize('es-admin');
        $product = Product::withTrashed()->findOrFail($id);
        if ($product->image_path) {
            Storage::disk('public')->delete($product->image_path);
        }
        $product->forceDelete(); // Borrado permanente e irreversible
        session()->flash('success', 'Producto eliminado permanentemente.');
    }

    public function updatingSearch(): void
    {
        $this->resetPage();
    }

    public function render()
    {
        return view('livewire.admin.product-index');
    }
}