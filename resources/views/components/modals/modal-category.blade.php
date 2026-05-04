<div id="modal-cat" class="modal-overlay hidden">
    <div class="modal">
        <h3 id="modal-cat-title">Nova categoria</h3>

        <div class="field">
            <label>Nome</label>
            <input id="cat-name" placeholder="Nome da categoria" />
        </div>
        <div class="field">
            <label>Cor</label>
            <div style="display:flex;gap:8px;align-items:center">
                <input
                    id="cat-color"
                    type="color"
                    value="#1D9E75"
                    style="width:44px;height:36px;padding:2px;border-radius:8px;border:0.5px solid var(--border-md);cursor:pointer"
                />
                <span id="cat-color-hex" style="font-size:13px;color:var(--text2)">#1D9E75</span>
            </div>
        </div>

        <div class="modal-footer">
            <button class="btn" onclick="closeModal('modal-cat')">Cancelar</button>
            <button class="btn primary" onclick="saveCat()">Salvar</button>
        </div>
    </div>
</div>
