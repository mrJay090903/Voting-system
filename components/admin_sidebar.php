<div class="relative">
  <!-- Menu Button -->
  <button id="menu-toggle"
    class="absolute top-4 left-4 text-white bg-blue-700 p-2 rounded focus:outline-none md:hidden">
    <svg class="w-6 h-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16m-4 6h4" />
    </svg>
  </button>

  <!-- Sidebar -->
  <div id="sidebar"
    class="w-48 bg-blue-800 min-h-screen px-4 py-6 transition-transform transform -translate-x-full md:translate-x-0 fixed md:relative">
    <div class="text-white text-xl font-semibold mb-8 bg-blue-900 p-3 rounded-lg text-center">
      SSLG SYSTEM
    </div>

    <nav class="space-y-2">
      <a href="dashboard.php"
        class="flex items-center text-white py-2.5 px-4 rounded transition duration-200 <?php echo basename($_SERVER['PHP_SELF']) === 'dashboard.php' ? 'bg-blue-700' : 'hover:bg-blue-700'; ?>">
        <i class="fas fa-tachometer-alt mr-3"></i> Dashboard
      </a>
      <a href="students.php"
        class="flex items-center text-white py-2.5 px-4 rounded transition duration-200 <?php echo basename($_SERVER['PHP_SELF']) === 'students.php' ? 'bg-blue-700' : 'hover:bg-blue-700'; ?>">
        <i class="fas fa-users mr-3"></i> Students
      </a>
      <a href="elections.php"
        class="flex items-center text-white py-2.5 px-4 rounded transition duration-200 <?php echo basename($_SERVER['PHP_SELF']) === 'elections.php' ? 'bg-blue-700' : 'hover:bg-blue-700'; ?>">
        <i class="fas fa-vote-yea mr-3"></i> Elections
      </a>
      <a href="candidates.php"
        class="flex items-center text-white py-2.5 px-4 rounded transition duration-200 <?php echo basename($_SERVER['PHP_SELF']) === 'candidates.php' ? 'bg-blue-700' : 'hover:bg-blue-700'; ?>">
        <i class="fas fa-user-tie mr-3"></i> Candidates
      </a>
      <a href="#" onclick="showResultsDialog(); return false;"
        class="flex items-center text-white py-2.5 px-4 rounded transition duration-200 hover:bg-blue-700">
        <i class="fas fa-chart-bar mr-3"></i> Results
      </a>
    </nav>
  </div>
</div>

<!-- Add SweetAlert2 -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
document.getElementById('menu-toggle').addEventListener('click', function() {
  const sidebar = document.getElementById('sidebar');
  sidebar.classList.toggle('-translate-x-full');
});

// Function to show results dialog
function showResultsDialog() {
  Swal.fire({
    title: 'Election Results',
    text: 'Do you want to download the PDF?',
    icon: 'info',
    showCancelButton: true,
    confirmButtonText: 'Download PDF',
    cancelButtonText: 'Cancel'
  }).then((result) => {
    if (result.isConfirmed) {
      window.location.href = 'results.php?generate_pdf=1'; // Redirect to PDF generation
    }
  });
}
</script>