<?php

namespace App\Livewire\Admin;

use App\Models\Category;
use App\Models\Product;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Validate;
use Livewire\Component;
use Livewire\WithFileUploads;
use Illuminate\Support\Facades\Gate;
use Illuminate\Auth\Access\AuthorizationException;

#[Layout('components.layouts.admin')]
class ProductCreate extends Component
{
    use WithFileUploads;

    #[Validate('required|string|min:3|max:255')]
    public string $name = '';

    #[Validate('required|string|min:10')]
    public string $description = '';

    #[Validate('required|numeric|min:0.01|max:99999')]
    public string $price = '';

    #[Validate('required|exists:categories,id')]
    public string $category_id = '';

    #[Validate('boolean')]
    public bool $is_gluten_free = true;

    #[Validate('nullable|image|mimes:jpg,jpeg,png,webp|max:2048')]
    public $imagen = null;

    public function save(): void
    {
        if (auth()->user()->rol !== 'admin') {
            throw new AuthorizationException('No tienes permiso para crear productos.');
        }
        Gate::authorize('es-admin');
        $this->validate();

        $imagePath = $this->imagen
            ? $this->imagen->store('products', 'public')
            : null;

        Product::create([
            'name'           => $this->name,
            'description'    => $this->description,
            'price'          => $this->price,
            'category_id'    => $this->category_id,
            'is_gluten_free' => $this->is_gluten_free,
            'image_path'     => $imagePath,
        ]);

        session()->flash('success', "Producto \"{$this->name}\" creado exitosamente.");
        $this->redirect(route('admin.productos.index'), navigate: true);
    }

    public function render()
    {
        return view('livewire.admin.product-create', [
            'categories' => Category::orderBy('name')->get(),
        ]);
    }
}