<?php
session_start();
include 'database/db.php';
$conn = connect(); // Call the function to establish the connection
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
            WHEN c.position = 'PIO' THEN 6
            WHEN c.position = 'Protocol Officer' THEN 7
            WHEN c.position REGEXP 'Grade [0-9]+ Representative' 
                 AND (
                     ($student_grade < 12 AND CAST(SUBSTRING_INDEX(c.position, ' ', -2) AS UNSIGNED) = $student_grade + 1)
                 ) THEN 8
            ELSE 9
        END AS sort_order
    FROM candidates c
    JOIN students s ON c.student_id = s.StudentID
    JOIN elections e ON c.election_id = e.id
    LEFT JOIN partylists p ON c.partylist_name = p.name
    WHERE e.Status = 'active'
      AND (
          c.position IN (
              'President', 
              'Vice President', 
              'Secretary', 
              'Treasurer', 
              'Auditor', 
              'PIO', 
              'Protocol Officer'
          ) 
          OR (
              c.position REGEXP 'Grade [0-9]+ Representative' 
              AND (
                  ($student_grade < 12 AND CAST(SUBSTRING_INDEX(c.position, ' ', -2) AS UNSIGNED) = $student_grade + 1)
              )
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
    
    // Check if position is a representative position
    $is_representative = strpos($candidate_position, 'Representative') !== false;
    
    // Count the number of votes for the candidate position
    $vote_count_sql = "SELECT COUNT(*) as vote_count FROM votes 
                       WHERE student_id = '$student_id' 
                       AND candidate_position = '$candidate_position'";
    $vote_count_result = $conn->query($vote_count_sql);
    $vote_count = $vote_count_result->fetch_assoc()['vote_count'];

    // Set vote limit based on position type
    $vote_limit = $is_representative ? 2 : 1;

    // Check if the student has already reached the vote limit
    if ($vote_count >= $vote_limit) {
        $error_message = $is_representative ? 
            'You have already voted twice for representatives.' : 
            'You have already voted for this position.';
        echo json_encode(['error' => $error_message]);
        exit();
    }

    // Insert the vote
    $insert_vote_sql = "INSERT INTO votes (election_id, student_id, candidate_id, candidate_position) 
                        VALUES ('$election_id', '$student_id', '$candidate_id', '$candidate_position')";
    if ($conn->query($insert_vote_sql) === TRUE) {
        echo json_encode(['success' => 'Your vote has been cast successfully!']);
    } else {
        error_log("SQL Error: " . $conn->error);
        echo json_encode(['error' => 'Failed to cast your vote. Please try again.']);
    }
    exit();
}

// Add this new section after the existing POST handler
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['submit_all_votes'])) {
    $votes = json_decode($_POST['votes'], true);
    $success = true;
    
    foreach ($votes as $vote) {
        $candidate_id = mysqli_real_escape_string($conn, $vote['candidate_id']);
        $election_id = mysqli_real_escape_string($conn, $vote['election_id']);
        $candidate_position = mysqli_real_escape_string($conn, $vote['position']);
        
        $insert_vote_sql = "INSERT INTO votes (election_id, student_id, candidate_id, candidate_position) 
                           VALUES ('$election_id', '$student_id', '$candidate_id', '$candidate_position')";
        
        if (!$conn->query($insert_vote_sql)) {
            $success = false;
            break;
        }
    }
    
    if ($success) {
        echo json_encode(['success' => true, 'message' => 'All votes submitted successfully!']);
    } else {
        echo json_encode(['error' => 'Failed to submit votes. Please try again.']);
    }
    exit();
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
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
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

  #submitVotesSection {
    box-shadow: 0 -4px 6px -1px rgba(0, 0, 0, 0.1);
  }

  .main-content {
    padding-bottom: 80px;
    /* Add padding to prevent content from being hidden behind the fixed button */
  }

  /* Custom scrollbar for Webkit browsers */
  .overflow-y-auto::-webkit-scrollbar {
    width: 4px;
  }

  .overflow-y-auto::-webkit-scrollbar-track {
    background: #f1f1f1;
    border-radius: 4px;
  }

  .overflow-y-auto::-webkit-scrollbar-thumb {
    background: #888;
    border-radius: 4px;
  }

  .overflow-y-auto::-webkit-scrollbar-thumb:hover {
    background: #555;
  }

  /* For Firefox */
  .overflow-y-auto {
    scrollbar-width: thin;
    scrollbar-color: #888 #f1f1f1;
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

    <div class="relative py-5">
      <div class="absolute inset-0 flex items-center" aria-hidden="true">
        <div class="w-full border-t border-gray-300"></div>
      </div>
      <div class="relative flex justify-center">
        <span class="bg-white px-6 py-3 text-xl font-bold text-blue-600 rounded-full shadow-md border border-gray-200">
          <i class="fas 
                    <?php
                        switch($candidate['position']) {
                            case 'President':
                                echo 'fa-star';
                                break;
                            case 'Vice President':
                                echo 'fa-user-tie';
                                break;
                            case 'Secretary':
                                echo 'fa-pen';
                                break;
                            case 'Treasurer':
                                echo 'fa-coins';
                                break;
                            case 'Auditor':
                                echo 'fa-calculator';
                                break;
                            case 'PIO':
                                echo 'fa-bullhorn';
                                break;
                            case 'Protocol Officer':
                                echo 'fa-clipboard-list';
                                break;
                            default:
                                echo 'fa-users';
                        }
                    ?> mr-2">
          </i>
          <?php echo htmlspecialchars($candidate['position']); ?>
        </span>
      </div>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 mt-6">
      <?php
    $current_position = $candidate['position'];
endif; ?>

      <!-- Candidate Card -->
      <div class="bg-white rounded-lg shadow-md overflow-hidden w-full max-w-sm mx-auto h-[800px] flex flex-col">
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

        <!-- Content section with adjusted heights -->
        <div class="flex flex-col h-[calc(100%-3rem)]">
          <!-- Subtract partylist header height -->
          <!-- Top section with fixed heights -->
          <div class="p-4">
            <!-- Picture section - fixed height -->
            <div class="h-64 mb-4 flex-shrink-0">
              <?php if ($candidate['image_url']): ?>
              <div class="relative w-full h-full rounded-lg overflow-hidden">
                <img src="<?php echo htmlspecialchars($candidate['image_url']); ?>"
                  class="absolute inset-0 w-full h-full object-contain bg-gray-50"
                  alt="<?php echo htmlspecialchars($candidate['student_name']); ?>">
              </div>
              <?php else: ?>
              <div class="relative w-full h-full bg-gray-200 rounded-lg flex items-center justify-center">
                <i class="fas fa-user-circle text-gray-400 text-6xl"></i>
              </div>
              <?php endif; ?>
            </div>

            <!-- Candidate Name - fixed height -->
            <div class="text-center mb-4 pb-4 border-b flex-shrink-0">
              <h3 class="text-xl font-bold text-gray-800">
                <?php echo htmlspecialchars($candidate['student_name']); ?>
              </h3>
              <p class="text-sm text-gray-600 mt-2">
                <?php echo htmlspecialchars($candidate['student_grade']); ?>
              </p>
            </div>
          </div>

          <!-- Scrollable content with calculated height -->
          <div class="flex-1 overflow-y-auto px-4">
            <div class="space-y-4">
              <!-- Platform -->
              <div>
                <h4 class="font-semibold text-gray-700 mb-2 sticky top-0 bg-white py-1">Platform:</h4>
                <div class="text-gray-600 text-sm pr-2">
                  <?php echo htmlspecialchars($candidate['platform']); ?>
                </div>
              </div>

              <!-- Vision -->
              <div>
                <h4 class="font-semibold text-gray-700 mb-2 sticky top-0 bg-white py-1">Vision:</h4>
                <div class="text-gray-600 text-sm pr-2">
                  <?php echo htmlspecialchars($candidate['vision']); ?>
                </div>
              </div>

              <!-- Mission -->
              <div>
                <h4 class="font-semibold text-gray-700 mb-2 sticky top-0 bg-white py-1">Mission:</h4>
                <div class="text-gray-600 text-sm pr-2">
                  <?php echo htmlspecialchars($candidate['mission']); ?>
                </div>
              </div>
            </div>
          </div>

          <!-- Vote Button - fixed at bottom -->
          <div class="mt-auto p-4 bg-gray-50 border-t">
            <button type="button"
              class="select-candidate-btn w-full bg-blue-600 text-white py-2 rounded-lg hover:bg-blue-700 transition-colors"
              data-candidate-id="<?php echo htmlspecialchars($candidate['id']); ?>"
              data-election-id="<?php echo htmlspecialchars($candidate['election_id']); ?>"
              data-candidate-position="<?php echo htmlspecialchars($candidate['position']); ?>"
              data-candidate-name="<?php echo htmlspecialchars($candidate['student_name']); ?>">
              Select Candidate
            </button>
          </div>
        </div>
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
  <div id="profileModal" class="fixed inset-0 bg-gray-600 bg-opacity-50 hidden overflow-y-auto h-full w-full z-[100]">
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
    let selectedVotes = {};

    $('#castVoteCard').on('click', function() {
      var $this = $(this);
      $this.fadeOut(300, function() {
        $('#candidatesSection').toggleClass('hidden');
        $('#submitVotesSection').show();
      });
    });

    // Handle candidate selection
    $('.select-candidate-btn').on('click', function() {
      const btn = $(this);
      const position = btn.data('candidate-position');
      const candidateId = btn.data('candidate-id');
      const electionId = btn.data('election-id');
      const candidateName = btn.data('candidate-name');

      // Check if this is a representative position
      const isRepresentative = position.includes('Representative');

      // For representatives, allow up to 2 selections
      if (isRepresentative) {
        const currentPositionVotes = Object.values(selectedVotes).filter(v => v.position === position).length;
        if (currentPositionVotes >= 2 && !selectedVotes[candidateId]) {
          new Noty({
            type: 'error',
            layout: 'topCenter',
            theme: 'metroui',
            text: 'You can only select up to 2 representatives',
            timeout: 3000
          }).show();
          return;
        }
      } else if (Object.values(selectedVotes).some(v => v.position === position && v.candidate_id !==
          candidateId)) {
        // For other positions, only allow one selection
        new Noty({
          type: 'error',
          layout: 'topCenter',
          theme: 'metroui',
          text: 'You have already selected a candidate for this position',
          timeout: 3000
        }).show();
        return;
      }

      // Toggle selection
      if (selectedVotes[candidateId]) {
        delete selectedVotes[candidateId];
        btn.removeClass('bg-green-600').addClass('bg-blue-600');
        btn.text('Select Candidate');
      } else {
        selectedVotes[candidateId] = {
          candidate_id: candidateId,
          election_id: electionId,
          position: position,
          name: candidateName
        };
        btn.removeClass('bg-blue-600').addClass('bg-green-600');
        btn.text('Selected');
      }

      // Update selected count
      $('#selectedCount').text(Object.keys(selectedVotes).length);
    });

    // Handle final submission
    $('#submitVotesBtn').on('click', function() {
      if (Object.keys(selectedVotes).length === 0) {
        new Noty({
          type: 'error',
          layout: 'topCenter',
          theme: 'metroui',
          text: 'Please select at least one candidate before submitting',
          timeout: 3000
        }).show();
        return;
      }

      Swal.fire({
        title: 'Submit Votes?',
        text: 'Are you sure you want to submit your votes? This action cannot be undone.',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Yes, submit votes!'
      }).then((result) => {
        if (result.isConfirmed) {
          $.ajax({
            type: 'POST',
            url: 'dashboard.php',
            data: {
              submit_all_votes: true,
              votes: JSON.stringify(Object.values(selectedVotes))
            },
            success: function(response) {
              const result = JSON.parse(response);
              if (result.success) {
                Swal.fire({
                  title: 'Success!',
                  text: 'Your votes have been submitted successfully!',
                  icon: 'success',
                  confirmButtonColor: '#3085d6',
                  confirmButtonText: 'OK',
                  timer: 2000, // Auto close after 2 seconds
                  timerProgressBar: true,
                  showConfirmButton: false
                }).then(() => {
                  window.location.href = 'auth/logout.php';
                });
              } else {
                Swal.fire({
                  title: 'Error!',
                  text: result.error || 'Failed to submit votes',
                  icon: 'error',
                  confirmButtonColor: '#3085d6'
                });
              }
            },
            error: function() {
              Swal.fire({
                title: 'Error!',
                text: 'Failed to submit votes. Please try again.',
                icon: 'error',
                confirmButtonColor: '#3085d6'
              });
            }
          });
        }
      });
    });
  });
  </script>

  <!-- Add this before the closing div of candidatesSection -->
  <div class="fixed bottom-0 left-0 right-0 bg-white shadow-lg p-4 border-t z-[40]" id="submitVotesSection"
    style="display: none;">
    <div class="container mx-auto flex justify-between items-center">
      <div class="text-lg font-semibold">Selected Candidates: <span id="selectedCount">0</span></div>
      <button id="submitVotesBtn"
        class="bg-green-600 text-white px-6 py-2 rounded-lg hover:bg-green-700 transition-colors">
        Submit All Votes
      </button>
    </div>
  </div>
</body>

</html>