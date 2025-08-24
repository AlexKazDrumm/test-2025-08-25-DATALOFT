<!doctype html>
<html lang="ru">
<head>
  <meta charset="utf-8">
  <title>Вход — test29</title>
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>
  <style>
    *, *::before, *::after { box-sizing: border-box; }

    body {
      font-family:system-ui,Segoe UI,Roboto,Arial,sans-serif;
      margin:0;
      padding:2rem;
      background:#0b1220;
      color:#fff;
    }

    .card {
      max-width:380px;
      width:100%;
      margin:0 auto;
      background:#111827;
      border:1px solid #374151;
      border-radius:12px;
      padding:1.25rem;
      overflow:hidden;
    }

    form { display:flex; 
      flex-direction:column; 
      gap:.6rem; 
    }

    input, button {
      display:block;
      width:100%;
      box-sizing:border-box;
      border-radius:8px;
      border:1px solid #374151;
    }

    input {
      padding:.6rem .8rem;
      background:#0b1020;
      color:#fff;
    }

    button {
      padding:.7rem;
      border:0;
      background:#3b82f6;
      color:#fff;
      font-weight:600;
      cursor:pointer;
    }

    button[disabled] { 
      opacity:.7; 
      cursor:not-allowed; 
    }

    .err {
      margin:.5rem 0;
      padding:.6rem .8rem;
      border-radius:8px;
      background:#7f1d1d;
      color:#fecaca;
      border:1px solid #ef4444;
    }

    a { 
      color:#93c5fd 
    }
  </style>
</head>
<body>
  <div class="card" x-data="login()">
    <h2 style="margin:.2rem 0 1rem">Вход</h2>

    <template x-if="error"><div class="err" x-text="error"></div></template>

    <form @submit.prevent="submit">
      <input type="email"     placeholder="E-mail"  x-model="form.email"    autocomplete="username"         required>
      <input type="password"  placeholder="Пароль" x-model="form.password" autocomplete="current-password" required>
      <button x-bind:disabled="loading" x-text="loading?'Входим...':'Войти'"></button>
    </form>

    <p style="font-size:.9rem;opacity:.8;margin-top:.75rem">
      Тестовый пользователь: <code>test@example.com</code> / <code>password</code>
    </p>
  </div>

  <script>
    function login(){
      return {
        form:   { email:'test@example.com', password:'password' },
        loading:false,
        error:  '',
        async submit(){
          this.error=''; this.loading=true;
          try{
            const r = await fetch('/api/login', {
              method:'POST',
              headers:{'Content-Type':'application/json','Accept':'application/json'},
              body: JSON.stringify(this.form)
            });
            let data = null;
            try { data = await r.json(); } catch(_) {
              this.error = 'Некорректный ответ сервера'; this.loading=false; return;
            }
            if(!r.ok){ this.error = data?.message || 'Ошибка авторизации'; this.loading=false; return; }
            localStorage.setItem('token', data.token);
            location.href = '/cars';
          } catch(e){
            this.error = 'Сеть/сервер недоступен';
          } finally { this.loading=false; }
        }
      }
    }
  </script>
</body>
</html>
