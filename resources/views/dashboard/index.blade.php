<x-layouts.app title="Dashboard">

    <div class="stats-grid">
        <div class="stat-card">
            <div class="stat-label">Total de tarefas</div>
            <div class="stat-value">{{ $total }}</div>
        </div>
        <div class="stat-card">
            <div class="stat-label">Pendentes</div>
            <div class="stat-value" style="color:var(--text2)">{{ $pending }}</div>
        </div>
        <div class="stat-card">
            <div class="stat-label">Em andamento</div>
            <div class="stat-value" style="color:var(--info)">{{ $inProgress }}</div>
        </div>
        <div class="stat-card">
            <div class="stat-label">Concluídas</div>
            <div class="stat-value" style="color:var(--accent)">{{ $completed }}</div>
        </div>
    </div>

    <div class="section-header">
        <h2>Tarefas recentes</h2>
        <a href="{{ route('tasks.index') }}" class="btn sm">Ver todas</a>
    </div>

    @if($recentTasks->isEmpty())
        <div class="empty">
            <p>Nenhuma tarefa ainda. <a href="{{ route('tasks.create') }}">Criar primeira tarefa</a></p>
        </div>
    @else
        <div class="card" style="padding:0;overflow:hidden">
            <table>
                <thead>
                    <tr>
                        <th>Título</th>
                        <th>Status</th>
                        <th>Prioridade</th>
                        <th>Vencimento</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($recentTasks as $task)
                    <tr>
                        <td>
                            <a href="{{ route('tasks.edit', $task->id) }}"
                                style="color:var(--text);text-decoration:none;font-weight:500">
                                {{ $task->title }}
                            </a>
                        </td>
                        <td><span class="badge {{ $task->status->value }}">{{ $task->status->label() }}</span></td>
                        <td><span class="badge {{ $task->priority->value }}">{{ $task->priority->label() }}</span></td>
                        <td style="color:var(--text3)">
                            {{ $task->due_date ? \Carbon\Carbon::parse($task->due_date)->format('d/m/Y') : '—' }}
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    @endif

</x-layouts.app>
