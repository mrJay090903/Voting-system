<div class="w-64 bg-blue-800 min-h-screen px-4 py-6">
  <div class="text-white text-xl font-semibold mb-8">Admin Panel</div>
  <nav class="space-y-2">
    <a href="dashboard.php"
      class="flex items-center text-white py-2.5 px-4 <?php echo basename($_SERVER['PHP_SELF']) === 'dashboard.php' ? 'bg-blue-700' : 'hover:bg-blue-700'; ?> rounded">
      <i class="fas fa-tachometer-alt mr-3"></i> Dashboard
    </a>
    <a href="students.php"
      class="flex items-center text-white py-2.5 px-4 <?php echo basename($_SERVER['PHP_SELF']) === 'students.php' ? 'bg-blue-700' : 'hover:bg-blue-700'; ?> rounded">
      <i class="fas fa-users mr-3"></i> Students
    </a>
    <a href="elections.php"
      class="flex items-center text-white py-2.5 px-4 <?php echo basename($_SERVER['PHP_SELF']) === 'elections.php' ? 'bg-blue-700' : 'hover:bg-blue-700'; ?> rounded">
      <i class="fas fa-vote-yea mr-3"></i> Elections
    </a>
    <a href="candidates.php"
      class="flex items-center text-white py-2.5 px-4 <?php echo basename($_SERVER['PHP_SELF']) === 'candidates.php' ? 'bg-blue-700' : 'hover:bg-blue-700'; ?> rounded">
      <i class="fas fa-user-tie mr-3"></i> Candidates
    </a>
    <a href="results.php"
      class="flex items-center text-white py-2.5 px-4 <?php echo basename($_SERVER['PHP_SELF']) === 'results.php' ? 'bg-blue-700' : 'hover:bg-blue-700'; ?> rounded">
      <i class="fas fa-chart-bar mr-3"></i> Results
    </a>
  </nav>
</div>