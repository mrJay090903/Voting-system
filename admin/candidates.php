<?php
session_start();
include '../database/db.php';

// Check if user is logged in as admin
if (!isset($_SESSION['user_type']) || $_SESSION['user_type'] !== 'admin') {
    header("Location: ../index.php");
    exit();
}

$admin_username = $_SESSION['admin_username'];

<<<<<<< HEAD
// Get all candidates with student, election, and partylist details
=======
// Get all candidates with student, election, and partylist details, including vote counts
$search_query = '';
if (isset($_POST['search'])) {
    $search_query = mysqli_real_escape_string($conn, $_POST['search_query']);
}

>>>>>>> cope/main
$candidates = $conn->query("
    SELECT 
        c.*,
        s.FullName as student_name,
        s.Grade as student_grade,
        e.title as election_title,
        e.status as election_status,
        COALESCE(p.name, 'Independent') as partylist_name,
        p.logo_url as partylist_logo,
<<<<<<< HEAD
        COUNT(v.id) as votes
=======
        COUNT(v.id) as vote_count
>>>>>>> cope/main
    FROM candidates c 
    JOIN students s ON c.student_id = s.StudentID 
    JOIN elections e ON c.election_id = e.id 
    LEFT JOIN partylists p ON c.partylist_name = p.name
    LEFT JOIN votes v ON c.id = v.candidate_id
<<<<<<< HEAD
    GROUP BY c.id, s.FullName, s.Grade, e.title, e.status, p.name, p.logo_url
    ORDER BY 
        FIELD(c.position, 'President', 'Vice President', 'Secretary', 'Treasurer', 'Auditor', 'PIO', 'Protocol Officer', 
        'Grade 7 Representative', 'Grade 8 Representative', 'Grade 9 Representative', 'Grade 10 Representative', 
        'Grade 11 Representative', 'Grade 12 Representative'),
        e.title, c.candidate_type DESC, c.position, c.partylist_name
=======
    WHERE s.FullName LIKE '%$search_query%' OR c.position LIKE '%$search_query%'
    GROUP BY c.id
    ORDER BY e.title, c.candidate_type DESC, c.position, c.partylist_name
>>>>>>> cope/main
");

// Get all active partylists for the dropdown
$partylists = $conn->query("SELECT * FROM partylists WHERE status = 'active' ORDER BY name");

// Add these status functions to elections.php
function getElectionStatus($election) {
    $now = time();
    $start = strtotime($election['start_date']);
    $end = strtotime($election['end_date']);
    
    if ($now < $start) {
        return 'pending';
    } elseif ($now >= $start && $now <= $end) {
        return 'active';
    } else {
        return 'completed';
    }
}

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
$elections = $conn->query("
    SELECT 
        e.*,
        COUNT(DISTINCT c.id) as candidate_count,
        COUNT(DISTINCT v.id) as vote_count,
        (SELECT COUNT(*) FROM students) as total_students
    FROM elections e
    LEFT JOIN candidates c ON e.id = c.election_id
    LEFT JOIN votes v ON e.id = v.election_id
    GROUP BY e.id
    ORDER BY 
        CASE e.status
            WHEN 'active' THEN 1
            WHEN 'pending' THEN 2
            WHEN 'completed' THEN 3
        END,
        e.start_date DESC
");
=======
>>>>>>> cope/main
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Candidates Management - Admin Dashboard</title>
  <link rel="icon" href="../components/image/logo.png" type="image/png">
  <script src="https://cdn.tailwindcss.com"></script>
<<<<<<< HEAD
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
  <link href="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.5.12/cropper.min.css" rel="stylesheet">
  <script src="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.5.12/cropper.min.js"></script>
</head>

<body class="bg-gray-100">
  <?php include '../components/notification.php';
    if (isset($_GET['success'])) echo showNotification($_GET['success']);
    if (isset($_GET['error'])) echo showNotification($_GET['error'], 'error');
    ?>

  <div class="flex">
    <!-- Include Sidebar -->
    <div class="sticky top-0 h-screen  ">
      <?php include '../components/admin_sidebar.php'; ?>
    </div>
=======
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>

<body class="bg-gray-100">


  <div class="flex">
    <!-- Include Sidebar -->
    <?php include '../components/admin_sidebar.php'; ?>
>>>>>>> cope/main

    <!-- Main Content -->
    <div class="flex-1">
      <!-- Top Navigation -->
<<<<<<< HEAD
      <div class="bg-white shadow-md px-6 py-4 flex justify-between items-center sticky top-0">
=======
      <div class="bg-white shadow-md px-6 py-4 flex justify-between items-center">
>>>>>>> cope/main
        <h1 class="text-xl font-semibold">Candidates Management</h1>
        <div class="flex items-center space-x-4">
          <button onclick="openAddModal()" class="bg-blue-500 text-white px-4 py-2 rounded-lg hover:bg-blue-600">
            <i class="fas fa-plus mr-2"></i>Add Candidate
          </button>
          <span class="text-gray-600">Welcome, <?php echo htmlspecialchars($admin_username); ?></span>
          <a href="../auth/logout.php" class="bg-red-500 text-white px-4 py-2 rounded-lg hover:bg-red-600">Logout</a>
        </div>
      </div>

      <!-- Candidates List -->
      <div class="p-6">
        <div class="bg-white rounded-lg shadow-md overflow-hidden">
<<<<<<< HEAD
=======
          <div class="flex justify-between items-center ">


          </div>
>>>>>>> cope/main
          <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-50">
              <tr>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Election</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Candidate Name</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Position</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Votes</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Actions</th>
              </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
              <?php while($candidate = $candidates->fetch_assoc()): ?>
              <tr>
                <td class="px-6 py-4 whitespace-nowrap">
                  <?php echo htmlspecialchars($candidate['election_title']); ?>
                </td>
                <td class="px-6 py-4 whitespace-nowrap">
                  <?php echo htmlspecialchars($candidate['student_name']); ?>
                </td>
                <td class="px-6 py-4 whitespace-nowrap">
                  <?php echo htmlspecialchars($candidate['position']); ?>
                </td>
                <td class="px-6 py-4 whitespace-nowrap">
<<<<<<< HEAD
                  <?php echo htmlspecialchars($candidate['votes']); ?>
=======
                  <?php echo htmlspecialchars($candidate['vote_count']); ?>
>>>>>>> cope/main
                </td>
                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                  <button onclick="openEditModal(<?php echo $candidate['id']; ?>)"
                    class="text-blue-600 hover:text-blue-900 mr-3">
                    <i class="fas fa-edit"></i>
                  </button>
<<<<<<< HEAD
                  <button
                    onclick="confirmDelete(<?php echo htmlspecialchars($candidate['id'], ENT_QUOTES, 'UTF-8'); ?>)"
                    class="text-red-600 hover:text-red-900">
                    <i class="fas fa-trash"></i>
                  </button>

=======
                  <button onclick="confirmDelete(<?php echo $candidate['id']; ?>)"
                    class="text-red-600 hover:text-red-900">
                    <i class="fas fa-trash"></i>
                  </button>
>>>>>>> cope/main
                </td>
              </tr>
              <?php endwhile; ?>
            </tbody>
          </table>
        </div>
<<<<<<< HEAD


=======
      </div>
      <div class="p-6">
>>>>>>> cope/main
        <!-- Partylist Management Section -->
        <div class="mt-8">
          <div class="flex justify-between items-center mb-6">
            <h2 class="text-2xl font-semibold">Partylists</h2>
            <button onclick="openPartylistModal()"
              class="bg-green-500 text-white px-4 py-2 rounded-lg hover:bg-green-600">
              <i class="fas fa-plus mr-2"></i>Add Partylist
            </button>
          </div>

          <!-- Partylists Table -->
<<<<<<< HEAD
          <div class="bg-white rounded-lg shadow-md overflow-x-auto">
=======

          <div class="bg-white rounded-lg shadow-md overflow-x-auto ">
>>>>>>> cope/main
            <table class="min-w-full divide-y divide-gray-200">
              <thead class="bg-gray-50">
                <tr>
                  <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Logo</th>
                  <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Name</th>
                  <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Description</th>
                  <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Status</th>
                  <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Actions</th>
                </tr>
              </thead>
              <tbody class="bg-white divide-y divide-gray-200">
                <?php 
                      $partylists->data_seek(0);
                      while($partylist = $partylists->fetch_assoc()): 
                      ?>
                <tr>
                  <td class="px-6 py-4 whitespace-nowrap">
                    <?php if($partylist['logo_url']): ?>
                    <img src="../<?php echo htmlspecialchars($partylist['logo_url']); ?>"
                      class="h-10 w-10 rounded-full object-cover">
                    <?php else: ?>
                    <div class="h-10 w-10 rounded-full bg-gray-200 flex items-center justify-center">
                      <i class="fas fa-users text-gray-400"></i>
                    </div>
                    <?php endif; ?>
                  </td>
                  <td class="px-6 py-4 whitespace-nowrap"><?php echo htmlspecialchars($partylist['name']); ?></td>
                  <td class="px-6 py-4"><?php echo htmlspecialchars($partylist['description']); ?></td>
                  <td class="px-6 py-4 whitespace-nowrap">
                    <span
                      class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full 
                                  <?php echo $partylist['status'] === 'active' ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800'; ?>">
                      <?php echo ucfirst($partylist['status']); ?>
                    </span>
                  </td>
                  <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                    <button onclick="openEditPartylistModal(<?php echo $partylist['id']; ?>)"
                      class="text-blue-600 hover:text-blue-900 mr-3">
                      <i class="fas fa-edit"></i>
                    </button>
                    <button onclick="confirmDeletePartylist(<?php echo $partylist['id']; ?>)"
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

        <!-- Add Partylist Modal -->
        <div id="partylistModal" class="fixed inset-0 bg-gray-600 bg-opacity-50 hidden overflow-y-auto h-full w-full">
          <div class="relative top-20 mx-auto p-5 border w-96 shadow-lg rounded-md bg-white">
            <div class="mt-3">
              <div class="flex justify-between items-center mb-4">
                <h3 class="text-lg font-medium text-gray-900">Add New Partylist</h3>
                <button onclick="closePartylistModal()" class="text-gray-400 hover:text-gray-500">
                  <i class="fas fa-times"></i>
                </button>
              </div>
              <form action="actions/add_partylist.php" method="POST" enctype="multipart/form-data">
                <div class="mb-4">
                  <label class="block text-gray-700 text-sm font-bold mb-2">Name</label>
                  <input type="text" name="name" required
                    class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                </div>
                <div class="mb-4">
                  <label class="block text-gray-700 text-sm font-bold mb-2">Description</label>
                  <textarea name="description" required rows="3"
                    class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"></textarea>
                </div>
                <div class="mb-4">
                  <label class="block text-gray-700 text-sm font-bold mb-2">Logo</label>
                  <input type="file" name="logo" accept="image/*"
                    class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                </div>
                <div class="flex justify-end">
                  <button type="button" onclick="closePartylistModal()"
                    class="bg-gray-500 text-white px-4 py-2 rounded mr-2">Cancel</button>
                  <button type="submit" class="bg-green-500 text-white px-4 py-2 rounded">Add Partylist</button>
                </div>
              </form>
            </div>
          </div>
        </div>

        <!-- Edit Partylist Modal -->
        <div id="editPartylistModal"
          class="fixed inset-0 bg-gray-600 bg-opacity-50 hidden overflow-y-auto h-full w-full">
          <div class="relative top-20 mx-auto p-5 border w-96 shadow-lg rounded-md bg-white">
            <div class="mt-3">
              <div class="flex justify-between items-center mb-4">
                <h3 class="text-lg font-medium text-gray-900">Edit Partylist</h3>
                <button onclick="closeEditPartylistModal()" class="text-gray-400 hover:text-gray-500">
                  <i class="fas fa-times"></i>
                </button>
              </div>
              <form action="actions/edit_partylist.php" method="POST" enctype="multipart/form-data">
                <input type="hidden" name="partylist_id" id="edit_partylist_id">
                <div class="mb-4">
                  <label class="block text-gray-700 text-sm font-bold mb-2">Name</label>
                  <input type="text" name="name" id="edit_partylist_name" required
                    class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                </div>
                <div class="mb-4">
                  <label class="block text-gray-700 text-sm font-bold mb-2">Description</label>
                  <textarea name="description" id="edit_partylist_description" required rows="3"
                    class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"></textarea>
                </div>
                <div class="mb-4">
                  <label class="block text-gray-700 text-sm font-bold mb-2">Status</label>
                  <select name="status" id="edit_partylist_status" required
                    class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                    <option value="active">Active</option>
                    <option value="inactive">Inactive</option>
                  </select>
                </div>
                <div class="mb-4">
                  <label class="block text-gray-700 text-sm font-bold mb-2">Logo</label>
                  <input type="file" name="logo" accept="image/*"
                    class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                  <div id="current_logo" class="mt-2"></div>
                </div>
                <div class="flex justify-end">
                  <button type="button" onclick="closeEditPartylistModal()"
                    class="bg-gray-500 text-white px-4 py-2 rounded mr-2">Cancel</button>
                  <button type="submit" class="bg-green-500 text-white px-4 py-2 rounded">Update Partylist</button>
                </div>
              </form>
            </div>
          </div>
        </div>
      </div>
    </div>
<<<<<<< HEAD
  </div>

  <!-- Add Candidate Modal -->
  <div id="addModal" class="fixed inset-0 bg-gray-600 bg-opacity-50 hidden overflow-y-auto h-full w-full">
    <div class="relative top-20 mx-auto p-5 border w-[600px] shadow-lg rounded-md bg-white">
      <div class="mt-3">
        <div class="flex justify-between items-center mb-4">
          <h3 class="text-lg font-medium text-gray-900">Add New Candidate</h3>
          <button onclick="closeAddModal()" class="text-gray-400 hover:text-gray-500">
            <i class="fas fa-times"></i>
          </button>
        </div>
        <form action="actions/add_candidate.php" method="POST" enctype="multipart/form-data"
          onsubmit="return prepareImageSubmit(this, 'add')">
          <div class="grid grid-cols-2 gap-4">
            <div class="mb-4">
              <label class="block text-gray-700 text-sm font-bold mb-2">Election</label>
              <select name="election_id" required
                class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                <option value="">Select Election</option>
                <?php
=======

    <!-- Add Candidate Modal -->
    <div id="addModal" class="fixed inset-0 bg-gray-600 bg-opacity-50 hidden overflow-y-auto h-full w-full">
      <div class="relative top-20 mx-auto p-5 border w-[600px] shadow-lg rounded-md bg-white">
        <div class="mt-3">
          <div class="flex justify-between items-center mb-4">
            <h3 class="text-lg font-medium text-gray-900">Add New Candidate</h3>
            <button onclick="closeAddModal()" class="text-gray-400 hover:text-gray-500">
              <i class="fas fa-times"></i>
            </button>
          </div>
          <form action="actions/add_candidate.php" method="POST" enctype="multipart/form-data">
            <div class="grid grid-cols-2 gap-4">
              <div class="mb-4">
                <label class="block text-gray-700 text-sm font-bold mb-2">Election</label>
                <select name="election_id" required
                  class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                  <option value="">Select Election</option>
                  <?php
>>>>>>> cope/main
                            $elections = $conn->query("SELECT * FROM elections WHERE status != 'completed' ORDER BY title");
                            while($election = $elections->fetch_assoc()) {
                                echo "<option value='" . $election['id'] . "'>" . htmlspecialchars($election['title']) . "</option>";
                            }
                            ?>
<<<<<<< HEAD
              </select>
            </div>

            <div class="mb-4">
              <label class="block text-gray-700 text-sm font-bold mb-2">Student</label>
              <select name="student_id" required
                class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                <option value="">Select Student</option>
                <?php
=======
                </select>
              </div>

              <div class="mb-4">
                <label class="block text-gray-700 text-sm font-bold mb-2">Student</label>
                <select name="student_id" required
                  class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                  <option value="">Select Student</option>
                  <?php
>>>>>>> cope/main
                            $students = $conn->query("SELECT * FROM students ORDER BY FullName");
                            while($student = $students->fetch_assoc()) {
                                echo "<option value='" . $student['StudentID'] . "'>" . htmlspecialchars($student['FullName']) . "</option>";
                            }
                            ?>
<<<<<<< HEAD
              </select>
            </div>

            <div class="mb-4">
              <label class="block text-gray-700 text-sm font-bold mb-2">Position</label>
              <select name="position" required
                class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                <option value="">Select Position</option>
                <option value="President">President</option>
                <option value="Vice President">Vice President</option>
                <option value="Secretary">Secretary</option>
                <option value="Treasurer">Treasurer</option>
                <option value="Auditor">Auditor</option>
                <option value="PIO">PIO</option>
                <option value="Protocol Officer">Protocol Officer</option>
                <option value="Grade 7 Representative">Grade 7 Representative</option>
                <option value="Grade 8 Representative">Grade 8 Representative</option>
                <option value="Grade 9 Representative">Grade 9 Representative</option>
                <option value="Grade 10 Representative">Grade 10 Representative</option>
                <option value="Grade 11 Representative">Grade 11 Representative</option>
                <option value="Grade 12 Representative">Grade 12 Representative</option>
              </select>
            </div>

            <div class="mb-4">
              <label class="block text-gray-700 text-sm font-bold mb-2">Candidate Type</label>
              <select name="candidate_type" required onchange="togglePartylist(this.value, 'add')"
                class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                <option value="independent">Independent</option>
                <option value="partylist">Partylist</option>
              </select>
            </div>

            <div id="addPartylistField" class="mb-4 hidden">
              <label class="block text-gray-700 text-sm font-bold mb-2">Partylist</label>
              <select name="partylist_name"
                class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                <option value="">Select Partylist</option>
                <?php 
                            $partylists->data_seek(0);
                            while($partylist = $partylists->fetch_assoc()): 
                            ?>
                <option value="<?php echo htmlspecialchars($partylist['name']); ?>">
                  <?php echo htmlspecialchars($partylist['name']); ?>
                </option>
                <?php endwhile; ?>
              </select>
            </div>

            <div class="mb-4">
              <label class="block text-gray-700 text-sm font-bold mb-2">Photo</label>
              <input type="file" name="image" accept="image/*" id="addPhotoInput"
                class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                onchange="previewImage(this, 'addImagePreview', 'addCropButton')">
              <div class="mt-2">
                <img id="addImagePreview" class="hidden max-w-xs">
                <button type="button" id="addCropButton" onclick="openCropModal('addImagePreview')"
                  class="hidden mt-2 bg-green-500 text-white px-4 py-2 rounded">
                  Crop Image
                </button>
              </div>
              <input type="hidden" name="cropped_image" id="addCroppedImage">
            </div>
          </div>

          <div class="mb-4">
            <label class="block text-gray-700 text-sm font-bold mb-2">Platform</label>
            <textarea name="platform" required rows="3"
              class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"></textarea>
          </div>

          <div class="grid grid-cols-2 gap-4">
            <div class="mb-4">
              <label class="block text-gray-700 text-sm font-bold mb-2">Vision</label>
              <textarea name="vision" required rows="3"
                class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"></textarea>
            </div>

            <div class="mb-4">
              <label class="block text-gray-700 text-sm font-bold mb-2">Mission</label>
              <textarea name="mission" required rows="3"
                class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"></textarea>
            </div>
          </div>

          <div class="flex justify-end">
            <button type="button" onclick="closeAddModal()"
              class="bg-gray-500 text-white px-4 py-2 rounded mr-2">Cancel</button>
            <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded">Add Candidate</button>
          </div>
        </form>
      </div>
    </div>
  </div>

  <!-- Edit Candidate Modal -->
  <div id="editModal" class="fixed inset-0 bg-gray-600 bg-opacity-50 hidden overflow-y-auto h-full w-full">
    <div class="relative top-20 mx-auto p-5 border w-[600px] shadow-lg rounded-md bg-white">
      <div class="mt-3">
        <div class="flex justify-between items-center mb-4">
          <h3 class="text-lg font-medium text-gray-900">Edit Candidate</h3>
          <button onclick="closeEditModal()" class="text-gray-400 hover:text-gray-500">
            <i class="fas fa-times"></i>
          </button>
        </div>
        <form action="actions/edit_candidate.php" method="POST" enctype="multipart/form-data"
          onsubmit="return prepareImageSubmit(this, 'edit')">
          <input type="hidden" name="candidate_id" id="edit_candidate_id">
          <div class="grid grid-cols-2 gap-4">
            <div class="mb-4">
              <label class="block text-gray-700 text-sm font-bold mb-2">Position</label>
              <select name="position" id="edit_position" required
                class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                <option value="President">President</option>
                <option value="Vice President">Vice President</option>
                <option value="Secretary">Secretary</option>
                <option value="Treasurer">Treasurer</option>
                <option value="Auditor">Auditor</option>
                <option value="PIO">PIO</option>
                <option value="Protocol Officer">Protocol Officer</option>
                <option value="Grade 7 Representative">Grade 7 Representative</option>
                <option value="Grade 8 Representative">Grade 8 Representative</option>
                <option value="Grade 9 Representative">Grade 9 Representative</option>
                <option value="Grade 10 Representative">Grade 10 Representative</option>
                <option value="Grade 11 Representative">Grade 11 Representative</option>
                <option value="Grade 12 Representative">Grade 12 Representative</option>
              </select>
            </div>

            <div class="mb-4">
              <label class="block text-gray-700 text-sm font-bold mb-2">Candidate Type</label>
              <select name="candidate_type" id="edit_candidate_type" required
                onchange="togglePartylist(this.value, 'edit')"
                class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                <option value="independent">Independent</option>
                <option value="partylist">Partylist</option>
              </select>
            </div>

            <div id="editPartylistField" class="mb-4 hidden">
              <label class="block text-gray-700 text-sm font-bold mb-2">Partylist</label>
              <select name="partylist_name" id="edit_partylist_name"
                class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                <option value="">Select Partylist</option>
                <?php 
                            $partylists->data_seek(0);
                            while($partylist = $partylists->fetch_assoc()): 
                            ?>
                <option value="<?php echo htmlspecialchars($partylist['name']); ?>">
                  <?php echo htmlspecialchars($partylist['name']); ?>
                </option>
                <?php endwhile; ?>
              </select>
            </div>

            <div class="mb-4">
              <label class="block text-gray-700 text-sm font-bold mb-2">Photo</label>
              <input type="file" name="image" accept="image/*" id="editPhotoInput"
                class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                onchange="previewImage(this, 'editImagePreview', 'editCropButton')">
              <div class="mt-2">
                <img id="editImagePreview" class="hidden max-w-xs">
                <button type="button" id="editCropButton" onclick="openCropModal('editImagePreview')"
                  class="hidden mt-2 bg-green-500 text-white px-4 py-2 rounded">
                  Crop Image
                </button>
                <div id="current_image" class="mt-2"></div>
              </div>
              <input type="hidden" name="cropped_image" id="editCroppedImage">
            </div>
          </div>

          <div class="mb-4">
            <label class="block text-gray-700 text-sm font-bold mb-2">Platform</label>
            <textarea name="platform" id="edit_platform" required rows="3"
              class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"></textarea>
          </div>

          <div class="grid grid-cols-2 gap-4">
            <div class="mb-4">
              <label class="block text-gray-700 text-sm font-bold mb-2">Vision</label>
              <textarea name="vision" id="edit_vision" required rows="3"
                class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"></textarea>
            </div>

            <div class="mb-4">
              <label class="block text-gray-700 text-sm font-bold mb-2">Mission</label>
              <textarea name="mission" id="edit_mission" required rows="3"
                class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"></textarea>
            </div>
          </div>

          <div class="flex justify-end">
            <button type="button" onclick="closeEditModal()"
              class="bg-gray-500 text-white px-4 py-2 rounded mr-2">Cancel</button>
            <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded">Update Candidate</button>
          </div>
        </form>
      </div>
    </div>
  </div>

  <!-- Add Image Crop Modal -->
  <div id="cropModal" class="fixed inset-0 bg-gray-600 bg-opacity-50 hidden overflow-y-auto h-full w-full">
    <div class="relative top-20 mx-auto p-5 border w-[800px] shadow-lg rounded-md bg-white">
      <div class="mt-3">
        <div class="flex justify-between items-center mb-4">
          <h3 class="text-lg font-medium text-gray-900">Crop Image</h3>
          <button onclick="closeCropModal()" class="text-gray-400 hover:text-gray-500">
            <i class="fas fa-times"></i>
          </button>
        </div>
        <div class="flex justify-center">
          <div class="max-w-full max-h-[500px] overflow-auto">
            <img id="cropImage" class="max-w-full">
          </div>
        </div>
        <div class="flex justify-end mt-4">
          <button type="button" onclick="closeCropModal()"
            class="bg-gray-500 text-white px-4 py-2 rounded mr-2">Cancel</button>
          <button type="button" onclick="cropImage()" class="bg-green-500 text-white px-4 py-2 rounded">Crop</button>
        </div>
      </div>
    </div>
  </div>

  <script>
  function confirmDelete(candidateId) {
    Swal.fire({
      title: "Are you sure?",
      text: "This action cannot be undone! The candidate and associated votes will be deleted.",
      icon: "warning",
      showCancelButton: true,
      confirmButtonColor: "#d33",
      cancelButtonColor: "#3085d6",
      confirmButtonText: "Yes, delete it!"
    }).then((result) => {
      if (result.isConfirmed) {
        // Show loading state
        Swal.fire({
          title: "Deleting...",
          text: "Please wait while we delete the candidate.",
          icon: "info",
          allowOutsideClick: false,
          showConfirmButton: false,
          willOpen: () => {
            Swal.showLoading();
          }
        });

=======
                </select>
              </div>

              <div class="mb-4">
                <label class="block text-gray-700 text-sm font-bold mb-2">Position</label>
                <select name="position" required
                  class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                  <option value="">Select Position</option>
                  <option value="President">President</option>
                  <option value="Vice President">Vice President</option>
                  <option value="Secretary">Secretary</option>
                  <option value="Treasurer">Treasurer</option>
                  <option value="Auditor">Auditor</option>
                  <option value="PIO">PIO</option>
                  <option value="Protocol Officer">Protocol Officer</option>
                  <option value="Grade 7 Representative">Grade 7 Representative</option>
                  <option value="Grade 8 Representative">Grade 8 Representative</option>
                  <option value="Grade 9 Representative">Grade 9 Representative</option>
                  <option value="Grade 10 Representative">Grade 10 Representative</option>
                  <option value="Grade 11 Representative">Grade 11 Representative</option>
                  <option value="Grade 12 Representative">Grade 12 Representative</option>
                </select>
              </div>

              <div class="mb-4">
                <label class="block text-gray-700 text-sm font-bold mb-2">Candidate Type</label>
                <select name="candidate_type" required onchange="togglePartylist(this.value, 'add')"
                  class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                  <option value="independent">Independent</option>
                  <option value="partylist">Partylist</option>
                </select>
              </div>

              <div id="addPartylistField" class="mb-4 hidden">
                <label class="block text-gray-700 text-sm font-bold mb-2">Partylist</label>
                <select name="partylist_name"
                  class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                  <option value="">Select Partylist</option>
                  <?php 
                            $partylists->data_seek(0);
                            while($partylist = $partylists->fetch_assoc()): 
                            ?>
                  <option value="<?php echo htmlspecialchars($partylist['name']); ?>">
                    <?php echo htmlspecialchars($partylist['name']); ?>
                  </option>
                  <?php endwhile; ?>
                </select>
              </div>

              <div class="mb-4">
                <label class="block text-gray-700 text-sm font-bold mb-2">Photo</label>
                <input type="file" name="image" accept="image/*"
                  class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
              </div>
            </div>

            <div class="mb-4">
              <label class="block text-gray-700 text-sm font-bold mb-2">Platform</label>
              <textarea name="platform" required rows="3"
                class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"></textarea>
            </div>

            <div class="grid grid-cols-2 gap-4">
              <div class="mb-4">
                <label class="block text-gray-700 text-sm font-bold mb-2">Vision</label>
                <textarea name="vision" required rows="3"
                  class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"></textarea>
              </div>

              <div class="mb-4">
                <label class="block text-gray-700 text-sm font-bold mb-2">Mission</label>
                <textarea name="mission" required rows="3"
                  class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"></textarea>
              </div>
            </div>

            <div class="flex justify-end">
              <button type="button" onclick="closeAddModal()"
                class="bg-gray-500 text-white px-4 py-2 rounded mr-2">Cancel</button>
              <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded">Add Candidate</button>
            </div>
          </form>
        </div>
      </div>
    </div>

    <!-- Edit Candidate Modal -->
    <div id="editModal" class="fixed inset-0 bg-gray-600 bg-opacity-50 hidden overflow-y-auto h-full w-full">
      <div class="relative top-20 mx-auto p-5 border w-[600px] shadow-lg rounded-md bg-white">
        <div class="mt-3">
          <div class="flex justify-between items-center mb-4">
            <h3 class="text-lg font-medium text-gray-900">Edit Candidate</h3>
            <button onclick="closeEditModal()" class="text-gray-400 hover:text-gray-500">
              <i class="fas fa-times"></i>
            </button>
          </div>
          <form action="actions/edit_candidate.php" method="POST" enctype="multipart/form-data">
            <input type="hidden" name="candidate_id" id="edit_candidate_id">
            <div class="grid grid-cols-2 gap-4">
              <div class="mb-4">
                <label class="block text-gray-700 text-sm font-bold mb-2">Position</label>
                <select name="position" id="edit_position" required
                  class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                  <option value="President">President</option>
                  <option value="Vice President">Vice President</option>
                  <option value="Secretary">Secretary</option>
                  <option value="Treasurer">Treasurer</option>
                  <option value="Auditor">Auditor</option>
                  <option value="PIO">PIO</option>
                  <option value="Protocol Officer">Protocol Officer</option>
                  <option value="Grade 7 Representative">Grade 7 Representative</option>
                  <option value="Grade 8 Representative">Grade 8 Representative</option>
                  <option value="Grade 9 Representative">Grade 9 Representative</option>
                  <option value="Grade 10 Representative">Grade 10 Representative</option>
                  <option value="Grade 11 Representative">Grade 11 Representative</option>
                  <option value="Grade 12 Representative">Grade 12 Representative</option>
                </select>
              </div>

              <div class="mb-4">
                <label class="block text-gray-700 text-sm font-bold mb-2">Candidate Type</label>
                <select name="candidate_type" id="edit_candidate_type" required
                  onchange="togglePartylist(this.value, 'edit')"
                  class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                  <option value="independent">Independent</option>
                  <option value="partylist">Partylist</option>
                </select>
              </div>

              <div id="editPartylistField" class="mb-4 hidden">
                <label class="block text-gray-700 text-sm font-bold mb-2">Partylist</label>
                <select name="partylist_name" id="edit_partylist_name"
                  class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                  <option value="">Select Partylist</option>
                  <?php 
                            $partylists->data_seek(0);
                            while($partylist = $partylists->fetch_assoc()): 
                            ?>
                  <option value="<?php echo htmlspecialchars($partylist['name']); ?>">
                    <?php echo htmlspecialchars($partylist['name']); ?>
                  </option>
                  <?php endwhile; ?>
                </select>
              </div>

              <div class="mb-4">
                <label class="block text-gray-700 text-sm font-bold mb-2">Photo</label>
                <input type="file" name="image" accept="image/*"
                  class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                <div id="current_image" class="mt-2"></div>
              </div>
            </div>

            <div class="mb-4">
              <label class="block text-gray-700 text-sm font-bold mb-2">Platform</label>
              <textarea name="platform" id="edit_platform" required rows="3"
                class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"></textarea>
            </div>

            <div class="grid grid-cols-2 gap-4">
              <div class="mb-4">
                <label class="block text-gray-700 text-sm font-bold mb-2">Vision</label>
                <textarea name="vision" id="edit_vision" required rows="3"
                  class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"></textarea>
              </div>

              <div class="mb-4">
                <label class="block text-gray-700 text-sm font-bold mb-2">Mission</label>
                <textarea name="mission" id="edit_mission" required rows="3"
                  class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"></textarea>
              </div>
            </div>

            <div class="flex justify-end">
              <button type="button" onclick="closeEditModal()"
                class="bg-gray-500 text-white px-4 py-2 rounded mr-2">Cancel</button>
              <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded">Update Candidate</button>
            </div>
          </form>
        </div>
      </div>
    </div>

    <script>
    function confirmDelete(candidateId) {
      if (confirm('Are you sure you want to remove this candidate? This action cannot be undone.')) {
        // Add error handling and feedback
>>>>>>> cope/main
        fetch(`actions/delete_candidate.php?id=${candidateId}`, {
            method: 'GET'
          })
          .then(response => response.json())
          .then(data => {
            if (data.success) {
<<<<<<< HEAD
              Swal.fire({
                title: "Deleted!",
                text: "Candidate deleted successfully.",
                icon: "success"
              }).then(() => {
                window.location.reload(); // Reload page after deletion
              });
            } else {
              Swal.fire({
                title: "Error!",
                text: "Error deleting candidate: " + data.message,
                icon: "error"
              });
            }
          })
          .catch(error => {
            console.error("Error:", error);
            Swal.fire({
              title: "Error!",
              text: "An error occurred while deleting the candidate. Please try again.",
              icon: "error"
            });
          });
      }
    });
  }

  function openAddModal() {
    document.getElementById('addModal').classList.remove('hidden');
  }

  function closeAddModal() {
    document.getElementById('addModal').classList.add('hidden');
  }

  function openEditModal(candidateId) {
    fetch(`actions/get_candidate.php?id=${candidateId}`)
      .then(response => response.json())
      .then(candidate => {
        document.getElementById('edit_candidate_id').value = candidate.id;
        document.getElementById('edit_position').value = candidate.position;
        document.getElementById('edit_candidate_type').value = candidate.candidate_type;
        document.getElementById('edit_platform').value = candidate.platform;
        document.getElementById('edit_vision').value = candidate.vision;
        document.getElementById('edit_mission').value = candidate.mission;

        // Handle partylist selection first
        const partylistField = document.getElementById('editPartylistField');
        const partylistSelect = document.getElementById('edit_partylist_name');

        if (candidate.candidate_type === 'partylist') {
          partylistField.classList.remove('hidden');
          partylistSelect.required = true;
          if (candidate.partylist_name) {
            partylistSelect.value = candidate.partylist_name;
          }
        } else {
          partylistField.classList.add('hidden');
          partylistSelect.required = false;
          partylistSelect.value = '';
        }

        // Handle image preview
        if (candidate.image_url) {
          const preview = document.getElementById('editImagePreview');
          preview.src = `../${candidate.image_url}`;
          preview.classList.remove('hidden');
          document.getElementById('editCropButton').classList.remove('hidden');
          document.getElementById('current_image').innerHTML = `
                    <img src="../${candidate.image_url}" class="h-20 w-20 object-cover rounded mt-2">
                `;
        }

        document.getElementById('editModal').classList.remove('hidden');
      });
  }

  function closeEditModal() {
    document.getElementById('editModal').classList.add('hidden');
  }

  function togglePartylist(type, mode) {
    const partylistField = document.getElementById(mode + 'PartylistField');
    const partylistSelect = partylistField.querySelector('select');

    if (type === 'partylist') {
      partylistField.classList.remove('hidden');
      partylistSelect.required = true;
    } else {
      partylistField.classList.add('hidden');
      partylistSelect.required = false;
      partylistSelect.value = '';
    }
  }

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

  function openEditPartylistModal(partylistId) {
    fetch(`actions/get_partylist.php?id=${partylistId}`)
      .then(response => response.json())
      .then(partylist => {
        document.getElementById('edit_partylist_id').value = partylist.id;
        document.getElementById('edit_partylist_name').value = partylist.name;
        document.getElementById('edit_partylist_description').value = partylist.description;
        document.getElementById('edit_partylist_status').value = partylist.status;

        if (partylist.logo_url) {
          document.getElementById('current_logo').innerHTML = `
                      <img src="../${partylist.logo_url}" class="h-20 w-20 object-cover rounded mt-2">
                  `;
        } else {
          document.getElementById('current_logo').innerHTML = '';
        }

        document.getElementById('editPartylistModal').classList.remove('hidden');
      });
  }

  function closeEditPartylistModal() {
    document.getElementById('editPartylistModal').classList.add('hidden');
  }

  let cropper;
  let currentImageId;

  function previewImage(input, previewId, cropButtonId) {
    const preview = document.getElementById(previewId);
    const cropButton = document.getElementById(cropButtonId);

    if (input.files && input.files[0]) {
      const reader = new FileReader();

      reader.onload = function(e) {
        preview.src = e.target.result;
        preview.classList.remove('hidden');
        cropButton.classList.remove('hidden');
      }

      reader.readAsDataURL(input.files[0]);
    }
  }

  function openCropModal(imageId) {
    currentImageId = imageId;
    const originalImage = document.getElementById(imageId);
    const cropImage = document.getElementById('cropImage');

    cropImage.src = originalImage.src;
    document.getElementById('cropModal').classList.remove('hidden');

    if (cropper) {
      cropper.destroy();
    }

    cropper = new Cropper(cropImage, {
      aspectRatio: 1,
      viewMode: 2,
      dragMode: 'move',
      background: false,
      responsive: true,
      modal: true,
    });
  }

  function closeCropModal() {
    if (cropper) {
      cropper.destroy();
    }
    document.getElementById('cropModal').classList.add('hidden');
  }

  function cropImage() {
    if (!cropper) return;

    const croppedCanvas = cropper.getCroppedCanvas({
      width: 400,
      height: 400
    });

    const croppedImage = document.getElementById(currentImageId);
    croppedImage.src = croppedCanvas.toDataURL();

    // Store cropped image data in hidden input
    const modalType = currentImageId.includes('add') ? 'add' : 'edit';
    document.getElementById(modalType + 'CroppedImage').value = croppedCanvas.toDataURL();

    closeCropModal();
  }

  function prepareImageSubmit(form, type) {
    const croppedImageData = document.getElementById(type + 'CroppedImage').value;

    // Create a FormData object
    const formData = new FormData(form);

    if (croppedImageData) {
      // Convert base64 to blob
      const blob = dataURLtoBlob(croppedImageData);
      // Create a File object and add to form
      const file = new File([blob], 'cropped_image.png', {
        type: 'image/png'
      });
      formData.set('image', file);
    }

    // Show loading state
    Swal.fire({
      title: 'Processing...',
      text: 'Please wait while we save the candidate.',
      allowOutsideClick: false,
      didOpen: () => {
        Swal.showLoading();
      }
    });

    // Submit form with AJAX
    fetch(form.action, {
        method: 'POST',
        body: formData
      })
      .then(response => response.json())
      .then(data => {
        if (data.success) {
          Swal.fire({
            icon: 'success',
            title: 'Success!',
            text: type === 'add' ? 'Candidate added successfully!' : 'Candidate updated successfully!',
          }).then(() => {
            window.location.reload();
          });
        } else {
          Swal.fire({
            icon: 'error',
            title: 'Error',
            text: data.message || 'An error occurred while saving the candidate.'
          });
        }
      })
      .catch(error => {
        console.error('Error:', error);
        Swal.fire({
          icon: 'error',
          title: 'Error',
          text: 'An error occurred while saving the candidate. Please try again.'
        });
      });

    return false; // Prevent normal form submission
  }

  function dataURLtoBlob(dataURL) {
    // Convert base64 to raw binary data held in a string
    const byteString = atob(dataURL.split(',')[1]);

    // Separate out the mime component
    const mimeString = dataURL.split(',')[0].split(':')[1].split(';')[0];

    // Write the bytes of the string to an ArrayBuffer
    const ab = new ArrayBuffer(byteString.length);
    const ia = new Uint8Array(ab);

    for (let i = 0; i < byteString.length; i++) {
      ia[i] = byteString.charCodeAt(i);
    }

    // Create a blob with the ArrayBuffer
    return new Blob([ab], {
      type: mimeString
    });
  }
  </script>
=======
              alert('Candidate deleted successfully');
              window.location.reload();
            } else {
              alert('Error deleting candidate: ' + data.message);
            }
          })
          .catch(error => {
            console.error('Error:', error);
            alert('Error deleting candidate. Please try again.');
          });
      }
    }

    function openAddModal() {
      document.getElementById('addModal').classList.remove('hidden');
    }

    function closeAddModal() {
      document.getElementById('addModal').classList.add('hidden');
    }

    function openEditModal(candidateId) {
      fetch(`actions/get_candidate.php?id=${candidateId}`)
        .then(response => response.json())
        .then(candidate => {
          document.getElementById('edit_candidate_id').value = candidate.id;
          document.getElementById('edit_position').value = candidate.position;
          document.getElementById('edit_candidate_type').value = candidate.candidate_type;
          document.getElementById('edit_platform').value = candidate.platform;
          document.getElementById('edit_vision').value = candidate.vision;
          document.getElementById('edit_mission').value = candidate.mission;

          togglePartylist(candidate.candidate_type, 'edit');
          if (candidate.candidate_type === 'partylist') {
            document.getElementById('edit_partylist_name').value = candidate.partylist_name;
          }

          if (candidate.image_url) {
            document.getElementById('current_image').innerHTML = `
                    <img src="../${candidate.image_url}" class="h-20 w-20 object-cover rounded">
                `;
          }

          document.getElementById('editModal').classList.remove('hidden');
        });
    }

    function closeEditModal() {
      document.getElementById('editModal').classList.add('hidden');
    }

    function togglePartylist(type, mode) {
      const partylistField = document.getElementById(mode + 'PartylistField');
      const partylistSelect = partylistField.querySelector('select');

      if (type === 'partylist') {
        partylistField.classList.remove('hidden');
        partylistSelect.required = true;
      } else {
        partylistField.classList.add('hidden');
        partylistSelect.required = false;
        partylistSelect.value = '';
      }
    }

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

    function openEditPartylistModal(partylistId) {
      fetch(`actions/get_partylist.php?id=${partylistId}`)
        .then(response => response.json())
        .then(partylist => {
          document.getElementById('edit_partylist_id').value = partylist.id;
          document.getElementById('edit_partylist_name').value = partylist.name;
          document.getElementById('edit_partylist_description').value = partylist.description;
          document.getElementById('edit_partylist_status').value = partylist.status;

          if (partylist.logo_url) {
            document.getElementById('current_logo').innerHTML = `
                      <img src="../${partylist.logo_url}" class="h-20 w-20 object-cover rounded mt-2">
                  `;
          } else {
            document.getElementById('current_logo').innerHTML = '';
          }

          document.getElementById('editPartylistModal').classList.remove('hidden');
        });
    }

    function closeEditPartylistModal() {
      document.getElementById('editPartylistModal').classList.add('hidden');
    }
    </script>
>>>>>>> cope/main
</body>

</html>