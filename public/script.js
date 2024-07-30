document.addEventListener('DOMContentLoaded', function () {
  const mobileMenuButton = document.querySelector('.main-menu-mobile');
  const mainMenu = document.querySelector('.main-menu');
  let isMenuVisible = false;

  function toggleMenu() {
      if (isMenuVisible) {
          mobileMenuButton.innerHTML = `
              <a class="menu-icon" href="#">
                  <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path>
                  </svg>
              </a>
          `;
          isMenuVisible = false;
      } else {
          const mainMenuUl = mainMenu.querySelector('ul');
          const clonedMenu = mainMenuUl.cloneNode(true);
          clonedMenu.classList.remove('justify-content-center', 'flex', 'space-x-275');
          mobileMenuButton.innerHTML = `
              <a class="menu-icon" href="#">
                  <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path>
                  </svg>
              </a>
          `;
          mobileMenuButton.appendChild(clonedMenu);

          // Tambahkan event listener ke tautan dalam menu mobile
          const mobileLinks = clonedMenu.querySelectorAll('a');
          mobileLinks.forEach(link => {
              link.addEventListener('click', function (event) {
                  window.location.href = link.href;
              });
          });

          isMenuVisible = true;
      }
  }

  mobileMenuButton.addEventListener('click', function (event) {
      event.preventDefault();
      toggleMenu();
  });

  function handleResize() {
      if (window.innerWidth >= 768) {
          if (isMenuVisible) {
              mobileMenuButton.innerHTML = `
                  <a class="menu-icon" href="#">
                      <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path>
                      </svg>
                  </a>
              `;
              isMenuVisible = false;
          }
      }
  }

  window.addEventListener('resize', handleResize);
  handleResize();
});
