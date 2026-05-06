<x-layouts.app :title="isset($category) ? 'Editar categoria' : 'Nova categoria'">
    <x-slot name="actions">
        <a href="{{ route('categories.index') }}" class="btn sm">← Voltar</a>
    </x-slot>

    <div class="card" style="max-width:400px">
        <form method="POST"
            action="{{ isset($category) ? route('categories.update', $category->id) : route('categories.store') }}">
            @csrf
            @if(isset($category)) @method('PUT') @endif

            <div class="field">
                <label>Nome *</label>
                <input type="text" name="name"
                    value="{{ old('name', $category->name ?? '') }}"
                    placeholder="Nome da categoria" required />
                @error('name') <span class="error">{{ $message }}</span> @enderror
            </div>

            <div class="field">
                <label>Cor *</label>
                <input type="color" name="color"
                    value="{{ old('color', $category->color ?? '#1D9E75') }}" />
                @error('color') <span class="error">{{ $message }}</span> @enderror
            </div>

            <div style="display:flex;gap:8px;margin-top:.5rem">
                <button type="submit" class="btn primary">
                    {{ isset($category) ? 'Salvar alterações' : 'Criar categoria' }}
                </button>
                <a href="{{ route('categories.index') }}" class="btn">Cancelar</a>
            </div>
        </form>
    </div>

</x-layouts.app>
