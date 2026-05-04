<div id="view-tasks" class="hidden">

    <div class="section-header">
        {{-- Filtros por status --}}
        <div class="filters" id="task-filters">
            <button class="filter-btn active" onclick="filterTasks('')"            data-filter="">Todas</button>
            <button class="filter-btn"        onclick="filterTasks('pending')"     data-filter="pending">Pendentes</button>
            <button class="filter-btn"        onclick="filterTasks('in_progress')" data-filter="in_progress">Em andamento</button>
            <button class="filter-btn"        onclick="filterTasks('completed')"   data-filter="completed">Concluídas</button>
            <button class="filter-btn"        onclick="filterTasks('canceled')"    data-filter="canceled">Canceladas</button>
        </div>

        <button class="btn primary sm" onclick="openTaskModal()">+ Nova tarefa</button>
    </div>

    <div id="task-list" class="task-list">
        <div class="loading">Carregando...</div>
    </div>

</div>
