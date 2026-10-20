<?php

namespace App\Livewire;

use App\Models\Makanan;
use App\Models\Minuman;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Livewire\Attributes\Computed;
use Livewire\Component;
use Livewire\WithFileUploads;

class TenantProducts extends Component
{
    use WithFileUploads;

    public string $filter = 'semua'; // semua | makanan | jajanan | minuman

    // Form fields
    public ?int $editId = null;
    public string $formType = 'makanan'; // makanan | minuman (makanan table menyimpan kategori makanan/jajanan)
    public string $formCategory = 'makanan';
    public string $name = '';
    public string $description = '';
    public ?float $price = null;
    public $image;
    public string $existingImage = '';
    public bool $isAvailable = true;

    protected function messages(): array
    {
        return [
            'image.max' => 'Ukuran gambar maksimal 10 MB.',
            'logo.max' => 'Ukuran logo maksimal 1 MB.',
            'logo.dimensions' => 'Logo harus persegi (rasio 1:1).',
        ];
    }

    protected function rules(): array
    {
        return [
            'name' => 'required|min:2',
            'description' => 'nullable',
            'price' => 'required|numeric|min:0',
            'formCategory' => 'required|in:makanan,jajanan,minuman',
            'image' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:10240',
        ];
    }

    public function updatedFormType(string $value): void
    {
        if ($value === 'minuman') {
            $this->formCategory = 'minuman';
        } elseif ($this->formCategory === 'minuman') {
            $this->formCategory = 'makanan';
        }
    }

    #[Computed]
    public function tenant()
    {
        return Auth::user()->tenant;
    }

    public function setFilter(string $filter): void
    {
        $this->filter = $filter;
    }

    public function editMakanan(int $id): void
    {
        $p = Makanan::where('tenant_id', $this->tenant()->id)->findOrFail($id);
        $this->resetValidation();
        $this->editId = $p->id;
        $this->formType = 'makanan';
        $this->formCategory = $p->category;
        $this->name = $p->name;
        $this->description = $p->description ?? '';
        $this->price = (float) $p->price;
        $this->existingImage = $p->image ?? '';
        $this->isAvailable = (bool) $p->is_available;
        $this->image = null;
    }

    public function editMinuman(int $id): void
    {
        $p = Minuman::where('tenant_id', $this->tenant()->id)->findOrFail($id);
        $this->resetValidation();
        $this->editId = $p->id;
        $this->formType = 'minuman';
        $this->formCategory = 'minuman';
        $this->name = $p->name;
        $this->description = $p->description ?? '';
        $this->price = (float) $p->price;
        $this->existingImage = $p->image ?? '';
        $this->isAvailable = (bool) $p->is_available;
        $this->image = null;
    }

    public function save(): void
    {
        $this->validate();

        $data = [
            'name' => $this->name,
            'description' => $this->description,
            'price' => $this->price,
            'is_available' => $this->isAvailable,
            'tenant_id' => $this->tenant()->id,
        ];

        if ($this->image) {
            $data['image'] = \App\Services\SquareImage::store($this->image, 'produk');
        }

        if ($this->formType === 'makanan') {
            $data['category'] = $this->formCategory === 'jajanan' ? 'jajanan' : 'makanan';
            if (! isset($data['image']) && ! $this->editId) {
                $data['image'] = '';
            }
            if ($this->editId) {
                $m = Makanan::where('tenant_id', $this->tenant->id)->findOrFail($this->editId);
                $m->update($data);
            } else {
                $data['slug'] = Str::slug($this->name) . '-' . Str::lower(Str::random(6));
                Makanan::create($data);
            }
        } else {
            if ($this->editId) {
                $m = Minuman::where('tenant_id', $this->tenant->id)->findOrFail($this->editId);
                $m->update($data);
            } else {
                $data['slug'] = Str::slug($this->name) . '-' . Str::lower(Str::random(6));
                Minuman::create($data);
            }
        }

        $this->resetForm();
    }

    public function deleteMakanan(int $id): void
    {
        Makanan::where('tenant_id', $this->tenant()->id)->where('id', $id)->delete();
        if ($this->editId === $id && $this->formType === 'makanan') {
            $this->resetForm();
        }
    }

    public function deleteMinuman(int $id): void
    {
        Minuman::where('tenant_id', $this->tenant()->id)->where('id', $id)->delete();
        if ($this->editId === $id && $this->formType === 'minuman') {
            $this->resetForm();
        }
    }

    public function toggleAvailableMakanan(int $id): void
    {
        $m = Makanan::where('tenant_id', $this->tenant()->id)->findOrFail($id);
        $m->update(['is_available' => ! $m->is_available]);
    }

    public function toggleAvailableMinuman(int $id): void
    {
        $m = Minuman::where('tenant_id', $this->tenant()->id)->findOrFail($id);
        $m->update(['is_available' => ! $m->is_available]);
    }

    public function resetForm(): void
    {
        $this->reset(['editId', 'formType', 'formCategory', 'name', 'description', 'price', 'image', 'existingImage', 'isAvailable']);
        $this->formType = 'makanan';
        $this->formCategory = 'makanan';
        $this->isAvailable = true;
    }

    public function render()
    {
        $makanans = Makanan::where('tenant_id', $this->tenant()->id)
            ->when($this->filter === 'makanan', fn ($q) => $q->where('category', 'makanan'))
            ->when($this->filter === 'jajanan', fn ($q) => $q->where('category', 'jajanan'))
            ->orderBy('name')
            ->get();

        $minumans = Minuman::where('tenant_id', $this->tenant()->id)
            ->when($this->filter !== 'semua' && $this->filter !== 'minuman', fn ($q) => $q->whereRaw('1 = 0'))
            ->orderBy('name')
            ->get();

        return view('livewire.tenant-products', [
            'tenant' => $this->tenant(),
            'makanans' => $makanans,
            'minumans' => $minumans,
        ]);
    }
}
