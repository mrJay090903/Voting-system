<?php
session_start();
include 'database/db.php';

// Check if user is logged in as student
if (!isset($_SESSION['user_type']) || $_SESSION['user_type'] !== 'student') {
    header("Location: index.php");
    exit();
}

$student_id = $_SESSION['student_id'];

// Get student information
$student_sql = "SELECT * FROM students WHERE StudentID = '$student_id'";
$student_result = $conn->query($student_sql);
$student = $student_result->fetch_assoc();

// Get active elections
$elections_sql = "SELECT Title FROM elections WHERE Status = 'active'";
$elections_result = $conn->query($elections_sql);

$student_grade = (int) filter_var($student['Grade'], FILTER_SANITIZE_NUMBER_INT); // Extract numeric grade

$candidates_sql = "
    SELECT 
        c.*, 
        s.FullName as student_name,
        s.Grade as student_grade,
        e.Title as election_title,
        p.name as partylist_name,
        p.logo_url as partylist_logo,
        CASE 
            WHEN c.position = 'President' THEN 1
            WHEN c.position = 'Vice President' THEN 2
            WHEN c.position = 'Secretary' THEN 3
            WHEN c.position = 'Treasurer' THEN 4
            WHEN c.position = 'Auditor' THEN 5
            WHEN c.position = 'Public Information Officer (PIO)' THEN 6
            WHEN c.position = 'Protocol Officer (PO)' THEN 7
            WHEN c.position REGEXP 'Grade [0-9]+ Representative' 
                 AND CAST(SUBSTRING_INDEX(c.position, ' ', -2) AS UNSIGNED) = $student_grade THEN 8
            ELSE 9
        END AS sort_order
    FROM candidates c
    JOIN students s ON c.student_id = s.StudentID
    JOIN elections e ON c.election_id = e.id
    LEFT JOIN partylists p ON c.partylist_name = p.name
    WHERE e.Status = 'active'
      AND (
          c.position IN ('President', 'Vice President', 'Secretary', 'Treasurer', 'Auditor', 
                         'Public Information Officer (PIO)', 'Protocol Officer (PO)') 
          OR (
              c.position REGEXP 'Grade [0-9]+ Representative' 
              AND CAST(SUBSTRING_INDEX(c.position, ' ', -2) AS UNSIGNED) = $student_grade
          )
      )
    ORDER BY sort_order, e.Title, c.position
";



// Execute the query
$candidates_result = $conn->query($candidates_sql);

// Check for errors in the query execution
if (!$candidates_result) {
    die("Query failed: " . $conn->error);
}


// Fetch the votes to check which candidates the student has voted for
$voted_candidates_sql = "SELECT candidate_id, candidate_position FROM votes WHERE student_id = '$student_id'";
$voted_candidates_result = $conn->query($voted_candidates_sql);
$voted_candidates = [];
while ($row = $voted_candidates_result->fetch_assoc()) {
    $voted_candidates[$row['candidate_position']] = $row['candidate_id'];
}

