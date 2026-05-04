// ─── CONFIG ──────────────────────────────────────────────────────────────────
const API = 'http://127.0.0.1:8000/api';

// ─── STATE ───────────────────────────────────────────────────────────────────
let token       = localStorage.getItem('token') || null;
let currentUser = JSON.parse(localStorage.getItem('user') || 'null');
let tasks       = [];
let categories  = [];
let editTaskId  = null;
let editCatId   = null;
let currentFilter = '';

// ─── INIT ─────────────────────────────────────────────────────────────────────
document.addEventListener('DOMContentLoaded', () => {
    const colorInput = document.getElementById('cat-color');
    if (colorInput) {
        colorInput.addEventListener('input', e => {
            document.getElementById('cat-color-hex').textContent = e.target.value;
        });
    }

    const passwordInput = document.getElementById('login-password');
    if (passwordInput) {
        passwordInput.addEventListener('keydown', e => {
            if (e.key === 'Enter') doLogin();
        });
    }

    // Fechar modais clicando no overlay
    document.querySelectorAll('.modal-overlay').forEach(overlay => {
        overlay.addEventListener('click', e => {
            if (e.target === overlay) overlay.classList.add('hidden');
        });
    });

    if (token && currentUser) bootApp();
});

// ─── TOAST ───────────────────────────────────────────────────────────────────
function toast(msg, type = 'ok') {
    const container = document.getElementById('toast');
    const el = document.createElement('div');
    el.className = `toast-msg ${type}`;
    el.textContent = msg;
    container.appendChild(el);
    setTimeout(() => el.remove(), 3200);
}

// ─── API HELPER ───────────────────────────────────────────────────────────────
async function api(method, path, body) {
    const opts = {
        method,
        headers: {
            'Content-Type': 'application/json',
            'Accept': 'application/json',
        },
    };
    if (token) opts.headers['Authorization'] = `Bearer ${token}`;
    if (body)  opts.body = JSON.stringify(body);

    const res  = await fetch(API + path, opts);
    const data = await res.json().catch(() => ({}));
    if (!res.ok) throw data;
    return data;
}

// ─── AUTH ─────────────────────────────────────────────────────────────────────
async function doLogin() {
    const email    = document.getElementById('login-email').value.trim();
    const password = document.getElementById('login-password').value;

    if (!email || !password) return toast('Preencha e-mail e senha.', 'err');

    try {
        const data = await api('POST', '/login', { email, password });
        token       = data.token;
        currentUser = data.user;
        localStorage.setItem('token', token);
        localStorage.setItem('user', JSON.stringify(currentUser));
        bootApp();
    } catch (e) {
        toast(e.message || 'Credenciais inválidas.', 'err');
    }
}

function showRegister() {
    document.getElementById('modal-register').classList.remove('hidden');
}

async function doRegister() {
    const name     = document.getElementById('reg-name').value.trim();
    const email    = document.getElementById('reg-email').value.trim();
    const password = document.getElementById('reg-password').value;
    const confirm  = document.getElementById('reg-confirm').value;

    if (!name || !email || !password) return toast('Preencha todos os campos.', 'err');
    if (password !== confirm)         return toast('As senhas não coincidem.', 'err');
    if (password.length < 8)          return toast('Senha mínima de 8 caracteres.', 'err');

    try {
        await api('POST', '/users', { name, email, password, password_confirmation: confirm });
        toast('Conta criada! Faça login.');
        closeModal('modal-register');
        document.getElementById('login-email').value = email;
    } catch (e) {
        const msg = e.errors
            ? Object.values(e.errors).flat().join(' ')
            : (e.message || 'Erro ao criar conta.');
        toast(msg, 'err');
    }
}

async function doLogout() {
    try { await api('POST', '/logout'); } catch (_) {}
    token = null;
    currentUser = null;
    localStorage.removeItem('token');
    localStorage.removeItem('user');
    document.getElementById('page-app').classList.add('hidden');
    document.getElementById('page-login').classList.remove('hidden');
    toast('Até logo!');
}

// ─── BOOT ─────────────────────────────────────────────────────────────────────
function bootApp() {
    document.getElementById('page-login').classList.add('hidden');
    document.getElementById('page-app').classList.remove('hidden');

    const initials = (currentUser?.name || '?')
        .split(' ')
        .map(w => w[0])
        .slice(0, 2)
        .join('')
        .toUpperCase();

    document.getElementById('user-avatar').textContent       = initials;
    document.getElementById('user-name-display').textContent  = currentUser?.name  || '—';
    document.getElementById('user-email-display').textContent = currentUser?.email || '—';

    loadAll();
    showView('dashboard');
}

async function loadAll() {
    await Promise.all([loadTasks(), loadCategories()]);
    renderDashboard();
}

