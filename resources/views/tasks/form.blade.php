{{-- Usado tanto em create quanto em edit --}}
<x-layouts.app :title="isset($task) ? 'Editar tarefa' : 'Nova tarefa'">
    <x-slot name="actions">
        <a href="{{ route('tasks.index') }}" class="btn sm">← Voltar</a>
    </x-slot>

    <div class="card" style="max-width:640px">
        <form method="POST"
            action="{{ isset($task) ? route('tasks.update', $task->id) : route('tasks.store') }}">
            @csrf
            @if(isset($task)) @method('PUT') @endif

            <div class="field">
                <label>Título *</label>
                <input type="text" name="title"
                    value="{{ old('title', $task->title ?? '') }}"
                    placeholder="Título da tarefa" required />
                @error('title') <span class="error">{{ $message }}</span> @enderror
            </div>

            <div class="field">
                <label>Descrição</label>
                <textarea name="description" placeholder="Descrição (opcional)">{{ old('description', $task->description ?? '') }}</textarea>
                @error('description') <span class="error">{{ $message }}</span> @enderror
            </div>

            <div class="two-col">
                <div class="field">
                    <label>Status *</label>
                    <select name="status">
                        @foreach(\App\Enums\TaskStatus::cases() as $status)
                            <option value="{{ $status->value }}"
                                {{ old('status', $task->status->value ?? 'pending') === $status->value ? 'selected' : '' }}>
                                {{ $status->label() }}
                            </option>
                        @endforeach
                    </select>
                    @error('status') <span class="error">{{ $message }}</span> @enderror
                </div>

                <div class="field">
                    <label>Prioridade *</label>
                    <select name="priority">
                        @foreach(\App\Enums\TaskPriority::cases() as $priority)
                            <option value="{{ $priority->value }}"
                                {{ old('priority', $task->priority->value ?? 'low') === $priority->value ? 'selected' : '' }}>
                                {{ $priority->label() }}
                            </option>
                        @endforeach
                    </select>
                    @error('priority') <span class="error">{{ $message }}</span> @enderror
                </div>
            </div>

            <div class="two-col">
                <div class="field">
                    <label>Categoria</label>
                    <select name="category_id">
                        <option value="">Sem categoria</option>
                        @foreach($categories as $category)
                            <option value="{{ $category->id }}"
                                {{ old('category_id', $task->category_id ?? '') === $category->id ? 'selected' : '' }}>
                                {{ $category->name }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="field">
                    <label>Data de vencimento</label>
                    <input type="date" name="due_date"
                        value="{{ old('due_date', isset($task->due_date) ? \Carbon\Carbon::parse($task->due_date)->format('Y-m-d') : '') }}" />
                    @error('due_date') <span class="error">{{ $message }}</span> @enderror
                </div>
            </div>

            <div style="display:flex;gap:8px;margin-top:.5rem">
                <button type="submit" class="btn primary">
                    {{ isset($task) ? 'Salvar alterações' : 'Criar tarefa' }}
                </button>
                <a href="{{ route('tasks.index') }}" class="btn">Cancelar</a>
            </div>
        </form>
    </div>

</x-layouts.app>
