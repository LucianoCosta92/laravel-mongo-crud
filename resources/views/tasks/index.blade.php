<x-layouts.app title="Tarefas">
    <x-slot name="actions">
        <a href="{{ route('tasks.create') }}" class="btn primary sm">+ Nova tarefa</a>
    </x-slot>

    {{-- Filtros --}}
    <div class="filters">
        <a href="{{ route('tasks.index') }}"
           class="filter-link {{ !request('status') && !request('priority') ? 'active' : '' }}">
            Todas
        </a>
        <a href="{{ route('tasks.index', ['status' => 'pending']) }}"
           class="filter-link {{ request('status') === 'pending' ? 'active' : '' }}">
            Pendentes
        </a>
        <a href="{{ route('tasks.index', ['status' => 'in_progress']) }}"
           class="filter-link {{ request('status') === 'in_progress' ? 'active' : '' }}">
            Em andamento
        </a>
        <a href="{{ route('tasks.index', ['status' => 'completed']) }}"
           class="filter-link {{ request('status') === 'completed' ? 'active' : '' }}">
            Concluídas
        </a>
        <a href="{{ route('tasks.index', ['status' => 'canceled']) }}"
           class="filter-link {{ request('status') === 'canceled' ? 'active' : '' }}">
            Canceladas
        </a>
        <a href="{{ route('tasks.index', ['priority' => 'high']) }}"
           class="filter-link {{ request('priority') === 'high' ? 'active' : '' }}">
            Alta prioridade
        </a>
    </div>

    @if($tasks->isEmpty())
        <div class="empty">
            <p>Nenhuma tarefa encontrada.</p>
        </div>
    @else
        <div class="card" style="padding:0;overflow:hidden">
            <table>
                <thead>
                    <tr>
                        <th>Título</th>
                        <th>Status</th>
                        <th>Prioridade</th>
                        <th>Categoria</th>
                        <th>Vencimento</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($tasks as $task)
                    <tr>
                        <td>
                            <div style="font-weight:500;{{ $task->status->value === 'completed' ? 'text-decoration:line-through;color:var(--text3)' : '' }}">
                                {{ $task->title }}
                            </div>
                            @if($task->description)
                                <div style="font-size:12px;color:var(--text3);margin-top:2px">
                                    {{ \Str::limit($task->description, 60) }}
                                </div>
                            @endif
                        </td>
                        <td><span class="badge {{ $task->status->value }}">{{ $task->status->label() }}</span></td>
                        <td><span class="badge {{ $task->priority->value }}">{{ $task->priority->label() }}</span></td>
                        <td style="color:var(--text3)">{{ $task->category?->name ?? '—' }}</td>
                        <td style="color:var(--text3)">
                            {{ $task->due_date ? \Carbon\Carbon::parse($task->due_date)->format('d/m/Y') : '—' }}
                        </td>
                        <td>
                            <div style="display:flex;gap:6px;justify-content:flex-end">
                                {{-- Botão concluir rápido --}}
                                @if($task->status->value !== 'completed')
                                <form method="POST" action="{{ route('tasks.complete', $task->id) }}">
                                    @csrf @method('PATCH')
                                    <button type="submit" class="btn sm" title="Marcar como concluída">✓</button>
                                </form>
                                @endif

                                <a href="{{ route('tasks.edit', $task->id) }}" class="btn sm">Editar</a>

                                <form method="POST" action="{{ route('tasks.destroy', $task->id) }}"
                                    onsubmit="return confirm('Excluir esta tarefa?')">
                                    @csrf @method('DELETE')
                                    <button type="submit" class="btn sm danger">Excluir</button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    @endif

</x-layouts.app>
