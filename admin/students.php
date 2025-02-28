<?php
session_start();
include '../database/db.php';



// Check if user is logged in as admin
if (!isset($_SESSION['user_type']) || $_SESSION['user_type'] !== 'admin') {
    header("Location: ../index.php");
    exit();
}

$admin_username = $_SESSION['admin_username'];

// Handle Delete Student
if (isset($_POST['delete_student'])) {
    $student_id = mysqli_real_escape_string($conn, $_POST['student_id']);
    
    // First delete the student's votes
    $delete_votes_sql = "DELETE FROM votes WHERE student_id = '$student_id'";
    if ($conn->query($delete_votes_sql)) {
        // Then delete the student
        $delete_student_sql = "DELETE FROM students WHERE StudentID = '$student_id'";
        if ($conn->query($delete_student_sql)) {
            header("Location: students.php?success=Student successfully deleted");
        } else {
            header("Location: students.php?error=Failed to delete student");
        }
    } else {
        header("Location: students.php?error=Failed to delete student's votes");
    }
    exit();
}

// Get all students with pagination and search
$results_per_page = 10;
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$start_from = ($page - 1) * $results_per_page;

$search_query = isset($_GET['search']) ? mysqli_real_escape_string($conn, $_GET['search']) : '';
$sql = "SELECT * FROM students 
        WHERE FullName LIKE '%$search_query%' 
        ORDER BY 
            CASE 
                WHEN Grade = 'Grade 7' THEN 1
                WHEN Grade = 'Grade 8' THEN 2
                WHEN Grade = 'Grade 9' THEN 3
                WHEN Grade = 'Grade 10' THEN 4
                WHEN Grade = 'Grade 11' THEN 5
                WHEN Grade = 'Grade 12' THEN 6
                ELSE 7
            END,
            FullName 
        LIMIT $start_from, $results_per_page";
$students = $conn->query($sql);

// Count total records for pagination
$total_students_result = $conn->query("SELECT COUNT(*) AS total FROM students WHERE FullName LIKE '%$search_query%'");
$total_students_row = $total_students_result->fetch_assoc();
$total_students = $total_students_row['total'];

$total_pages = ceil($total_students / $results_per_page);
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Student Management - Admin Dashboard</title>
  <link rel="icon" href="../components/image/logo.png" type="image/png">
  <script src="https://cdn.tailwindcss.com"></script>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>

