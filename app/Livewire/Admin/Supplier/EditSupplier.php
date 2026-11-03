<?php

namespace App\Livewire\Admin\Supplier;

use App\Models\Supplier;
use Illuminate\Validation\Rule;
use Livewire\Component;

class EditSupplier extends Component
{
    public Supplier $supplier;

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

    public function mount(Supplier $supplier): void
    {
        $this->authorize('update', $supplier);

        $this->supplier = $supplier;
        $this->name = $supplier->name;
        $this->code = $supplier->code;
        $this->email = $supplier->email ?? '';
        $this->phone = $supplier->phone ?? '';
        $this->contact_person = $supplier->contact_person ?? '';
        $this->address = $supplier->address ?? '';
        $this->city = $supplier->city ?? '';
        $this->postal_code = $supplier->postal_code ?? '';
        $this->country = $supplier->country ?? '';
        $this->website = $supplier->website ?? '';
        $this->payment_terms = $supplier->payment_terms ?? '';
        $this->notes = $supplier->notes ?? '';
        $this->is_active = $supplier->is_active;
    }

    protected function rules(): array
    {
        return [
            'name' => ['required', 'string', 'max:255'],
            'code' => ['required', 'string', 'max:255', Rule::unique('suppliers', 'code')->ignore($this->supplier->id)],
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

    public function update(): void
    {
        $this->authorize('update', $this->supplier);
        $validated = $this->validate();
        $validated['name'] = trim($validated['name']);
        $validated['code'] = trim($validated['code']);

        $this->supplier->update($validated);

        session()->flash('success', 'Supplier information updated successfully.');
        $this->redirect(route('admin.suppliers.view', $this->supplier));
    }

    public function render()
    {
        $this->authorize('update', $this->supplier);

        return view('livewire.admin.supplier.edit-supplier')
            ->layout('layouts.admin');
    }
}
