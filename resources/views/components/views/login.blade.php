<div id="page-login">
    <div class="login-card">
        <div class="login-logo">TaskManager</div>
        <div class="login-sub">Entre na sua conta para continuar</div>

        <div class="field">
            <label>E-mail</label>
            <input id="login-email" type="email" placeholder="seu@email.com" />
        </div>
        <div class="field">
            <label>Senha</label>
            <input id="login-password" type="password" placeholder="••••••••" />
        </div>

        <button class="btn primary" style="width:100%;margin-top:.5rem" onclick="doLogin()">
            Entrar
        </button>

        <div class="login-divider">
            <p>Não tem conta?</p>
            <button class="btn" style="width:100%" onclick="showRegister()">Criar conta</button>
        </div>
    </div>
</div>
