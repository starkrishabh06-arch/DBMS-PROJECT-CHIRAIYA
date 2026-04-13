<?php include "head.php" ?>
<body>

<!-- ░░░░░░░░░░  HEADER  ░░░░░░░░░░ -->
<header class="eh-header">
  <div class="eh-container">
    <nav class="eh-nav">
      <div class="eh-logo">
        <h2>Expense<span>Heist</span></h2>
      </div>

      <button class="eh-toggle_btn" id="eh_toggle_btn">
        <i class="ri-menu-3-line"></i>
      </button>

      <div class="eh-nav_menu" id="eh_nav_menu">
        <button class="eh-close_btn" id="eh_close_btn">
          <i class="ri-close-line"></i>
        </button>
        <ul class="nav_menu_list">
          <li class="nav_menu_item"><a href="the-plan.php" class="nav_menu_link">The Plan</a></li>
          <li class="nav_menu_item"><a href="mission.php" class="nav_menu_link">Mission</a></li>
          <li class="nav_menu_item"><a href="the-crew.php" class="nav_menu_link">The Crew</a></li>
        </ul>
      </div>
    </nav>
  </div>
</header>

<!-- Remix Icons (used by index.php) -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/remixicon/4.2.0/remixicon.min.css"/>
<!-- Google Fonts used by index.php theme -->
<link href="https://fonts.googleapis.com/css2?family=Bebas+Neue&family=Oswald:wght@300;400;500;600;700&family=Barlow:wght@300;400;500&display=swap" rel="stylesheet">

<style>
/* ═══════════════════════════════════════════
   EXPENSEHEIST — HEADER  (Money Heist theme)
═══════════════════════════════════════════ */
:root {
  --eh-red:         #c81e1e;
  --eh-red-dark:    #8f0f0f;
  --eh-red-glow:    rgba(200,30,30,0.28);
  --eh-red-subtle:  rgba(200,30,30,0.08);
  --eh-bg-void:     #060608;
  --eh-bg-surface:  #0e0e14;
  --eh-border:      rgba(255,255,255,0.06);
  --eh-border-red:  rgba(200,30,30,0.35);
  --eh-text-bright: #f5f0e8;
  --eh-text-mid:    #9994a0;
  --eh-text-dim:    #4e4a58;
  --eh-header-h:    4.25rem;
  --eh-font-display:'Bebas Neue', sans-serif;
  --eh-font-heading:'Oswald', sans-serif;
  --eh-font-body:   'Barlow', sans-serif;
}

ul li { list-style: none; }
a    { text-decoration: none; }
button { background: transparent; border: none; outline: none; cursor: pointer; }

/* ── sticky header ── */
.eh-header {
  position: sticky; top: 0; z-index: 100;
  height: var(--eh-header-h);
  padding: 0 1.7rem;
  background: rgba(6,6,8,0.88);
  backdrop-filter: blur(14px);
  border-bottom: 1px solid var(--eh-border-red);
}

/* shimmer line */
.eh-header::after {
  content: '';
  position: absolute; bottom: 0; left: 0;
  width: 100%; height: 1px;
  background: linear-gradient(90deg, transparent, var(--eh-red), transparent);
  animation: eh-shimmer 4s linear infinite;
}
@keyframes eh-shimmer {
  0%   { transform: translateX(-100%); }
  100% { transform: translateX(100%);  }
}

/* container */
.eh-container {
  width: 100%; height: 100%;
  position: relative; z-index: 2;
}
@media (min-width: 1040px) {
  .eh-container { width: 1040px; margin: 0 auto; }
}

/* nav */
.eh-nav {
  width: 100%; height: 100%;
  display: flex; align-items: center; justify-content: space-between;
}

/* logo */
.eh-logo h2 {
  font-family: var(--eh-font-display);
  font-size: 28px; letter-spacing: 2px;
  color: var(--eh-text-bright);
}
.eh-logo h2 span { color: var(--eh-red); }

/* nav menu */
.eh-nav_menu_list {
  display: flex; align-items: center;
}
.eh-nav_menu_list .eh-nav_menu_item { margin: 0 1.8rem; }
.eh-nav_menu_item .eh-nav_menu_link {
  font-family: var(--eh-font-heading);
  font-size: 13px; letter-spacing: 2px; text-transform: uppercase;
  color: var(--eh-text-mid);
  transition: color 0.2s;
  position: relative; padding-bottom: 2px;
}
.eh-nav_menu_link::after {
  content: ''; position: absolute; bottom: 0; left: 0;
  width: 0; height: 1px; background: var(--eh-red);
  transition: width 0.25s;
}
.eh-nav_menu_link:hover { color: var(--eh-text-bright); }
.eh-nav_menu_link:hover::after { width: 100%; }

/* toggle / close buttons */
.eh-toggle_btn { font-size: 22px; color: var(--eh-text-bright); z-index: 4; }
.eh-nav_menu, .eh-close_btn { display: none; }
.eh-show { right: 3% !important; }

/* ── RESPONSIVE ── */
@media (min-width: 768px) {
  .eh-toggle_btn { display: none; }
  .eh-nav_menu   { display: block; }
}
@media (max-width: 768px) {
  .eh-logo h2 { font-size: 22px; }
  .eh-nav_menu {
    position: fixed; width: 93%; height: 100%;
    display: block; top: 2.5%; right: -100%;
    background: var(--eh-bg-surface);
    border: 1px solid var(--eh-border-red);
    padding: 3rem; border-radius: 12px;
    box-shadow: 0 0 60px rgba(200,30,30,0.15);
    z-index: 50; transition: 0.35s;
  }
  .eh-nav_menu_list { flex-direction: column; align-items: flex-start; margin-top: 4rem; }
  .eh-nav_menu_list .eh-nav_menu_item { margin: 1rem 0; }
  .eh-nav_menu_item .eh-nav_menu_link { font-size: 18px; }
  .eh-close_btn {
    display: block; position: absolute;
    right: 10%; font-size: 25px; color: var(--eh-text-mid);
  }
}
</style>

<script>
(function() {
  var toggleBtn = document.getElementById('eh_toggle_btn');
  var navMenu   = document.getElementById('eh_nav_menu');
  var closeBtn  = document.getElementById('eh_close_btn');
  if (toggleBtn) toggleBtn.addEventListener('click', function() { navMenu.classList.add('eh-show'); });
  if (closeBtn)  closeBtn.addEventListener('click',  function() { navMenu.classList.remove('eh-show'); });
})();
</script>
