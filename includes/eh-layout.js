/* ExpenseHeist — shared layout JS */
(function () {
  /* sidebar toggle */
  var sidebar   = document.getElementById('eh-sidebar');
  var mainSec   = document.getElementById('eh-main');
  var sideIcon  = document.getElementById('eh-sidebarIcon');
  var toggleBtn = document.getElementById('eh-sidebarToggle');
  if (toggleBtn) {
    toggleBtn.addEventListener('click', function () {
      sidebar.classList.toggle('collapsed');
      mainSec.classList.toggle('expanded');
      if (sidebar.classList.contains('collapsed')) {
        sideIcon.classList.replace('bx-menu', 'bx-menu-alt-right');
      } else {
        sideIcon.classList.replace('bx-menu-alt-right', 'bx-menu');
      }
    });
  }

  /* profile dropdown */
  var profileToggle   = document.getElementById('eh-profileToggle');
  var profileDropdown = document.getElementById('eh-profileDropdown');
  if (profileToggle) {
    profileToggle.addEventListener('click', function () {
      profileDropdown.classList.toggle('show');
    });
    document.addEventListener('click', function (e) {
      if (!profileToggle.contains(e.target) && !profileDropdown.contains(e.target)) {
        profileDropdown.classList.remove('show');
      }
    });
  }
})();
