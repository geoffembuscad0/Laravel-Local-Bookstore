<?php

namespace App\Livewire\Admin\Supplier;

use App\Models\Supplier;
use Illuminate\Validation\Rule;
use Livewire\Component;

class CreateSupplier extends Component
{
    public string $name = '';
    public string $code = '';
    public string $email = '';
    public string $phone = '';
    public string $contact_person = '';
    public string $address = '';
    public string $city = '';
    public string $postal_code = '';
    public string $country = '';
    public string $website = '';
    public string $payment_terms = '';
    public string $notes = '';
    public bool $is_active = true;

    protected function rules(): array
    {
        return [
            'name' => ['required', 'string', 'max:255'],
            'code' => ['required', 'string', 'max:255', Rule::unique('suppliers', 'code')],
            'email' => ['nullable', 'email', 'max:255'],
            'phone' => ['nullable', 'string', 'max:255'],
            'contact_person' => ['nullable', 'string', 'max:255'],
            'address' => ['nullable', 'string'],
            'city' => ['nullable', 'string', 'max:255'],
            'postal_code' => ['nullable', 'string', 'max:255'],
            'country' => ['nullable', 'string', 'max:255'],
            'website' => ['nullable', 'url', 'max:255'],
            'payment_terms' => ['nullable', 'string', 'max:255'],
            'notes' => ['nullable', 'string'],
            'is_active' => ['boolean'],
        ];
    }

    public function save(): void
    {
        $this->authorize('create', Supplier::class);
        $validated = $this->validate();
        $validated['name'] = trim($validated['name']);
        $validated['code'] = trim($validated['code']);

        $supplier = Supplier::create($validated);

        session()->flash('success', 'Supplier registered successfully.');
        $this->redirect(route('admin.suppliers.view', $supplier));
    }

    public function render()
    {
        $this->authorize('create', Supplier::class);

        return view('livewire.admin.supplier.create-supplier')
            ->layout('layouts.admin');
    }
}
