document.addEventListener('DOMContentLoaded',()=>{
 const dm=document.getElementById('darkToggle');
 if(localStorage.getItem('dark')==='1')document.body.classList.add('dark');
 if(dm){const sync=()=>dm.textContent=document.body.classList.contains('dark')?'☀️ الوضع النهاري':'🌙 الوضع الليلي';sync();
  dm.addEventListener('click',()=>{document.body.classList.toggle('dark');localStorage.setItem('dark',document.body.classList.contains('dark')?'1':'0');sync();});}
 const mt=document.querySelector('.menu-toggle'),nav=document.querySelector('nav');
 if(mt)mt.addEventListener('click',()=>nav.classList.toggle('open'));
 const grid=document.getElementById('regionsGrid');
 if(grid){
  const fb=document.querySelectorAll('.filters button'),q=document.getElementById('search');let cat='all';
  const apply=()=>{const t=q.value.trim();let n=0;
   grid.querySelectorAll('.card').forEach(c=>{const ok=(cat==='all'||c.dataset.type===cat)&&c.textContent.includes(t);c.style.display=ok?'':'none';if(ok)n++;});
   document.getElementById('noResults').hidden=n>0;};
  fb.forEach(b=>b.addEventListener('click',()=>{fb.forEach(x=>x.classList.remove('active'));b.classList.add('active');cat=b.dataset.filter;apply();}));
  q.addEventListener('input',apply);
 }
 document.querySelectorAll('[data-count]').forEach(el=>{const end=+el.dataset.count;let i=0;const s=Math.max(1,Math.ceil(end/40));const fmt=n=>n.toLocaleString('ar-SA');
  const t=setInterval(()=>{i=Math.min(end,i+s);el.textContent=fmt(i);if(i>=end)clearInterval(t);},30);});
 document.querySelectorAll('form[data-validate]').forEach(f=>{
  const setErr=(el,m)=>{let s=el.parentElement.querySelector('.error[data-for="'+el.id+'"]');if(!s){s=document.createElement('span');s.className='error';s.dataset.for=el.id;el.after(s);}s.textContent=m;el.classList.toggle('invalid',!!m);return !m;};
  const check=el=>{const v=el.value.trim(),l=el.dataset.label||'هذا الحقل';
   if(el.required&&!v)return setErr(el,'الرجاء إدخال '+l);
   if(v&&el.type==='email'&&!/^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(v))return setErr(el,'صيغة البريد الإلكتروني غير صحيحة');
   if(v&&el.dataset.min&&v.length<+el.dataset.min)return setErr(el,l+' يجب ألا يقل عن '+el.dataset.min+' أحرف');
   if(v&&el.dataset.pattern&&!new RegExp(el.dataset.pattern).test(v))return setErr(el,el.dataset.msg||'قيمة غير صحيحة');
   if(v&&el.dataset.minval&&(+v<+el.dataset.minval||+v>+el.dataset.maxval))return setErr(el,el.dataset.msg||'قيمة غير صحيحة');
   if(v&&el.type==='url'&&!/^https?:\/\//.test(v))return setErr(el,'الرابط يجب أن يبدأ بـ http:// أو https://');
   return setErr(el,'');};
  f.setAttribute('novalidate','');
  f.querySelectorAll('input,textarea,select').forEach(el=>el.addEventListener('blur',()=>check(el)));
  f.addEventListener('submit',e=>{let ok=true;f.querySelectorAll('input,textarea,select').forEach(el=>{if(!check(el))ok=false;});
   const b=f.querySelector('.alert');
   if(!ok){e.preventDefault();if(b){b.className='alert err';b.textContent='الرجاء تصحيح الأخطاء أدناه';}}
   else if(f.dataset.demo){e.preventDefault();if(b){b.className='alert ok';b.textContent=f.dataset.demo;}}});
 });
 document.querySelectorAll('[data-confirm]').forEach(a=>a.addEventListener('click',e=>{if(!confirm(a.dataset.confirm))e.preventDefault();}));
});