// Handle voting
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['vote'])) {
    $candidate_id = mysqli_real_escape_string($conn, $_POST['candidate_id']);
    $election_id = mysqli_real_escape_string($conn, $_POST['election_id']);
    $candidate_position = mysqli_real_escape_string($conn, $_POST['candidate_position']);
    
    // Count the number of votes for the candidate position
    $vote_count_sql = "SELECT COUNT(*) as vote_count FROM votes WHERE student_id = '$student_id' AND candidate_position = '$candidate_position'";
    $vote_count_result = $conn->query($vote_count_sql);
    $vote_count = $vote_count_result->fetch_assoc()['vote_count'];

    // Check if the student has already voted two times for the same position
    if ($vote_count >= 2) {
        // If the limit is reached, show an error
        echo json_encode(['error' => 'You have already voted three times for this position.']);
        exit();
    }

    // Insert the vote
    $insert_vote_sql = "INSERT INTO votes (election_id, student_id, candidate_id, candidate_position) 
                        VALUES ('$election_id', '$student_id', '$candidate_id', '$candidate_position')";
    if ($conn->query($insert_vote_sql) === TRUE) {
        // Successfully cast the vote
        echo json_encode(['success' => 'Your vote has been cast successfully!']);
        exit();
    } else {
        // Error casting the vote
        error_log("SQL Error: " . $conn->error); // Log the SQL error for debugging
        echo json_encode(['error' => 'Failed to cast your vote. Please try again.']);
        exit();
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Student Dashboard - SSLG Voting</title>
  <link rel="icon" href="components/image/logo.png" type="image/png">
  <script src="https://cdn.tailwindcss.com"></script>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/noty/3.1.4/noty.min.css">
  <script src="https://cdnjs.cloudflare.com/ajax/libs/noty/3.1.4/noty.min.js"></script>
  <style>
  @keyframes gradientAnimation {
    0% {
      background-position: 0% 50%;
    }

    50% {
      background-position: 100% 50%;
    }

    100% {
      background-position: 0% 50%;
    }
  }

  .gradient-bg {
    background: linear-gradient(270deg, #1E3A8A, #3B82F6);
    background-size: 400% 400%;
    animation: gradientAnimation 15s ease infinite;
  }

  .main-content {
    position: relative;
    min-height: calc(100vh - 80px);
    padding: 20px;
    color: black;
  }

  .main-content::before {
    content: "";
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background-image: url('components/image/logo.png');
    background-size: 40%;
    background-position: center;
    background-repeat: no-repeat;
    background-attachment: fixed;
    opacity: 0.5;
    z-index: 0;
  }

  .main-content>* {
    position: relative;
    z-index: 1;
  }
  </style>
</head>

<body class="bg-gray-100">
  <div class="min-h-screen">
    <!-- Navigation -->
    <nav class="gradient-bg text-white px-6 py-4 fixed top-0 left-0 w-full z-50 shadow-lg">
      <div class="container mx-auto flex justify-between items-center">
        <div class="flex items-center space-x-4">
          <img src="components/image/logo.png" alt="Logo" class="h-10 w-10">
          <div class="text-2xl font-bold">
            Supreme Secondary Learner Government Voting System
          </div>
        </div>
        <div class="flex items-center space-x-4">
          <span>Welcome, <?php echo htmlspecialchars($student['FullName']); ?></span>
          <button onclick="openProfileModal()" class="text-white hover:text-blue-200">
            <i class="fas fa-user-circle text-2xl"></i>
          </button>
          <a href="auth/logout.php" class="bg-red-500 text-white px-4 py-2 rounded-lg hover:bg-red-600">Logout</a>
        </div>
      </div>
    </nav>
    <div class="pt-20"></div>

    <!-- Main Content -->
    <div class="container mx-auto main-content px-6 py-8">
      <!-- Cast Your Vote Card -->
      <div
        class="bg-white rounded-lg shadow-md p-6 mb-8 cursor-pointer border border-blue-600 hover:shadow-lg transition-shadow duration-300"
        id="castVoteCard">
        <div class="flex items-center">
          <i class="fas fa-vote-yea text-blue-600 text-3xl mr-4"></i>
          <div>
            <h2 class="text-2xl font-bold text-blue-600">Cast Your Vote</h2>
            <p class="mt-2 text-gray-700">Click here to view the candidates and cast your vote.</p>
          </div>
        </div>
      </div>

      <!-- Candidates Section -->
      <div id="candidatesSection" class="hidden">
        <?php
        $current_election = '';
        $current_position = '';
        ?>

        <?php while ($candidate = $candidates_result->fetch_assoc()): ?>
        <?php if ($current_election !== $candidate['election_title']): ?>
        <?php if ($current_election !== ''): ?>
      </div> <!-- Close previous position grid -->
    </div> <!-- Close previous election section -->
    <?php endif; ?>

    <div class="mb-8">

      <?php
                $current_election = $candidate['election_title'];
                $current_position = '';
            endif; ?>

      <?php if ($current_position !== $candidate['position']): ?>
      <?php if ($current_position !== ''): ?>
    </div> <!-- Close previous position grid -->
    <?php endif; ?>

    <h3 class="text-xl font-semibold mb-4 mt-6"><?php echo htmlspecialchars($candidate['position']); ?></h3>
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
      <?php
                    $current_position = $candidate['position'];
                endif; ?>

      <!-- Candidate Card -->
      <div class="bg-white rounded-lg shadow-md overflow-hidden w-full max-w-sm mx-auto">
        <!-- Partylist Name -->
        <?php if ($candidate['partylist_name']): ?>
        <div class="bg-gradient-to-r from-purple-500 to-indigo-500 text-center py-2 rounded-t-lg">
          <span class="text-sm font-semibold text-white tracking-wider">
            <?php echo htmlspecialchars($candidate['partylist_name']); ?>
          </span>
        </div>
        <?php else: ?>
        <div class="bg-gray-400 text-center py-2 rounded-t-lg">
          <span class="text-sm font-semibold text-white tracking-wider">
            Independent
          </span>
        </div>
        <?php endif; ?>

        <!-- Candidate Picture -->
        <div class="p-8">
          <?php if ($candidate['image_url']): ?>
          <img src="<?php echo htmlspecialchars($candidate['image_url']); ?>"
            class="w-full h-48 object-cover rounded-lg mb-6"
            alt="<?php echo htmlspecialchars($candidate['student_name'] ?: 'Candidate'); ?>">
          <?php else: ?>
          <div class="w-full h-48 bg-gray-200 flex items-center justify-center rounded-lg mb-6">
            <span class="text-gray-400 text-lg">Candidate picture</span>
          </div>
          <?php endif; ?>

          <!-- Candidate Name -->
          <div class="text-center mb-8 border-b pb-6">
            <h3 class="text-xl font-bold text-gray-800"><?php echo htmlspecialchars($candidate['student_name']); ?></h3>
            <p class="text-sm text-gray-600 mt-2"><?php echo htmlspecialchars($candidate['student_grade']); ?></p>
          </div>

          <!-- Candidate Details -->
          <div class="space-y-6">
            <div>
              <h4 class="font-semibold text-gray-700 mb-3">Platform:</h4>
              <p class="text-gray-600"><?php echo htmlspecialchars($candidate['platform']); ?></p>
            </div>
            <div>
              <h4 class="font-semibold text-gray-700 mb-3">Vision:</h4>
              <p class="text-gray-600"><?php echo htmlspecialchars($candidate['vision']); ?></p>
            </div>
            <div>
              <h4 class="font-semibold text-gray-700 mb-3">Mission:</h4>
              <p class="text-gray-600"><?php echo htmlspecialchars($candidate['mission']); ?></p>
            </div>
          </div>
        </div>

        <!-- Vote Button Form -->
        <form class="vote-form" data-candidate-id="<?php echo htmlspecialchars($candidate['id']); ?>"
          data-election-id="<?php echo htmlspecialchars($candidate['election_id']); ?>"
          data-candidate-position="<?php echo htmlspecialchars($candidate['position']); ?>">
          <input type="hidden" name="candidate_id" value="<?php echo htmlspecialchars($candidate['id']); ?>">
          <input type="hidden" name="election_id" value="<?php echo htmlspecialchars($candidate['election_id']); ?>">
          <input type="hidden" name="candidate_position"
            value="<?php echo htmlspecialchars($candidate['position']); ?>">

          <?php if (in_array($candidate['id'], $voted_candidates)): ?>
          <button type="button" class="w-full bg-gray-400 text-white py-2 rounded-lg" disabled>
            Voted
          </button>
          <?php else: ?>
          <button type="submit"
            class="w-full bg-blue-600 text-white py-2 rounded-lg hover:bg-blue-700 transition-colors">
            Vote
          </button>
          <?php endif; ?>
        </form>
      </div>

      <?php endwhile; ?>
      <?php if ($current_election !== ''): ?>
    </div> <!-- Close last position grid -->
  </div> <!-- Close last election section -->
  <?php endif; ?>
  </div>
  </div> <!-- End of candidates section -->
  </div>

  <!-- Profile Modal -->
  <div id="profileModal" class="fixed inset-0 bg-gray-600 bg-opacity-50 hidden overflow-y-auto h-full w-full">
    <div class="relative top-20 mx-auto p-5 border w-96 shadow-lg rounded-md bg-white">
      <div class="mt-3">
        <div class="flex justify-between items-center mb-4">
          <h3 class="text-lg font-medium text-gray-900">Student Profile</h3>
          <button onclick="closeProfileModal()" class="text-gray-400 hover:text-gray-500">
            <i class="fas fa-times"></i>
          </button>
        </div>
        <div class="space-y-4">
          <div class="text-center mb-4">
            <i class="fas fa-user-circle text-6xl text-gray-400"></i>
          </div>
          <div>
            <p class="text-sm text-gray-600">Student ID</p>
            <p class="font-medium"><?php echo htmlspecialchars($student['StudentID']); ?></p>
          </div>
          <div>
            <p class="text-sm text-gray-600">Full Name</p>
            <p class="font-medium"><?php echo htmlspecialchars($student['FullName']); ?></p>
          </div>
          <div>
            <p class="text-sm text-gray-600">Grade</p>
            <p class="font-medium"><?php echo htmlspecialchars($student['Grade']); ?></p>
          </div>
          <div>
            <p class="text-sm text-gray-600">Email</p>
            <p class="font-medium"><?php echo htmlspecialchars($student['Email']); ?></p>
          </div>
          <div>
            <p class="text-sm text-gray-600">Contact Number</p>
            <p class="font-medium"><?php echo htmlspecialchars($student['ContactNumber']); ?></p>
          </div>
        </div>
      </div>
    </div>
  </div>

  </div>

  <script>
  function openProfileModal() {
    document.getElementById('profileModal').classList.remove('hidden');
  }

  function closeProfileModal() {
    document.getElementById('profileModal').classList.add('hidden');
  }

  $(document).ready(function() {
    $('#castVoteCard').on('click', function() {
      var $this = $(this);
      $this.fadeOut(300, function() {
        $('#candidatesSection').toggleClass('hidden');
      });
    });

    // AJAX voting functionality
    $('.vote-form').on('submit', function(e) {
      e.preventDefault(); // Prevent the default form submission

      var form = $(this);
      var candidateId = form.data('candidate-id');
      var electionId = form.data('election-id');
      var candidatePosition = form.data('candidate-position');

      $.ajax({
        type: 'POST',
        url: 'dashboard.php',
        data: {
          vote: true,
          candidate_id: candidateId,
          election_id: electionId,
          candidate_position: candidatePosition
        },
        success: function(response) {
          var result = JSON.parse(response);
          if (result.error) {
            // Show error message using Noty
            new Noty({
              type: 'error',
              layout: 'topCenter',
              theme: 'metroui',
              text: result.error,
              timeout: 3000
            }).show();
          } else {
            // Update the UI to show "Voted"
            form.find('button').replaceWith(
              '<button type="button" class="w-full bg-gray-400 text-white py-2 rounded-lg" disabled>Voted</button>'
            );
            // Show success message using Noty
            new Noty({
              type: 'success',
              theme: 'metroui',
              layout: 'topCenter',
              text: result.success,
              timeout: 3000
            }).show();
          }
        },
        error: function() {
          new Noty({
            type: 'error',
            layout: 'topCenter',
            theme: 'metroui',
            text: "Failed to cast your vote. Please try again.",
            timeout: 3000
          }).show();
        }
      });
    });
  });
  </script>
</body>

</html>