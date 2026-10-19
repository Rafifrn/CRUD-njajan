<?php

namespace App\Livewire;

use App\Models\Tenant;
use Illuminate\Support\Str;
use Livewire\Attributes\Computed;
use Livewire\Component;
use Livewire\WithFileUploads;

class AdminTenants extends Component
{
    use WithFileUploads;

    public ?int $editId = null;
    public string $name = '';
    public string $description = '';
    public string $slug = '';
    public $logo;
    public string $existingLogo = '';
    public bool $isActive = true;

    protected function rules(): array
    {
        return [
            'name' => 'required|min:2',
            'description' => 'nullable',
            'logo' => 'nullable|image|max:2048',
        ];
    }

    public function edit(int $id): void
    {
        $t = Tenant::findOrFail($id);
        $this->resetValidation();
        $this->editId = $t->id;
        $this->name = $t->name;
        $this->description = $t->description ?? '';
        $this->slug = $t->slug;
        $this->existingLogo = $t->logo ?? '';
        $this->isActive = (bool) $t->is_active;
        $this->logo = null;
    }

    public function save(): void
    {
        $this->validate();

        $data = [
            'name' => $this->name,
            'description' => $this->description,
            'is_active' => $this->isActive,
        ];

        if ($this->logo) {
            $data['logo'] = $this->logo->store('tenants', 'public');
        }

        if ($this->editId) {
            $t = Tenant::findOrFail($this->editId);
            $t->update($data + ['slug' => $this->slug]);
        } else {
            $data['slug'] = Str::slug($this->name) . '-' . Str::lower(Str::random(5));
            Tenant::create($data);
        }

        $this->resetForm();
    }

    public function delete(int $id): void
    {
        Tenant::findOrFail($id)->delete();
        if ($this->editId === $id) {
            $this->resetForm();
        }
    }

    public function toggleActive(int $id): void
    {
        $t = Tenant::findOrFail($id);
        $t->update(['is_active' => ! $t->is_active]);
    }

    public function resetForm(): void
    {
        $this->reset(['editId', 'name', 'description', 'slug', 'logo', 'existingLogo', 'isActive']);
        $this->isActive = true;
    }

    public function render()
    {
        return view('livewire.admin-tenants', [
            'tenants' => Tenant::withCount(['makanans', 'minumen', 'orders'])->orderBy('name')->get(),
        ]);
    }
}
