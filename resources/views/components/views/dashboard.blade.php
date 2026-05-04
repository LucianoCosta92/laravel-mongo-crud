<div id="view-dashboard">

    {{-- Cards de métricas --}}
    <div class="stats-grid">
        <div class="stat-card">
            <div class="stat-label">Total de tarefas</div>
            <div class="stat-value" id="stat-total">—</div>
        </div>
        <div class="stat-card">
            <div class="stat-label">Pendentes</div>
            <div class="stat-value" id="stat-pending" style="color:var(--text2)">—</div>
        </div>
        <div class="stat-card">
            <div class="stat-label">Em andamento</div>
            <div class="stat-value" id="stat-progress" style="color:var(--info)">—</div>
        </div>
        <div class="stat-card">
            <div class="stat-label">Concluídas</div>
            <div class="stat-value" id="stat-done" style="color:var(--accent)">—</div>
        </div>
    </div>

    {{-- Tarefas recentes --}}
    <div class="section-header" style="margin-top:1rem">
        <h2>Tarefas recentes</h2>
        <button class="btn sm" onclick="showView('tasks')">Ver todas</button>
    </div>
    <div id="dashboard-recent" class="task-list">
        <div class="loading">Carregando...</div>
    </div>

</div>
