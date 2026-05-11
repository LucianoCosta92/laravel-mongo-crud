<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Criar conta — TaskManager</title>
    <style>
        *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }
        body {
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', sans-serif;
            background: #f5f4f0; color: #1a1a18; font-size: 14px;
            min-height: 100vh; display: flex; align-items: center; justify-content: center;
        }
        .card {
            background: #fff; border-radius: 14px;
            border: 0.5px solid rgba(0,0,0,0.18); padding: 2.5rem 2rem;
            width: 100%; max-width: 380px;
        }
        .logo { font-size: 20px; font-weight: 600; color: #1D9E75; margin-bottom: .25rem; }
        .sub  { font-size: 13px; color: #5f5e5a; margin-bottom: 1.75rem; }
        .field { display: flex; flex-direction: column; gap: 5px; margin-bottom: .85rem; }
        .field label { font-size: 12px; color: #5f5e5a; font-weight: 500; }
        .field input {
            padding: 8px 10px; border-radius: 10px;
            border: 0.5px solid rgba(0,0,0,0.18); font-size: 14px; outline: none; width: 100%;
        }
        .field input:focus { border-color: #1D9E75; }
        .field .error { font-size: 11px; color: #E24B4A; margin-top: 2px; }
        .btn {
            display: block; width: 100%; padding: 9px;
            border-radius: 10px; border: 0.5px solid #0F6E56;
            background: #1D9E75; color: #fff; font-size: 13px;
            font-weight: 500; cursor: pointer; margin-top: .5rem;
        }
        .btn:hover { background: #0F6E56; }
        .divider { margin-top: 1.25rem; padding-top: 1rem; border-top: 0.5px solid rgba(0,0,0,0.10); }
        .divider p { font-size: 12px; color: #5f5e5a; margin-bottom: .5rem; }
        .btn-outline {
            display: block; width: 100%; padding: 8px; border-radius: 10px;
            border: 0.5px solid rgba(0,0,0,0.18); background: #fff;
            color: #1a1a18; font-size: 13px; font-weight: 500;
            cursor: pointer; text-align: center; text-decoration: none;
        }
        .btn-outline:hover { background: #f1efe8; }
    </style>
</head>
<body>
<div class="card">
    <div class="logo">TaskManager</div>
    <div class="sub">Crie sua conta gratuitamente</div>

    <form method="POST" action="{{ route('register') }}">
        @csrf
        <div class="field">
            <label>Nome</label>
            <input type="text" name="name" value="{{ old('name') }}" placeholder="Seu nome" required />
            @error('name') <span class="error">{{ $message }}</span> @enderror
        </div>
        <div class="field">
            <label>E-mail</label>
            <input type="email" name="email" value="{{ old('email') }}" placeholder="seu@email.com" required />
            @error('email') <span class="error">{{ $message }}</span> @enderror
        </div>
        <div class="field">
            <label>Senha</label>
            <input type="password" name="password" placeholder="mínimo 6 caracteres" required />
            @error('password') <span class="error">{{ $message }}</span> @enderror
        </div>
        <div class="field">
            <label>Confirmar senha</label>
            <input type="password" name="password_confirmation" placeholder="repita a senha" required />
        </div>
        <button type="submit" class="btn">Criar conta</button>
    </form>

    <div class="divider">
        <p>Já tem conta?</p>
        <a href="{{ route('login') }}" class="btn-outline">Entrar</a>
    </div>
</div>
</body>
</html>
