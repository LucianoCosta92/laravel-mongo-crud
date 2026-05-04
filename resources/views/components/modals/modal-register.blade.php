<div id="modal-register" class="modal-overlay hidden">
    <div class="modal">
        <h3>Criar conta</h3>

        <div class="field">
            <label>Nome</label>
            <input id="reg-name" placeholder="Seu nome" />
        </div>
        <div class="field">
            <label>E-mail</label>
            <input id="reg-email" type="email" placeholder="seu@email.com" />
        </div>
        <div class="field">
            <label>Senha</label>
            <input id="reg-password" type="password" placeholder="mínimo 8 caracteres" />
        </div>
        <div class="field">
            <label>Confirmar senha</label>
            <input id="reg-confirm" type="password" placeholder="repita a senha" />
        </div>

        <div class="modal-footer">
            <button class="btn" onclick="closeModal('modal-register')">Cancelar</button>
            <button class="btn primary" onclick="doRegister()">Criar conta</button>
        </div>
    </div>
</div>
