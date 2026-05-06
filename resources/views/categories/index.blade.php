<x-layouts.app title="Categorias">
    <x-slot name="actions">
        <a href="{{ route('categories.create') }}" class="btn primary sm">+ Nova categoria</a>
    </x-slot>

    @if($categories->isEmpty())
        <div class="empty">
            <p>Nenhuma categoria ainda. <a href="{{ route('categories.create') }}">Criar primeira categoria</a></p>
        </div>
    @else
        <div class="cat-grid">
            @foreach($categories as $category)
            <div class="cat-card">
                <div class="cat-dot-row">
                    <div class="cat-dot" style="background:{{ $category->color }}"></div>
                    <div class="cat-name">{{ $category->name }}</div>
                </div>
                <div class="cat-count">{{ $category->tasks_count }} tarefa{{ $category->tasks_count !== 1 ? 's' : '' }}</div>
                <div class="cat-actions">
                    <a href="{{ route('categories.edit', $category->id) }}" class="btn sm">Editar</a>
                    <form method="POST" action="{{ route('categories.destroy', $category->id) }}"
                        onsubmit="return confirm('Excluir esta categoria?')">
                        @csrf @method('DELETE')
                        <button type="submit" class="btn sm danger">Excluir</button>
                    </form>
                </div>
            </div>
            @endforeach
        </div>
    @endif

</x-layouts.app>
