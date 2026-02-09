const toggleSidebar = document.getElementById("toggleSidebar");
const closeSidebar = document.getElementById("closeSidebar");
const mobileSidebar = document.getElementById("mobileSidebar");
const sidebarMobile = document.getElementById("sidebarMobile");
const sidebarOverlay = document.getElementById("sidebarOverlay");

function openMobileSidebar() {
  mobileSidebar.classList.remove("hidden");
  setTimeout(() => {
    sidebarMobile.classList.remove("-translate-x-full");
  }, 10);
}

function closeMobileSidebar() {
  sidebarMobile.classList.add("-translate-x-full");
  setTimeout(() => {
    mobileSidebar.classList.add("hidden");
  }, 300);
}

if (toggleSidebar) {
  toggleSidebar.addEventListener("click", openMobileSidebar);
}

if (closeSidebar) {
  closeSidebar.addEventListener("click", closeMobileSidebar);
}

if (sidebarOverlay) {
  sidebarOverlay.addEventListener("click", closeMobileSidebar);
}

const dropdownButton = document.getElementById("userDropdownButton");
const dropdownContent = document.getElementById("dropdownContent");

if (dropdownButton && dropdownContent) {
  dropdownButton.addEventListener("click", function (e) {
    e.stopPropagation();
    dropdownContent.classList.toggle("hidden");
  });

  window.addEventListener("click", function () {
    dropdownContent.classList.add("hidden");
  });
}

window.addEventListener("resize", function () {
  if (window.innerWidth >= 1024) {
    closeMobileSidebar();
  }
});

function updateDateTime() {
  const now = new Date();

  const day = String(now.getDate()).padStart(2, "0");
  const month = String(now.getMonth() + 1).padStart(2, "0");
  const year = now.getFullYear();
  const hours = String(now.getHours()).padStart(2, "0");
  const minutes = String(now.getMinutes()).padStart(2, "0");
  const seconds = String(now.getSeconds()).padStart(2, "0");

  document.getElementById("currentDateTime").textContent =
    `${day}/${month}/${year} ${hours}:${minutes}:${seconds}`;
}

updateDateTime();
setInterval(updateDateTime, 1000);
