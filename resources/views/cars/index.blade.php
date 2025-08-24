<!doctype html>
<html lang="ru">
<head>
  <meta charset="utf-8">
  <title>Мои автомобили — test29</title>
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>
  <style>
    body {
      font-family:system-ui,Segoe UI,Roboto,Arial,sans-serif;
      margin:0;
      padding:2rem;
      background:#0b1220;
      color:#fff
    }

    .wrap {
      max-width:900px;
      margin:0 auto
    }

    .card {
      background:#111827;
      border:1px solid #374151;
      border-radius:12px;
      padding:1rem;
      margin-bottom:1rem
    }

    input,select {
      padding:.5rem .6rem;
      border-radius:8px;
      border:1px solid #374151;
      background:#0b1020;color:#fff
    }

    button {
      padding:.5rem .8rem;
      border-radius:8px;
      border:0;
      background:#3b82f6;
      color:#fff;
      font-weight:600;
      cursor:pointer
    }

    .err {
      margin:.5rem 0;
      padding:.6rem .8rem;
      border-radius:8px;
      background:#7f1d1d;
      color:#fecaca;
      border:1px solid #ef4444
    }

    .row {
      display:flex;
      gap:.5rem;
      flex-wrap:wrap
    }

    table {
      width:100%;
      border-collapse:collapse
    } 
    
    th,td {
      padding:.5rem;
      border-bottom:1px solid #374151;
      text-align:left
    }
  </style>
</head>
<body x-data="cars()" x-init="init()">
  <div class="wrap">
    <div class="row" style="justify-content:space-between;align-items:center;">
      <h2>Мои автомобили</h2>
      <button @click="logout()">Выйти</button>
    </div>

    <template x-if="error"><div class="err" x-text="error"></div></template>

    <div class="card">
      <div class="row">
        <select x-model="form.brand_id" @change="loadModels()">
          <option value="">Марка</option>
          <template x-for="b in brands"><option :value="b.id" x-text="b.name"></option></template>
        </select>

        <select x-model="form.car_model_id">
          <option value="">Модель</option>
          <template x-for="m in models"><option :value="m.id" x-text="m.name"></option></template>
        </select>

        <input type="number" x-model="form.year"    placeholder="Год">
        <input type="number" x-model="form.mileage" placeholder="Пробег">
        <input type="text"   x-model="form.color"   placeholder="Цвет">

        <button @click="create()">Добавить</button>
      </div>
    </div>

    <div class="card">
      <table>
        <thead><tr><th>Марка</th><th>Модель</th><th>Год</th><th>Пробег</th><th>Цвет</th><th></th></tr></thead>
        <tbody>
          <template x-for="c in cars" :key="c.id">
            <tr>
              <td x-text="c.brand.name"></td>
              <td x-text="c.model.name"></td>
              <td x-text="c.year ?? ''"></td>
              <td x-text="c.mileage ?? ''"></td>
              <td x-text="c.color ?? ''"></td>
              <td><button @click="del(c.id)">Удалить</button></td>
            </tr>
          </template>
        </tbody>
      </table>
    </div>
  </div>

<script>
function cars(){
  return {
    token: null,
    error: '',
    brands: [], models: [], cars: [],
    form: {brand_id:'',car_model_id:'',year:'',mileage:'',color:''},

    async init(){
      this.token = localStorage.getItem('token');
      if(!this.token){ location.href='/login'; return; }
      await this.loadBrands();
      await this.loadCars();
    },

    async loadBrands(){
      this.error='';
      try{
        const r = await fetch('/api/brands');
        this.brands = await r.json();
      }catch(_){ this.error='Не удалось загрузить марки'; }
    },

    async loadModels(){
      this.error='';
      this.models=[];
      if(!this.form.brand_id) return;
      try{
        const r = await fetch('/api/models?brand_id='+this.form.brand_id);
        this.models = await r.json();
      }catch(_){ this.error='Не удалось загрузить модели'; }
    },

    async loadCars(){
      this.error='';
      try{
        const r = await fetch('/api/cars',{headers:{Authorization:'Bearer '+this.token,Accept:'application/json'}});
        let data=null; try{ data = await r.json(); }catch(_){ this.error='Некорректный ответ сервера'; return; }
        if(!r.ok){ this.error=(data && (data.message||data.error))||'Ошибка загрузки'; return; }
        this.cars = data;
      }catch(_){ this.error='Сеть/сервер недоступен'; }
    },

    async create(){
      this.error='';
      try{
        const r = await fetch('/api/cars',{
          method:'POST',
          headers:{'Content-Type':'application/json',Accept:'application/json',Authorization:'Bearer '+this.token},
          body: JSON.stringify(this.form)
        });
        let data=null; try{ data = await r.json(); }catch(_){}
        if(!r.ok){ this.error=(data && (data.message||JSON.stringify(data)))||'Ошибка создания'; return; }
        this.form = {brand_id:'',car_model_id:'',year:'',mileage:'',color:''};
        this.models=[];
        await this.loadCars();
      }catch(_){ this.error='Сеть/сервер недоступен'; }
    },

    async del(id){
      this.error='';
      try{
        const r = await fetch('/api/cars/'+id,{method:'DELETE',headers:{Authorization:'Bearer '+this.token,Accept:'application/json'}});
        if(!r.ok){ this.error='Ошибка удаления'; return; }
        this.cars = this.cars.filter(x=>x.id!==id);
      }catch(_){ this.error='Сеть/сервер недоступен'; }
    },

    async logout(){
      try{ await fetch('/api/logout',{method:'POST',headers:{Authorization:'Bearer '+this.token}}); }catch(_){}
      localStorage.removeItem('token'); location.href='/login';
    }
  }
}
</script>
</body>
</html>