// ─── VIEWS ────────────────────────────────────────────────────────────────────
function showView(v) {
    ['dashboard', 'tasks', 'categories'].forEach(id => {
        document.getElementById('view-' + id).classList.toggle('hidden', id !== v);
        document.getElementById('nav-' + id).classList.toggle('active', id === v);
    });

    const titles = { dashboard: 'Dashboard', tasks: 'Tarefas', categories: 'Categorias' };
    document.getElementById('topbar-title').textContent = titles[v];

    if (v === 'tasks')      renderTasks();
    if (v === 'categories') renderCategories();
}

// ─── TASKS ────────────────────────────────────────────────────────────────────
async function loadTasks() {
    try {
        tasks = await api('GET', '/tasks');
    } catch (_) {
        tasks = [];
    }
}

function filterTasks(f) {
    currentFilter = f;
    document.querySelectorAll('.filter-btn').forEach(b => {
        b.classList.toggle('active', b.dataset.filter === f);
    });
    renderTasks();
}

function renderTasks() {
    const list     = document.getElementById('task-list');
    const filtered = currentFilter ? tasks.filter(t => t.status === currentFilter) : tasks;

    if (!filtered.length) {
        list.innerHTML = '<div class="empty"><div class="empty-icon">☑</div><p>Nenhuma tarefa encontrada.</p></div>';
        return;
    }
    list.innerHTML = filtered.map(taskCard).join('');
}

function taskCard(t) {
    const done    = t.status === 'completed';
    const catName = (categories.find(c => c.id === t.category_id) || {}).name || '';
    return `
    <div class="task-card" id="tc-${t.id}">
        <div class="task-check ${done ? 'done' : ''}" onclick="toggleTask('${t.id}','${t.status}')"></div>
        <div class="task-body">
            <div class="task-title ${done ? 'done' : ''}">${esc(t.title)}</div>
            <div class="task-meta">
                <span class="badge ${t.status}">${statusLabel(t.status)}</span>
                <span class="badge ${t.priority}">${priorityLabel(t.priority)}</span>
                ${catName ? `<span style="font-size:11px;color:var(--text3)">${esc(catName)}</span>` : ''}
                ${t.due_date ? `<span style="font-size:11px;color:var(--text3)">⏱ ${t.due_date.slice(0,10)}</span>` : ''}
            </div>
        </div>
        <div class="task-actions">
            <button class="icon-btn" onclick="openTaskModal('${t.id}')" title="Editar">✎</button>
            <button class="icon-btn del" onclick="deleteTask('${t.id}')" title="Excluir">✕</button>
        </div>
    </div>`;
}

function openTaskModal(id) {
    editTaskId = id || null;
    document.getElementById('modal-task-title').textContent = id ? 'Editar tarefa' : 'Nova tarefa';

    // Popula dropdown de categorias
    const sel = document.getElementById('task-category');
    sel.innerHTML = '<option value="">Sem categoria</option>' +
        categories.map(c => `<option value="${c.id}">${esc(c.name)}</option>`).join('');

    if (id) {
        const t = tasks.find(x => x.id === id);
        if (!t) return;
        document.getElementById('task-title').value    = t.title || '';
        document.getElementById('task-desc').value     = t.description || '';
        document.getElementById('task-status').value   = t.status || 'pending';
        document.getElementById('task-priority').value = t.priority || 'low';
        document.getElementById('task-category').value = t.category_id || '';
        document.getElementById('task-due').value      = (t.due_date || '').slice(0, 10);
    } else {
        document.getElementById('task-title').value    = '';
        document.getElementById('task-desc').value     = '';
        document.getElementById('task-status').value   = 'pending';
        document.getElementById('task-priority').value = 'low';
        document.getElementById('task-category').value = '';
        document.getElementById('task-due').value      = '';
    }

    document.getElementById('modal-task').classList.remove('hidden');
}

async function saveTask() {
    const title    = document.getElementById('task-title').value.trim();
    const status   = document.getElementById('task-status').value;
    const priority = document.getElementById('task-priority').value;

    if (!title) return toast('Informe o título.', 'err');

    const body = {
        title,
        description:  document.getElementById('task-desc').value || null,
        status,
        priority,
        category_id:  document.getElementById('task-category').value || null,
        due_date:     document.getElementById('task-due').value || null,
    };

    try {
        if (editTaskId) {
            const updated = await api('PUT', `/tasks/${editTaskId}`, body);
            tasks = tasks.map(t => t.id === editTaskId ? updated : t);
            toast('Tarefa atualizada.');
        } else {
            const created = await api('POST', '/tasks', body);
            tasks.unshift(created);
            toast('Tarefa criada.');
        }
        closeModal('modal-task');
        renderTasks();
        renderDashboard();
    } catch (e) {
        const msg = e.errors
            ? Object.values(e.errors).flat().join(' ')
            : (e.message || 'Erro ao salvar.');
        toast(msg, 'err');
    }
}

