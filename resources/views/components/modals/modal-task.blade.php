<div id="modal-task" class="modal-overlay hidden">
    <div class="modal">
        <h3 id="modal-task-title">Nova tarefa</h3>

        <div class="field">
            <label>Título</label>
            <input id="task-title" placeholder="Título da tarefa" />
        </div>
        <div class="field">
            <label>Descrição</label>
            <textarea id="task-desc" placeholder="Descrição (opcional)"></textarea>
        </div>

        <div class="two-col">
            <div class="field">
                <label>Status</label>
                <select id="task-status">
                    <option value="pending">Pendente</option>
                    <option value="in_progress">Em andamento</option>
                    <option value="completed">Concluída</option>
                    <option value="canceled">Cancelada</option>
                </select>
            </div>
            <div class="field">
                <label>Prioridade</label>
                <select id="task-priority">
                    <option value="low">Baixa</option>
                    <option value="medium">Média</option>
                    <option value="high">Alta</option>
                </select>
            </div>
        </div>

        <div class="two-col">
            <div class="field">
                <label>Categoria</label>
                <select id="task-category">
                    <option value="">Sem categoria</option>
                </select>
            </div>
            <div class="field">
                <label>Vencimento</label>
                <input id="task-due" type="date" />
            </div>
        </div>

        <div class="modal-footer">
            <button class="btn" onclick="closeModal('modal-task')">Cancelar</button>
            <button class="btn primary" onclick="saveTask()">Salvar</button>
        </div>
    </div>
</div>
