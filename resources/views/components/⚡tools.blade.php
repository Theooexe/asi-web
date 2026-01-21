<?php

use App\Models\Tool;
use Livewire\Attributes\Validate;
use Livewire\Component;

new class extends Component {
    #[Validate('required|min:3', message: 'Le nom est trop court')]
    public $name = '';

    #[Validate('required', message: 'La description est obligatoire')]
    public $description = '';

    #[Validate('required|numeric', message: 'Le prix doit être un nombre')]
    public $price = '';

    public $search = '';
    public $sortOrder = 'asc';

    public function save()
    {
        $this->validate();

        Tool::create([
            'name' => $this->name,
            'description' => $this->description,
            'price' => [
                'amount' => (int)$this->price,
                'currency' => 'EUR',           // Ajout de la clé manquante
                'currency_rate' => 1.0,        // Ajout de la clé manquante
            ],
        ]);

        $this->reset(['name', 'description', 'price']);
        session()->flash('message', 'Outil enregistré !');
    }

    public function toggleSort()
    {
        $this->sortOrder = ($this->sortOrder === 'asc') ? 'desc' : 'asc';
    }

    public function with(): array
    {
        return [
            'tools' => Tool::where('name', 'LIKE', '%' . $this->search . '%')
                ->orderBy('name', $this->sortOrder)
                ->get(),
        ];
    }
};
?>

<div class="bg-white p-8 rounded-xl shadow-sm border border-gray-200">
    @if (session()->has('message'))
        <div class="bg-emerald-500 text-white p-4 rounded-lg mb-6 animate-bounce">
            {{ session('message') }}
        </div>
    @endif

    <div class="mb-10 p-6 bg-gray-50 rounded-xl border border-gray-100">
        <h2 class="text-sm font-bold text-gray-400 uppercase tracking-widest mb-4">Ajouter un outil</h2>
        <form wire:submit="save" class="grid grid-cols-1 md:grid-cols-4 gap-4">
            <div>
                <input type="text" wire:model="name" placeholder="Nom" class="w-full border-gray-300 rounded-lg p-2 shadow-sm">
                @error('name') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
            </div>
            <div>
                <input type="number" wire:model="price" placeholder="Prix" class="w-full border-gray-300 rounded-lg p-2 shadow-sm">
                @error('price') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
            </div>
            <div>
                <input type="text" wire:model="description" placeholder="Description" class="w-full border-gray-300 rounded-lg p-2 shadow-sm">
                @error('description') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
            </div>
            <button type="submit" class="bg-indigo-600 hover:bg-indigo-700 text-white font-bold py-2 px-4 rounded-lg transition">
                Enregistrer
            </button>
        </form>
    </div>

    <div class="flex flex-col md:flex-row gap-4 mb-6">
        <div class="relative flex-1">
            <input type="text" wire:model.live="search" placeholder="Filtrer par nom..."
                   class="w-full pl-4 border-gray-300 rounded-lg p-2 bg-white shadow-sm focus:ring-2 focus:ring-indigo-500">
        </div>
        <button wire:click="toggleSort" class="bg-gray-100 hover:bg-gray-200 text-gray-700 font-semibold px-6 py-2 rounded-lg border border-gray-300 transition">
            Trier : {{ $sortOrder === 'asc' ? 'A → Z' : 'Z → A' }}
        </button>
    </div>

    <div class="overflow-hidden border border-gray-100 rounded-lg">
        <table class="w-full text-left bg-white">
            <thead class="bg-gray-50 text-gray-500 uppercase text-xs font-bold">
            <tr>
                <th class="p-4 border-b">Outil</th>
                <th class="p-4 border-b text-right">Prix</th>
                <th class="p-4 border-b">Description</th>
            </tr>
            </thead>
            <tbody class="divide-y divide-gray-100">
            @forelse($tools as $tool)
                <tr class="hover:bg-gray-50 transition">
                    <td class="p-4 font-semibold text-gray-800">{{ $tool->name }}</td>
                    <td class="p-4 text-right font-mono font-bold text-indigo-600">
                        {{ is_array($tool->price) ? $tool->price['amount'] : $tool->price }}€
                    </td>
                    <td class="p-4 text-gray-500 text-sm">{{ $tool->description }}</td>
                </tr>
            @empty
                <tr>
                    <td colspan="3" class="p-8 text-center text-gray-400 italic">Aucun outil trouvé</td>
                </tr>
            @endforelse
            </tbody>
        </table>
    </div>
</div>