async function toggleTask(id, currentStatus) {
    const newStatus = currentStatus === 'completed' ? 'pending' : 'completed';
    try {
        const updated = await api('PUT', `/tasks/${id}`, { status: newStatus });
        tasks = tasks.map(t => t.id === id ? updated : t);
        renderTasks();
        renderDashboard();
    } catch (_) {
        toast('Erro ao atualizar.', 'err');
    }
}

async function deleteTask(id) {
    if (!confirm('Excluir esta tarefa?')) return;
    try {
        await api('DELETE', `/tasks/${id}`);
        tasks = tasks.filter(t => t.id !== id);
        toast('Tarefa excluída.');
        renderTasks();
        renderDashboard();
    } catch (_) {
        toast('Erro ao excluir.', 'err');
    }
}

// ─── CATEGORIES ───────────────────────────────────────────────────────────────
async function loadCategories() {
    try {
        categories = await api('GET', '/categories');
    } catch (_) {
        categories = [];
    }
}

function renderCategories() {
    const grid = document.getElementById('cat-grid');

    if (!categories.length) {
        grid.innerHTML = '<div class="empty"><div class="empty-icon">◉</div><p>Nenhuma categoria ainda.</p></div>';
        return;
    }

    grid.innerHTML = categories.map(c => {
        const count = tasks.filter(t => t.category_id === c.id).length;
        return `
        <div class="cat-card">
            <div class="cat-dot-row">
                <div class="cat-dot" style="background:${c.color}"></div>
                <div class="cat-name">${esc(c.name)}</div>
            </div>
            <div class="cat-count">${count} tarefa${count !== 1 ? 's' : ''}</div>
            <div class="cat-actions">
                <button class="btn sm" onclick="openCatModal('${c.id}')">Editar</button>
                <button class="btn sm danger" onclick="deleteCat('${c.id}')">Excluir</button>
            </div>
        </div>`;
    }).join('');
}

function openCatModal(id) {
    editCatId = id || null;
    document.getElementById('modal-cat-title').textContent = id ? 'Editar categoria' : 'Nova categoria';

    if (id) {
        const c = categories.find(x => x.id === id);
        if (!c) return;
        document.getElementById('cat-name').value  = c.name;
        document.getElementById('cat-color').value = c.color;
        document.getElementById('cat-color-hex').textContent = c.color;
    } else {
        document.getElementById('cat-name').value  = '';
        document.getElementById('cat-color').value = '#1D9E75';
        document.getElementById('cat-color-hex').textContent = '#1D9E75';
    }

    document.getElementById('modal-cat').classList.remove('hidden');
}

async function saveCat() {
    const name  = document.getElementById('cat-name').value.trim();
    const color = document.getElementById('cat-color').value;

    if (!name) return toast('Informe o nome.', 'err');

    try {
        if (editCatId) {
            const updated = await api('PUT', `/categories/${editCatId}`, { name, color });
            categories = categories.map(c => c.id === editCatId ? updated : c);
            toast('Categoria atualizada.');
        } else {
            const created = await api('POST', '/categories', { name, color });
            categories.push(created);
            toast('Categoria criada.');
        }
        closeModal('modal-cat');
        renderCategories();
    } catch (e) {
        const msg = e.errors
            ? Object.values(e.errors).flat().join(' ')
            : (e.message || 'Erro ao salvar.');
        toast(msg, 'err');
    }
}

async function deleteCat(id) {
    if (!confirm('Excluir esta categoria?')) return;
    try {
        await api('DELETE', `/categories/${id}`);
        categories = categories.filter(c => c.id !== id);
        toast('Categoria excluída.');
        renderCategories();
    } catch (_) {
        toast('Erro ao excluir.', 'err');
    }
}

// ─── DASHBOARD ────────────────────────────────────────────────────────────────
function renderDashboard() {
    document.getElementById('stat-total').textContent    = tasks.length;
    document.getElementById('stat-pending').textContent  = tasks.filter(t => t.status === 'pending').length;
    document.getElementById('stat-progress').textContent = tasks.filter(t => t.status === 'in_progress').length;
    document.getElementById('stat-done').textContent     = tasks.filter(t => t.status === 'completed').length;

    const el     = document.getElementById('dashboard-recent');
    const recent = [...tasks].slice(0, 5);

    if (!recent.length) {
        el.innerHTML = '<div class="empty"><div class="empty-icon">☑</div><p>Nenhuma tarefa ainda.</p></div>';
        return;
    }
    el.innerHTML = recent.map(taskCard).join('');
}

// ─── UTILS ────────────────────────────────────────────────────────────────────
function closeModal(id) {
    document.getElementById(id).classList.add('hidden');
}

function esc(s) {
    return String(s || '')
        .replace(/&/g, '&amp;')
        .replace(/</g, '&lt;')
        .replace(/>/g, '&gt;');
}

function statusLabel(s) {
    return { pending: 'Pendente', in_progress: 'Em andamento', completed: 'Concluída', canceled: 'Cancelada' }[s] || s;
}

function priorityLabel(p) {
    return { low: 'Baixa', medium: 'Média', high: 'Alta' }[p] || p;
}
