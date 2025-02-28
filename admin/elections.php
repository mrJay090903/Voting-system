<?php
session_start();
include '../database/db.php';

// Check if user is logged in as admin
if (!isset($_SESSION['user_type']) || $_SESSION['user_type'] !== 'admin') {
    header("Location: ../index.php");
    exit();
}

$admin_username = $_SESSION['admin_username'];

// Auto-update election status
$update_status_sql = "
    UPDATE elections 
    SET status = 
        CASE 
            WHEN NOW() < start_date THEN 'pending'
            WHEN NOW() BETWEEN start_date AND end_date THEN 'active'
            WHEN NOW() > end_date THEN 'completed'
        END
";
$conn->query($update_status_sql);

<<<<<<< HEAD
// Get elections with additional information
=======
// Handle Search
$search_query = '';
if (isset($_POST['search'])) {
    $search_query = mysqli_real_escape_string($conn, $_POST['search_query']);
}

// Get elections with additional information, including optional search
>>>>>>> cope/main
$elections = $conn->query("
    SELECT 
        e.*,
        COUNT(DISTINCT c.id) as candidate_count,
        COUNT(DISTINCT v.id) as vote_count,
        (SELECT COUNT(*) FROM students) as total_students
    FROM elections e
    LEFT JOIN candidates c ON e.id = c.election_id
    LEFT JOIN votes v ON e.id = v.election_id
<<<<<<< HEAD
=======
    WHERE e.title LIKE '%$search_query%'
>>>>>>> cope/main
    GROUP BY e.id
    ORDER BY 
        CASE e.status
            WHEN 'active' THEN 1
            WHEN 'pending' THEN 2
            WHEN 'completed' THEN 3
        END,
        e.start_date DESC
");
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Elections Management - Admin Dashboard</title>
  <script src="https://cdn.tailwindcss.com"></script>
  <link rel="icon" href="../components/image/logo.png" type="image/png">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>

<body class="bg-gray-100">
<<<<<<< HEAD
  <?php include '../components/notification.php';
    if (isset($_GET['success'])) echo showNotification($_GET['success']);
    if (isset($_GET['error'])) echo showNotification($_GET['error'], 'error');
    ?>
=======

>>>>>>> cope/main

  <div class="flex">
    <!-- Include Sidebar -->
    <?php include '../components/admin_sidebar.php'; ?>

    <!-- Main Content -->
    <div class="flex-1">
      <!-- Top Navigation -->
      <div class="bg-white shadow-md px-6 py-4 flex justify-between items-center">
        <h1 class="text-xl font-semibold">Elections Management</h1>
        <div class="flex items-center space-x-4">
          <button onclick="openAddModal()" class="bg-blue-500 text-white px-4 py-2 rounded-lg hover:bg-blue-600">
            <i class="fas fa-plus mr-2"></i>Create Election
          </button>
          <span class="text-gray-600">Welcome, <?php echo htmlspecialchars($admin_username); ?></span>
          <a href="../auth/logout.php" class="bg-red-500 text-white px-4 py-2 rounded-lg hover:bg-red-600">Logout</a>
        </div>
      </div>

      <!-- Elections List -->
      <div class="p-6">
<<<<<<< HEAD
        <div class="bg-white rounded-lg shadow-md overflow-hidden">
=======

        <div class="flex justify-end">

          <form method="POST" class="flex space-x-4">
            <input type="text" name="search_query" value="<?php echo htmlspecialchars($search_query); ?>"
              placeholder="Search by Title" class="border rounded px-4 py-2">
            <button type="submit" name="search"
              class="bg-blue-500 text-white px-4 py-2 rounded-lg hover:bg-blue-600">Search</button>
          </form>
        </div>
        <div class="bg-white rounded-lg shadow-md overflow-hidden">
          <div class="flex justify-between items-center mb-4">


          </div>
>>>>>>> cope/main
          <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-50">
              <tr>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Title</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Status</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Candidates</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Votes</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Participation</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Start Date</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">End Date</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Actions</th>
              </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
              <?php while($election = $elections->fetch_assoc()): ?>
              <tr>
                <td class="px-6 py-4 whitespace-nowrap">
                  <?php echo htmlspecialchars($election['title']); ?>
                </td>
                <td class="px-6 py-4 whitespace-nowrap">
                  <span
                    class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full 
                                        <?php echo $election['status'] === 'active' ? 'bg-green-100 text-green-800' : 
                                            ($election['status'] === 'completed' ? 'bg-gray-100 text-gray-800' : 'bg-yellow-100 text-yellow-800'); ?>">
                    <?php echo ucfirst($election['status']); ?>
                  </span>
                </td>
                <td class="px-6 py-4 whitespace-nowrap">
                  <?php echo $election['candidate_count']; ?>
                </td>
                <td class="px-6 py-4 whitespace-nowrap">
                  <?php echo $election['vote_count']; ?>
                </td>
                <td class="px-6 py-4 whitespace-nowrap">
<<<<<<< HEAD
                  <?php 
                      $participation = $election['total_students'] > 0 
                          ? min(100, round(($election['vote_count'] / $election['total_students']) * 100)) 
                          : 0;
                      echo $participation;
                  ?>%
=======
                  <?php echo $election['total_students'] > 0 ? round(($election['vote_count'] / $election['total_students']) * 100) : 0; ?>%
>>>>>>> cope/main
                </td>
                <td class="px-6 py-4 whitespace-nowrap">
                  <?php echo date('M d, Y h:i A', strtotime($election['start_date'])); ?>
                </td>
                <td class="px-6 py-4 whitespace-nowrap">
                  <?php echo date('M d, Y h:i A', strtotime($election['end_date'])); ?>
                </td>
                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                  <button onclick="openEditModal(<?php echo $election['id']; ?>)"
                    class="text-blue-600 hover:text-blue-900 mr-3">
                    <i class="fas fa-edit"></i>
                  </button>
                  <button onclick="viewResults(<?php echo $election['id']; ?>)"
                    class="text-green-600 hover:text-green-900 mr-3">
                    <i class="fas fa-chart-bar"></i>
                  </button>
                  <button onclick="confirmDelete(<?php echo $election['id']; ?>)"
                    class="text-red-600 hover:text-red-900">
                    <i class="fas fa-trash"></i>
                  </button>
                </td>
              </tr>
              <?php endwhile; ?>
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>

  <!-- Add Election Modal -->
  <div id="addModal" class="fixed inset-0 bg-gray-600 bg-opacity-50 hidden overflow-y-auto h-full w-full">
    <div class="relative top-20 mx-auto p-5 border w-96 shadow-lg rounded-md bg-white">
      <div class="mt-3">
        <h3 class="text-lg font-medium leading-6 text-gray-900 mb-4">Create New Election</h3>
        <form action="actions/add_election.php" method="POST">
          <div class="mb-4">
            <label class="block text-gray-700 text-sm font-bold mb-2">Title</label>
            <input type="text" name="title" required
              class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
          </div>
          <div class="mb-4">
            <label class="block text-gray-700 text-sm font-bold mb-2">Description</label>
            <textarea name="description" required
              class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"></textarea>
          </div>
          <div class="mb-4">
            <label class="block text-gray-700 text-sm font-bold mb-2">Start Date</label>
            <input type="datetime-local" name="start_date" required
              class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
          </div>
          <div class="mb-4">
            <label class="block text-gray-700 text-sm font-bold mb-2">End Date</label>
            <input type="datetime-local" name="end_date" required
              class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
          </div>
          <div class="flex justify-end">
            <button type="button" onclick="closeAddModal()"
              class="bg-gray-500 text-white px-4 py-2 rounded mr-2">Cancel</button>
            <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded">Create Election</button>
          </div>
        </form>
      </div>
    </div>
  </div>

  <!-- Edit Election Modal -->
  <div id="editModal" class="fixed inset-0 bg-gray-600 bg-opacity-50 hidden overflow-y-auto h-full w-full">
    <div class="relative top-20 mx-auto p-5 border w-[600px] shadow-lg rounded-md bg-white">
      <div class="mt-3">
        <div class="flex justify-between items-center mb-4">
          <h3 class="text-lg font-medium text-gray-900">Edit Election</h3>
          <button onclick="closeEditModal()" class="text-gray-400 hover:text-gray-500">
            <i class="fas fa-times"></i>
          </button>
        </div>
        <form action="actions/edit_election.php" method="POST">
          <input type="hidden" name="election_id" id="edit_election_id">
          <div class="mb-4">
            <label class="block text-gray-700 text-sm font-bold mb-2">Title</label>
            <input type="text" name="title" id="edit_title" required
              class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
          </div>
          <div class="mb-4">
            <label class="block text-gray-700 text-sm font-bold mb-2">Description</label>
            <textarea name="description" id="edit_description" required rows="3"
              class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"></textarea>
          </div>
          <div class="grid grid-cols-2 gap-4">
            <div class="mb-4">
              <label class="block text-gray-700 text-sm font-bold mb-2">Start Date</label>
              <input type="datetime-local" name="start_date" id="edit_start_date" required
                class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
            </div>
            <div class="mb-4">
              <label class="block text-gray-700 text-sm font-bold mb-2">End Date</label>
              <input type="datetime-local" name="end_date" id="edit_end_date" required
                class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
            </div>
          </div>
          <div class="mb-4">
            <label class="block text-gray-700 text-sm font-bold mb-2">Status</label>
            <select name="status" id="edit_status" required
              class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
              <option value="pending">Pending</option>
              <option value="active">Active</option>
              <option value="completed">Completed</option>
            </select>
          </div>
          <div class="flex justify-end">
            <button type="button" onclick="closeEditModal()"
              class="bg-gray-500 text-white px-4 py-2 rounded mr-2">Cancel</button>
            <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded">Update Election</button>
          </div>
        </form>
      </div>
    </div>
  </div>

  <script>
  function openAddModal() {
    document.getElementById('addModal').classList.remove('hidden');
  }

  function closeAddModal() {
    document.getElementById('addModal').classList.add('hidden');
  }

  function openEditModal(electionId) {
    // Fetch election data
    fetch(`actions/get_election.php?id=${electionId}`)
      .then(response => response.json())
      .then(election => {
        document.getElementById('edit_election_id').value = election.id;
        document.getElementById('edit_title').value = election.title;
        document.getElementById('edit_description').value = election.description;

        // Format datetime for input
        const startDate = new Date(election.start_date);
        const endDate = new Date(election.end_date);

        document.getElementById('edit_start_date').value = formatDateTimeLocal(startDate);
        document.getElementById('edit_end_date').value = formatDateTimeLocal(endDate);
        document.getElementById('edit_status').value = election.status;

        document.getElementById('editModal').classList.remove('hidden');
      });
  }

  function closeEditModal() {
    document.getElementById('editModal').classList.add('hidden');
  }

  function formatDateTimeLocal(date) {
    const year = date.getFullYear();
    const month = String(date.getMonth() + 1).padStart(2, '0');
    const day = String(date.getDate()).padStart(2, '0');
    const hours = String(date.getHours()).padStart(2, '0');
    const minutes = String(date.getMinutes()).padStart(2, '0');

    return `${year}-${month}-${day}T${hours}:${minutes}`;
  }

  function confirmDelete(electionId) {
    if (confirm('Are you sure you want to delete this election?')) {
      window.location.href = `actions/delete_election.php?id=${electionId}`;
    }
  }

  function viewResults(electionId) {
    window.location.href = `results.php?election_id=${electionId}`;
  }
<<<<<<< HEAD

  function openPartylistModal() {
    document.getElementById('partylistModal').classList.remove('hidden');
  }

  function closePartylistModal() {
    document.getElementById('partylistModal').classList.add('hidden');
  }

  function confirmDeletePartylist(partylistId) {
    if (confirm('Are you sure you want to delete this partylist?')) {
      window.location.href = `actions/delete_partylist.php?id=${partylistId}`;
    }
  }
=======
>>>>>>> cope/main
  </script>
</body>

</html>