<body class="bg-gray-100">
  <?php include '../components/notification.php';
    if (isset($_GET['success'])) echo showNotification($_GET['success']);
    if (isset($_GET['error'])) echo showNotification($_GET['error'], 'error');
    
    // Add notification for import results
    if (isset($_SESSION['message'])): ?>
  <div class="mb-4 px-4 py-2 rounded <?php 
            echo $_SESSION['message_type'] === 'success' ? 'bg-green-100 text-green-700' : 
                ($_SESSION['message_type'] === 'warning' ? 'bg-yellow-100 text-yellow-700' : 'bg-red-100 text-red-700'); 
        ?>">
    <?php echo htmlspecialchars($_SESSION['message']); ?>
    <?php if (isset($_SESSION['errors'])): ?>
    <ul class="list-disc ml-5 mt-2">
      <?php foreach ($_SESSION['errors'] as $error): ?>
      <li><?php echo htmlspecialchars($error); ?></li>
      <?php endforeach; ?>
    </ul>
    <?php endif; ?>
  </div>
  <?php 
            unset($_SESSION['message']);
            unset($_SESSION['message_type']);
            unset($_SESSION['errors']);
        ?>
  <?php endif; ?>

  <div class="flex">
    <!-- Include Sidebar -->
    <div class="sticky top-0 h-screen  ">
      <?php include '../components/admin_sidebar.php'; ?>
    </div>


    <!-- Main Content -->
    <div class="flex-1">
      <!-- Top Navigation -->
      <div class="bg-white shadow-md px-6 py-4 flex justify-between items-center sticky top-0 z-10">
        <h1 class="text-xl font-semibold">Student Management</h1>
        <div class="flex items-center space-x-4">

          <div class="flex space-x-4">
            <button onclick="printStudentsList()"
              class="bg-purple-500 text-white px-4 py-2 rounded-lg hover:bg-purple-600">
              <i class="fas fa-print mr-2"></i>Print List
            </button>
            <button onclick="openDeleteGradeModal()"
              class="bg-red-500 text-white px-4 py-2 rounded-lg hover:bg-red-600">
              <i class="fas fa-trash mr-2"></i>Delete by Grade
            </button>
            <button onclick="openImportModal()" class="bg-green-500 text-white px-4 py-2 rounded-lg hover:bg-green-600">
              <i class="fas fa-file-import mr-2"></i>Import Students
            </button>
            <button onclick="openAddModal()" class="bg-blue-500 text-white px-4 py-2 rounded-lg hover:bg-blue-600">
              <i class="fas fa-plus mr-2"></i>Add Student
            </button>
          </div>
          <span class="text-gray-600">Welcome, <?php echo htmlspecialchars($admin_username); ?></span>
          <a href="../auth/logout.php" class="bg-red-500 text-white px-4 py-2 rounded-lg hover:bg-red-600">Logout</a>
        </div>
      </div>

      <!-- Content -->
      <div class="p-6">
        <!-- Search Bar -->
        <div class="flex justify-between items-center mb-6">
          <h2 class="text-2xl font-semibold">Students List</h2>
          <div class="flex space-x-4 items-center">
            <input type="text" id="searchInput" class="border rounded p-2" placeholder="Search students by name..."
              value="<?php echo htmlspecialchars($search_query); ?>">
            <button onclick="openUpdateGradeModal()"
              class="bg-yellow-500 text-white px-4 py-2 rounded-lg hover:bg-yellow-600">
              <i class="fas fa-graduation-cap mr-2"></i>Update Grade
            </button>
          </div>
        </div>

        <!-- Add this div to hold the table content -->
        <div id="studentsTableContent">
          <!-- Students Table -->
          <div class="bg-white rounded-lg shadow-md overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
              <thead class="bg-gray-50">
                <tr>
                  <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Student ID
                  </th>
                  <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Full Name
                  </th>
                  <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Grade</th>
                  <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Email</th>
                  <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Contact
                  </th>
                  <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions
                  </th>
                </tr>
              </thead>
              <tbody class="bg-white divide-y divide-gray-200">
                <?php while($student = $students->fetch_assoc()): ?>
                <tr>
                  <td class="px-6 py-4 whitespace-nowrap"><?php echo htmlspecialchars($student['StudentID']); ?></td>
                  <td class="px-6 py-4 whitespace-nowrap">
                    <?php echo htmlspecialchars($student['FullName'], ENT_QUOTES, 'UTF-8'); ?>
                  </td>
                  <td class="px-6 py-4 whitespace-nowrap"><?php echo htmlspecialchars($student['Grade']); ?></td>
                  <td class="px-6 py-4 whitespace-nowrap"><?php echo htmlspecialchars($student['Email']); ?></td>
                  <td class="px-6 py-4 whitespace-nowrap"><?php echo htmlspecialchars($student['ContactNumber']); ?>
                  </td>
                  <td class="px-6 py-4 whitespace-nowrap">
                    <button onclick="openEditModal('<?php echo $student['StudentID']; ?>')"
                      class="text-blue-600 hover:text-blue-900 mr-3">
                      <i class="fas fa-edit"></i>
                    </button>
                    <button onclick="confirmDelete('<?php echo $student['StudentID']; ?>')"
                      class="text-red-600 hover:text-red-900">
                      <i class="fas fa-trash"></i>
                    </button>
                  </td>
                </tr>
                <?php endwhile; ?>
              </tbody>
            </table>
          </div>

          <!-- Pagination Controls -->
          <div class="flex justify-between mt-6">
            <div>
              <span>Page <?php echo $page; ?> of <?php echo $total_pages; ?></span>
            </div>
            <div>
              <a href="students.php?page=<?php echo max(1, $page - 1); ?>&search=<?php echo urlencode($search_query); ?>"
                class="text-blue-600 hover:text-blue-900">
                Previous
              </a>
              <span class="mx-2">|</span>
              <a href="students.php?page=<?php echo min($total_pages, $page + 1); ?>&search=<?php echo urlencode($search_query); ?>"
                class="text-blue-600 hover:text-blue-900">
                Next
              </a>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>

  <!-- Add Student Modal -->
  <div id="addModal" class="fixed inset-0 bg-gray-600 bg-opacity-50 hidden overflow-y-auto h-full w-full">
    <div class="relative top-20 mx-auto p-5 border w-96 shadow-lg rounded-md bg-white">
      <div class="mt-3">
        <h3 class="text-lg font-medium leading-6 text-gray-900 mb-4">Add New Student</h3>
        <form action="actions/add_student.php" method="POST">
          <div class="mb-4">
            <label class="block text-gray-700 text-sm font-bold mb-2">Student ID</label>
            <input type="text" name="student_id" required
              class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
          </div>
          <div class="mb-4">
            <label class="block text-gray-700 text-sm font-bold mb-2">Full Name</label>
            <input type="text" name="full_name" required
              class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
          </div>
          <div class="mb-4">
            <label class="block text-gray-700 text-sm font-bold mb-2">Grade</label>
            <select name="grade" required
              class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
              <?php for($i = 7; $i <= 12; $i++): ?>
              <option value="Grade <?php echo $i; ?>">Grade <?php echo $i; ?></option>
              <?php endfor; ?>
            </select>
          </div>
          <div class="mb-4">
            <label class="block text-gray-700 text-sm font-bold mb-2">Email</label>
            <input type="email" name="email" required
              class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
          </div>
          <div class="mb-4">
            <label class="block text-gray-700 text-sm font-bold mb-2">Contact Number</label>
            <input type="tel" name="contact_number" required
              class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
          </div>
          <div class="flex justify-end">
            <button type="button" onclick="closeAddModal()"
              class="bg-gray-500 text-white px-4 py-2 rounded mr-2">Cancel</button>
            <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded">Add Student</button>
          </div>
        </form>
      </div>
    </div>
  </div>

  <!-- Edit Student Modal -->
  <div id="editModal" class="fixed inset-0 bg-gray-600 bg-opacity-50 hidden overflow-y-auto h-full w-full">
    <div class="relative top-20 mx-auto p-5 border w-96 shadow-lg rounded-md bg-white">
      <div class="mt-3">
        <h3 class="text-lg font-medium leading-6 text-gray-900 mb-4">Edit Student</h3>
        <form action="actions/edit_student.php" method="POST">
          <input type="hidden" name="original_student_id" id="edit_original_student_id">
          <div class="mb-4">
            <label class="block text-gray-700 text-sm font-bold mb-2">Student ID</label>
            <input type="text" name="student_id" id="edit_student_id" required
              class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
          </div>
          <div class="mb-4">
            <label class="block text-gray-700 text-sm font-bold mb-2">Full Name</label>
            <input type="text" name="full_name" id="edit_full_name" required
              class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
          </div>
          <div class="mb-4">
            <label class="block text-gray-700 text-sm font-bold mb-2">Grade</label>
            <select name="grade" id="edit_grade" required
              class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
              <?php for($i = 7; $i <= 12; $i++): ?>
              <option value="Grade <?php echo $i; ?>">Grade <?php echo $i; ?></option>
              <?php endfor; ?>
            </select>
          </div>
          <div class="mb-4">
            <label class="block text-gray-700 text-sm font-bold mb-2">Email</label>
            <input type="email" name="email" id="edit_email" required
              class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
          </div>
          <div class="mb-4">
            <label class="block text-gray-700 text-sm font-bold mb-2">Contact Number</label>
            <input type="tel" name="contact_number" id="edit_contact_number" required
              class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
          </div>
          <div class="flex justify-end">
            <button type="button" onclick="closeEditModal()"
              class="bg-gray-500 text-white px-4 py-2 rounded mr-2">Cancel</button>
            <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded">Update Student</button>
          </div>
        </form>
      </div>
    </div>
  </div>

  <!-- Import Students Modal -->
  <div id="importModal" class="fixed inset-0 bg-gray-600 bg-opacity-50 hidden overflow-y-auto h-full w-full">
    <div class="relative top-20 mx-auto p-5 border w-96 shadow-lg rounded-md bg-white">
      <div class="mt-3">
        <div class="flex justify-between items-center mb-4">
          <h3 class="text-lg font-medium text-gray-900">Import Students</h3>
          <button onclick="closeImportModal()" class="text-gray-400 hover:text-gray-500">
            <i class="fas fa-times"></i>
          </button>
        </div>
        <form action="actions/import_students.php" method="POST" enctype="multipart/form-data">
          <div class="mb-4">
            <label class="block text-gray-700 text-sm font-bold mb-2">CSV File</label>
            <input type="file" name="file" accept=".csv" required
              class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
          </div>
          <div class="mb-4 text-sm text-gray-600">
            <p>Please ensure your CSV file has the following columns:</p>
            <ul class="list-disc ml-5 mt-2">
              <li>Student ID</li>
              <li>Full Name</li>
              <li>Grade</li>
              <li>Email</li>
              <li>Contact Number</li>
            </ul>
            <a href="../admin/templates/student_template.csv" class="text-blue-600 hover:underline block mt-2">
              Download CSV Template
            </a>
          </div>
          <div class="flex justify-end">
            <button type="button" onclick="closeImportModal()"
              class="bg-gray-500 text-white px-4 py-2 rounded mr-2">Cancel</button>
            <button type="submit" class="bg-green-500 text-white px-4 py-2 rounded">Import</button>
          </div>
        </form>
      </div>
    </div>
  </div>

  <!-- Add this new modal for delete by grade -->
  <div id="deleteGradeModal" class="fixed inset-0 bg-gray-600 bg-opacity-50 hidden overflow-y-auto h-full w-full">
    <div class="relative top-20 mx-auto p-5 border w-96 shadow-lg rounded-md bg-white">
      <div class="mt-3">
        <h3 class="text-lg font-medium leading-6 text-gray-900 mb-4">Delete Students by Grade</h3>
        <p class="text-red-600 mb-4">Warning: This action cannot be undone!</p>
        <form action="actions/delete_by_grade.php" method="POST" onsubmit="return confirmGradeDelete()">
          <div class="mb-4">
            <label class="block text-gray-700 text-sm font-bold mb-2">Select Grade</label>
            <select name="grade" required
              class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
              <option value="">Select Grade</option>
              <?php for($i = 7; $i <= 12; $i++): ?>
              <option value="Grade <?php echo $i; ?>">Grade <?php echo $i; ?></option>
              <?php endfor; ?>
            </select>
          </div>
          <div class="flex justify-end">
            <button type="button" onclick="closeDeleteGradeModal()"
              class="bg-gray-500 text-white px-4 py-2 rounded mr-2">Cancel</button>
            <button type="submit" class="bg-red-500 text-white px-4 py-2 rounded">Delete</button>
          </div>
        </form>
      </div>
    </div>
  </div>

  <!-- Update Grade Modal -->
  <div id="updateGradeModal" class="fixed inset-0 bg-gray-600 bg-opacity-50 hidden overflow-y-auto h-full w-full">
    <div class="relative top-20 mx-auto p-5 border w-96 shadow-lg rounded-md bg-white">
      <div class="mt-3">
        <h3 class="text-lg font-medium leading-6 text-gray-900 mb-4">Update Student Grade</h3>
        <form action="actions/update_grade.php" method="POST" onsubmit="return confirmGradeUpdate()">
          <div class="mb-4">
            <label class="block text-gray-700 text-sm font-bold mb-2">From Grade</label>
            <select name="from_grade" required
              class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
              <option value="">Select Current Grade</option>
              <?php for($i = 7; $i <= 12; $i++): ?>
              <option value="Grade <?php echo $i; ?>">Grade <?php echo $i; ?></option>
              <?php endfor; ?>
            </select>
          </div>
          <div class="mb-4">
            <label class="block text-gray-700 text-sm font-bold mb-2">To Grade</label>
            <select name="to_grade" required
              class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
              <option value="">Select New Grade</option>
              <?php for($i = 7; $i <= 12; $i++): ?>
              <option value="Grade <?php echo $i; ?>">Grade <?php echo $i; ?></option>
              <?php endfor; ?>
            </select>
          </div>
          <div class="flex justify-end">
            <button type="button" onclick="closeUpdateGradeModal()"
              class="bg-gray-500 text-white px-4 py-2 rounded mr-2">Cancel</button>
            <button type="submit" class="bg-yellow-500 text-white px-4 py-2 rounded">Update Grade</button>
          </div>
        </form>
      </div>
    </div>
  </div>

  <!-- Add this hidden print section at the end of the body -->
  <div id="printSection" class="hidden">
    <div class="print-header text-center mb-4">
      <img src="../components/image/logo.png" alt="School Logo" class="mx-auto h-20 mb-2">
      <h1 class="text-xl font-bold">Student Information System</h1>
      <p class="text-sm text-gray-600">Generated on: <?php echo date('F d, Y'); ?></p>
    </div>
    <table class="w-full border-collapse border">
      <thead>
        <tr>
          <th class="border p-2">Student ID</th>
          <th class="border p-2">Full Name</th>
          <th class="border p-2">Grade</th>
          <th class="border p-2">Email</th>
          <th class="border p-2">Contact</th>
        </tr>
      </thead>
      <tbody id="printTableBody">
        <!-- Will be populated by JavaScript -->
      </tbody>
    </table>
  </div>

  <script>
  function openAddModal() {
    document.getElementById('addModal').classList.remove('hidden');
  }

  function closeAddModal() {
    document.getElementById('addModal').classList.add('hidden');
  }

  function confirmDelete(studentId) {
    if (confirm('Are you sure you want to delete this student?')) {
      const form = document.createElement('form');
      form.method = 'POST';
      form.action = 'students.php';

      const input = document.createElement('input');
      input.type = 'hidden';
      input.name = 'delete_student';
      input.value = 'true';

      const studentIdInput = document.createElement('input');
      studentIdInput.type = 'hidden';
      studentIdInput.name = 'student_id';
      studentIdInput.value = studentId;

      form.appendChild(input);
      form.appendChild(studentIdInput);
      document.body.appendChild(form);
      form.submit();
    }
  }

  function openEditModal(studentId) {
    fetch(`actions/get_student.php?student_id=${studentId}`)
      .then(response => response.json())
      .then(student => {
        document.getElementById('edit_original_student_id').value = student.StudentID;
        document.getElementById('edit_student_id').value = student.StudentID;
        document.getElementById('edit_full_name').value = student.FullName;
        document.getElementById('edit_grade').value = student.Grade;
        document.getElementById('edit_email').value = student.Email;
        document.getElementById('edit_contact_number').value = student.ContactNumber;
        document.getElementById('editModal').classList.remove('hidden');
      });
  }

  function closeEditModal() {
    document.getElementById('editModal').classList.add('hidden');
  }

  function openImportModal() {
    document.getElementById('importModal').classList.remove('hidden');
  }

  function closeImportModal() {
    document.getElementById('importModal').classList.add('hidden');
  }

  function openDeleteGradeModal() {
    document.getElementById('deleteGradeModal').classList.remove('hidden');
  }

  function closeDeleteGradeModal() {
    document.getElementById('deleteGradeModal').classList.add('hidden');
  }

  function confirmGradeDelete() {
    const gradeSelect = document.querySelector('#deleteGradeModal select[name="grade"]');
    const selectedGrade = gradeSelect.value;

    if (!selectedGrade) {
      alert('Please select a grade');
      return false;
    }

    return confirm(`Are you sure you want to delete ALL students from ${selectedGrade}? This action cannot be undone!`);
  }

  // Add this new function for real-time search
  let searchTimeout;

  document.getElementById('searchInput').addEventListener('input', function(e) {
    clearTimeout(searchTimeout);

    searchTimeout = setTimeout(() => {
      const searchQuery = e.target.value;
      const currentUrl = new URL(window.location.href);

      // Update search parameter
      if (searchQuery) {
        currentUrl.searchParams.set('search', searchQuery);
      } else {
        currentUrl.searchParams.delete('search');
      }

      // Reset to first page when searching
      currentUrl.searchParams.set('page', '1');

      // Fetch updated results
      fetch(`${currentUrl.pathname}?${currentUrl.searchParams.toString()}`)
        .then(response => response.text())
        .then(html => {
          const parser = new DOMParser();
          const doc = parser.parseFromString(html, 'text/html');
          const newContent = doc.getElementById('studentsTableContent');
          document.getElementById('studentsTableContent').innerHTML = newContent.innerHTML;
        })
        .catch(error => console.error('Error:', error));
    }, 300); // 300ms delay to prevent too many requests
  });

  // Update URL without reloading when using pagination
  document.addEventListener('click', function(e) {
    if (e.target.matches('.pagination-link')) {
      e.preventDefault();
      const url = e.target.href;

      fetch(url)
        .then(response => response.text())
        .then(html => {
          const parser = new DOMParser();
          const doc = parser.parseFromString(html, 'text/html');
          const newContent = doc.getElementById('studentsTableContent');
          document.getElementById('studentsTableContent').innerHTML = newContent.innerHTML;

          // Update URL without page reload
          window.history.pushState({}, '', url);
        })
        .catch(error => console.error('Error:', error));
    }
  });

  function printStudentsList() {
    // Get all student data
    const searchQuery = document.getElementById('searchInput').value;
    const currentUrl = new URL(window.location.href);
    currentUrl.searchParams.set('print', 'true');
    if (searchQuery) {
      currentUrl.searchParams.set('search', searchQuery);
    }

    fetch(`actions/get_all_students.php${currentUrl.search}`)
      .then(response => response.json())
      .then(data => {
        // Populate print table
        const printTableBody = document.getElementById('printTableBody');
        printTableBody.innerHTML = '';

        data.forEach(student => {
          const row = document.createElement('tr');
          row.innerHTML = `
                    <td class="border p-2">${student.StudentID}</td>
                    <td class="border p-2">${student.FullName}</td>
                    <td class="border p-2">${student.Grade}</td>
                    <td class="border p-2">${student.Email}</td>
                    <td class="border p-2">${student.ContactNumber}</td>
                `;
          printTableBody.appendChild(row);
        });

        // Print the document
        const printContent = document.getElementById('printSection').innerHTML;
        const originalContent = document.body.innerHTML;

        document.body.innerHTML = `
                <style>
                    @media print {
                        @page {
                            size: landscape;
                            margin: 1cm;
                        }
                        table {
                            width: 100%;
                            border-collapse: collapse;
                        }
                        th, td {
                            border: 1px solid #000;
                            padding: 8px;
                            text-align: left;
                        }
                        .print-header {
                            text-align: center;
                            margin-bottom: 20px;
                        }
                        .print-header img {
                            height: 80px;
                            margin: 0 auto;
                        }
                    }
                </style>
                ${printContent}
            `;

        window.print();
        document.body.innerHTML = originalContent;

        // Reinitialize event listeners
        initializeEventListeners();
      })
      .catch(error => console.error('Error:', error));
  }

  // Function to reinitialize all event listeners after printing
  function initializeEventListeners() {
    // Reinitialize search functionality
    document.getElementById('searchInput').addEventListener('input', function(e) {
      // ... existing search code ...
    });

    // Reinitialize pagination
    document.addEventListener('click', function(e) {
      // ... existing pagination code ...
    });

    // ... reinitialize other event listeners ...
  }

  function openUpdateGradeModal() {
    document.getElementById('updateGradeModal').classList.remove('hidden');
  }

  function closeUpdateGradeModal() {
    document.getElementById('updateGradeModal').classList.add('hidden');
  }

  function confirmGradeUpdate() {
    const fromGrade = document.querySelector('select[name="from_grade"]').value;
    const toGrade = document.querySelector('select[name="to_grade"]').value;

    if (!fromGrade || !toGrade) {
      alert('Please select both grades');
      return false;
    }

    if (fromGrade === toGrade) {
      alert('Please select different grades');
      return false;
    }

    return confirm(`Are you sure you want to update all students from ${fromGrade} to ${toGrade}?`);
  }
  </script>
</body>

</html>