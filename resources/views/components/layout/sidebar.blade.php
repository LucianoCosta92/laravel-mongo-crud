<aside class="sidebar">
    <div class="sidebar-logo">TaskManager</div>

    <nav>
        <button class="nav-item active" onclick="showView('dashboard')" id="nav-dashboard">
            <span class="nav-icon">◈</span> Dashboard
        </button>
        <button class="nav-item" onclick="showView('tasks')" id="nav-tasks">
            <span class="nav-icon">☑</span> Tarefas
        </button>
        <button class="nav-item" onclick="showView('categories')" id="nav-categories">
            <span class="nav-icon">◉</span> Categorias
        </button>
    </nav>

    <div class="sidebar-bottom">
        <div class="user-chip">
            <div class="avatar" id="user-avatar">?</div>
            <div>
                <div class="user-name"  id="user-name-display">—</div>
                <div class="user-email" id="user-email-display">—</div>
            </div>
        </div>
        <button class="btn" style="width:100%;font-size:12px" onclick="doLogout()">
            Sair
        </button>
    </div>
</aside>
