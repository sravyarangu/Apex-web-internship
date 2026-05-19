document.addEventListener('DOMContentLoaded', function(){
  // entrance animations
  const card = document.querySelector('.card');
  if(card){
    card.classList.add('anim-fade-up');
    // small delay so CSS animation is noticeable
    setTimeout(()=> card.classList.add('anim-in'), 80);
  }
  // Login show/hide
  const toggleLogin = document.getElementById('toggleLoginPwd');
  const loginPwd = document.getElementById('loginPassword');
  toggleLogin.addEventListener('click', ()=>{
    if(loginPwd.type === 'password'){ loginPwd.type = 'text'; toggleLogin.textContent='Hide' }
    else { loginPwd.type='password'; toggleLogin.textContent='Show' }
  });

  // Register show/hide
  const toggleReg = document.getElementById('toggleRegPwd');
  const regPwd = document.getElementById('regPassword');
  const regPwd2 = document.getElementById('regPassword2');
  toggleReg.addEventListener('change', ()=>{
    const t = toggleReg.checked ? 'text' : 'password';
    regPwd.type = regPwd2.type = t;
  });

  // Password match check
  const regForm = document.getElementById('registerForm');
  regForm.addEventListener('submit', (e)=>{
    e.preventDefault();
    let ok = true;
    if(regPwd.value.trim() === '' || regPwd2.value.trim() === '') ok=false;
    if(regPwd.value !== regPwd2.value){
      ok=false;
      document.getElementById('pwMatchFeedback').style.display='block';
    } else document.getElementById('pwMatchFeedback').style.display='none';

    if(ok){
      alert('Registration form looks good (demo).')
      regForm.reset();
      document.getElementById('usernameFeedback').textContent='';
    }
  });

  // Login basic validation
  const loginForm = document.getElementById('loginForm');
  loginForm.addEventListener('submit', (e)=>{
    e.preventDefault();
    if(document.getElementById('loginEmail').value.trim()==='' || loginPwd.value.trim()===''){
      alert('Please enter email and password.');
      return;
    }
    alert('Login submitted (demo).')
    loginForm.reset();
  });

  // AJAX username availability check (tries PHP endpoint, falls back to client-side dummy)
  const regUsername = document.getElementById('regUsername');
  const usernameFeedback = document.getElementById('usernameFeedback');
  regUsername.addEventListener('blur', async ()=>{
    const v = regUsername.value.trim();
    if(!v) { usernameFeedback.textContent=''; return }
    // attempt PHP endpoint
    try{
      const res = await fetch(`check_username.php?username=${encodeURIComponent(v)}`);
      if(!res.ok) throw new Error('no-php');
      const j = await res.json();
      usernameFeedback.textContent = j.available ? 'Username available' : 'Username already taken';
      usernameFeedback.style.color = j.available ? 'green' : 'crimson';
      return;
    }catch(err){
      // fallback dummy check
      const taken = ['admin','user','test','taken'];
      const ok = !taken.includes(v.toLowerCase());
      usernameFeedback.textContent = ok ? 'Username appears available (local check)' : 'Username appears taken (local check)';
      usernameFeedback.style.color = ok ? 'green' : 'crimson';
    }
  });

  // animate tab panes when shown (Bootstrap event)
  const tabButtons = document.querySelectorAll('button[data-bs-toggle="tab"]');
  tabButtons.forEach(btn => {
    btn.addEventListener('shown.bs.tab', (e)=>{
      const targetSelector = e.target.getAttribute('data-bs-target');
      const pane = document.querySelector(targetSelector);
      if(!pane) return;
      // add stagger effect to immediate children
      pane.classList.remove('stagger-in');
      pane.classList.add('stagger');
      // force reflow to restart transitions
      void pane.offsetWidth;
      pane.classList.add('stagger-in');
    });
  });

  // initial trigger for active tab
  const activePane = document.querySelector('.tab-pane.active');
  if(activePane){ activePane.classList.add('stagger','stagger-in') }

  // enhance buttons with hover animation class
  document.querySelectorAll('button').forEach(b=>b.classList.add('btn-animate'));
});
