<?php
session_start();
include '../database/db.php';

if (!isset($_SESSION['user_type']) || $_SESSION['user_type'] !== 'admin') {
    header("Location: ../index.php");
    exit();
}

$admin_username = $_SESSION['admin_username'];

// Get the active election or the most recent completed election
$election_sql = "SELECT id, Status FROM elections WHERE Status IN ('active', 'completed') ORDER BY Status DESC LIMIT 1";
$election_result = $conn->query($election_sql);

if ($election_result->num_rows > 0) {
    $election = $election_result->fetch_assoc();
    $election_id = $election['id']; // Set the election ID
    $election_status = $election['Status']; // Get the election status

 
} else {
    // Handle the case where there are no active or completed elections
    echo "<p>No elections available.</p>";
    exit();
}
// Get statistics
$stats = [
    'total_students' => $conn->query("SELECT COUNT(*) as count FROM students")->fetch_assoc()['count'],
    'total_elections' => $conn->query("SELECT COUNT(*) as count FROM elections")->fetch_assoc()['count'],
    'active_elections' => $conn->query("SELECT COUNT(*) as count FROM elections WHERE status = 'active'")->fetch_assoc()['count'],
    'total_candidates' => $conn->query("SELECT COUNT(*) as count FROM candidates")->fetch_assoc()['count'],
    'total_votes' => $conn->query("SELECT COUNT(*) as count FROM votes")->fetch_assoc()['count']
];

// Get recent elections with participation data
$recent_elections = $conn->query("
    SELECT 
        e.*,
        COUNT(DISTINCT c.id) as candidate_count,
        COUNT(DISTINCT v.id) as vote_count,
        (SELECT COUNT(*) FROM students) as total_students
    FROM elections e
    LEFT JOIN candidates c ON e.id = c.election_id
    LEFT JOIN votes v ON e.id = v.election_id
    GROUP BY e.id
    ORDER BY e.created_at DESC
    LIMIT 5
");

// Get votes per day for the last 7 days
$votes_per_day = $conn->query("
    SELECT 
        DATE(v.created_at) as date,
        COUNT(*) as vote_count
    FROM votes v
    WHERE v.created_at >= DATE_SUB(NOW(), INTERVAL 7 DAY)
    GROUP BY DATE(v.created_at)
    ORDER BY date DESC
");

// Get candidate distribution by position
$position_stats = $conn->query("
    SELECT position, COUNT(*) as count
    FROM candidates
    GROUP BY position
    ORDER BY count DESC
");

// Get partylist statistics
$partylist_stats = $conn->query("
    SELECT 
        COALESCE(partylist_name, 'Independent') as party,
        COUNT(*) as candidate_count,
        COUNT(DISTINCT election_id) as election_count
    FROM candidates
    GROUP BY partylist_name
    ORDER BY candidate_count DESC
");

// Fetch votes per candidate with positions
$votes_per_candidate_sql = "
    SELECT 
        c.student_id, 
        s.FullName AS student_name, 
        c.position,
        COUNT(v.id) AS vote_count
    FROM candidates c
    LEFT JOIN votes v ON c.id = v.candidate_id
    JOIN students s ON c.student_id = s.StudentID
    WHERE c.election_id = '$election_id'
    GROUP BY c.id
    ORDER BY c.position, vote_count DESC
";

$votes_per_candidate_result = $conn->query($votes_per_candidate_sql);

$candidate_labels = [];
$vote_counts = [];
$backgroundColor = [];
$positionColors = [
    'President' => 'rgba(59, 130, 246, 0.8)', // Blue
    'Vice President' => 'rgba(16, 185, 129, 0.8)', // Green
    'Secretary' => 'rgba(245, 158, 11, 0.8)', // Yellow
    'Treasurer' => 'rgba(139, 92, 246, 0.8)', // Purple
    'Auditor' => 'rgba(239, 68, 68, 0.8)', // Red
    'PIO' => 'rgba(236, 72, 153, 0.8)', // Pink
    'Protocol Officer' => 'rgba(14, 165, 233, 0.8)', // Sky Blue
    'Grade 7 Representative' => 'rgba(168, 85, 247, 0.8)', // Purple
    'Grade 8 Representative' => 'rgba(251, 146, 60, 0.8)', // Orange
    'Grade 9 Representative' => 'rgba(34, 197, 94, 0.8)', // Green
    'Grade 10 Representative' => 'rgba(244, 63, 94, 0.8)', // Rose
    'Grade 11 Representative' => 'rgba(45, 212, 191, 0.8)', // Teal
    'Grade 12 Representative' => 'rgba(234, 179, 8, 0.8)', // Yellow
];

while ($row = $votes_per_candidate_result->fetch_assoc()) {
    $candidate_labels[] = $row['student_name'] . ' (' . $row['position'] . ')';
    $vote_counts[] = $row['vote_count'];
    $backgroundColor[] = $positionColors[$row['position']] ?? 'rgba(156, 163, 175, 0.8)'; // Default gray if position not found
}

// Get total students
$total_students_sql = "SELECT COUNT(*) as total FROM students";
$total_students_result = $conn->query($total_students_sql);
$total_students = $total_students_result->fetch_assoc()['total'];

// Get total votes
$total_votes_sql = "SELECT COUNT(DISTINCT student_id) as voted FROM votes";
$total_votes_result = $conn->query($total_votes_sql);
$total_voted = $total_votes_result->fetch_assoc()['voted'];

$not_voted = $total_students - $total_voted;

$vote_data = [
    'Voted' => $total_voted,
    'Not Voted' => $not_voted
];

// Add new query for election participation trends
$election_trends_sql = "
    SELECT 
        e.title,
        e.end_date,
        COUNT(DISTINCT v.student_id) as total_votes,
        (SELECT COUNT(*) FROM students) as eligible_voters
    FROM elections e
    LEFT JOIN votes v ON e.id = v.election_id
    GROUP BY e.id
    ORDER BY e.end_date ASC
    LIMIT 5
";
$election_trends_result = $conn->query($election_trends_sql);

$election_labels = [];
$participation_rates = [];

while ($trend = $election_trends_result->fetch_assoc()) {
    $election_labels[] = $trend['title'];
    $participation_rate = $trend['eligible_voters'] > 0 
        ? round(($trend['total_votes'] / $trend['eligible_voters']) * 100, 1)
        : 0;
    $participation_rates[] = $participation_rate;
}

// Add this query after the existing queries
$candidate_summary_sql = "
    SELECT 
        c.position,
        s.FullName,
        COUNT(v.id) as vote_count,
        c.partylist_name
    FROM candidates c
    LEFT JOIN votes v ON c.id = v.candidate_id
    JOIN students s ON c.student_id = s.StudentID
    WHERE c.election_id = '$election_id'
    GROUP BY c.id
    ORDER BY c.position, vote_count DESC
";
$candidate_summary_result = $conn->query($candidate_summary_sql);

// Organize candidates by position
$positions_summary = [];
while ($row = $candidate_summary_result->fetch_assoc()) {
    if (!isset($positions_summary[$row['position']])) {
        $positions_summary[$row['position']] = [];
    }
    $positions_summary[$row['position']][] = $row;
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Admin Dashboard</title>
  <script src="https://cdn.tailwindcss.com"></script>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
  <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>

<body class="bg-gray-50">
  <div class="flex h-screen">
    <?php include '../components/admin_sidebar.php'; ?>

    <div class="flex-1 overflow-auto">
      <!-- Top Navigation -->
      <div class="bg-white shadow-sm px-6 py-3 flex justify-between items-center sticky top-0 z-10">
        <h1 class="text-2xl font-bold text-gray-800">Dashboard Overview</h1>
        <div class="flex items-center space-x-4">
          <span class="text-gray-600">Welcome, <span
              class="font-semibold"><?php echo htmlspecialchars($admin_username); ?></span></span>
          <a href="../auth/logout.php"
            class="bg-red-500 text-white px-4 py-2 rounded-md hover:bg-red-600 transition duration-150 flex items-center gap-2">
            <i class="fas fa-sign-out-alt"></i>
            Logout
          </a>
        </div>
      </div>

      <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <!-- Statistics Cards -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-5 gap-6 mb-8">
          <div
            class="bg-gradient-to-br from-blue-500 to-blue-600 rounded-xl shadow-lg p-6 text-white transform hover:scale-105 transition duration-200">
            <div class="flex items-center justify-between">
              <div>
                <p class="text-sm font-medium opacity-80">Total Students</p>
                <h3 class="text-3xl font-bold mt-1"><?php echo $stats['total_students']; ?></h3>
              </div>
              <div class="bg-blue-400 bg-opacity-30 p-3 rounded-lg">
                <i class="fas fa-users text-2xl"></i>
              </div>
            </div>
          </div>

          <div
            class="bg-gradient-to-br from-emerald-500 to-emerald-600 rounded-xl shadow-lg p-6 text-white transform hover:scale-105 transition duration-200">
            <div class="flex items-center justify-between">
              <div>
                <p class="text-sm font-medium opacity-80">Active Elections</p>
                <h3 class="text-3xl font-bold mt-1"><?php echo $stats['active_elections']; ?></h3>
              </div>
              <div class="bg-emerald-400 bg-opacity-30 p-3 rounded-lg">
                <i class="fas fa-vote-yea text-2xl"></i>
              </div>
            </div>
          </div>

          <div
            class="bg-gradient-to-br from-amber-500 to-amber-600 rounded-xl shadow-lg p-6 text-white transform hover:scale-105 transition duration-200">
            <div class="flex items-center justify-between">
              <div>
                <p class="text-sm font-medium opacity-80">Total Elections</p>
                <h3 class="text-3xl font-bold mt-1"><?php echo $stats['total_elections']; ?></h3>
              </div>
              <div class="bg-amber-400 bg-opacity-30 p-3 rounded-lg">
                <i class="fas fa-ballot text-2xl"></i>
              </div>
            </div>
          </div>

          <div
            class="bg-gradient-to-br from-violet-500 to-violet-600 rounded-xl shadow-lg p-6 text-white transform hover:scale-105 transition duration-200">
            <div class="flex items-center justify-between">
              <div>
                <p class="text-sm font-medium opacity-80">Total Candidates</p>
                <h3 class="text-3xl font-bold mt-1"><?php echo $stats['total_candidates']; ?></h3>
              </div>
              <div class="bg-violet-400 bg-opacity-30 p-3 rounded-lg">
                <i class="fas fa-user-tie text-2xl"></i>
              </div>
            </div>
          </div>

          <div
            class="bg-gradient-to-br from-rose-500 to-rose-600 rounded-xl shadow-lg p-6 text-white transform hover:scale-105 transition duration-200">
            <div class="flex items-center justify-between">
              <div>
                <p class="text-sm font-medium opacity-80">Total Votes</p>
                <h3 class="text-3xl font-bold mt-1"><?php echo $stats['total_votes']; ?></h3>
              </div>
              <div class="bg-rose-400 bg-opacity-30 p-3 rounded-lg">
                <i class="fas fa-check-circle text-2xl"></i>
              </div>
            </div>
          </div>
        </div>

        <!-- Update the charts layout -->
        <!-- First row for Votes per Candidate -->
        <div class="mb-8">
          <div class="bg-white rounded-xl shadow-lg p-4">
            <h3 class="text-lg font-bold text-gray-800 mb-3">Votes per Candidate</h3>
            <div class="flex">
              <div class="flex-1">
                <canvas id="votesPerCandidateChart"></canvas>
              </div>
              <div id="positionLegend" class="ml-4 flex flex-col justify-center gap-2 min-w-[180px]"></div>
            </div>
          </div>
        </div>

        <!-- Second row for Election Trends and Voting Participation -->
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-8">
          <!-- Election Participation Trends Chart -->
          <div class="bg-white rounded-xl shadow-lg p-4">
            <h3 class="text-lg font-bold text-gray-800 mb-3">Election Participation Trends</h3>
            <div class="h-[300px]">
              <canvas id="electionTrendsChart"></canvas>
            </div>
          </div>

          <!-- Voting Participation Chart -->
          <div class="bg-white rounded-xl shadow-lg p-4">
            <h3 class="text-lg font-bold text-gray-800 mb-3">Voting Participation</h3>
            <div class="h-[300px]">
              <canvas id="votingParticipationChart"></canvas>
            </div>
          </div>
        </div>

        <!-- Move Candidate Vote Summary here -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4 mb-8">
          <?php foreach ($positions_summary as $position => $candidates): ?>
          <div class="bg-white rounded-xl shadow-lg p-4">
            <h3 class="text-sm font-bold text-gray-800 mb-3 pb-2 border-b">
              <?php echo htmlspecialchars($position); ?>
            </h3>
            <div class="space-y-3">
              <?php foreach ($candidates as $index => $candidate): ?>
              <div class="flex items-center justify-between">
                <div class="flex items-center space-x-2">
                  <span class="text-sm font-medium text-gray-700">
                    <?php echo htmlspecialchars($candidate['FullName']); ?>
                  </span>
                  <?php if ($candidate['partylist_name']): ?>
                  <span class="px-2 py-1 text-xs bg-blue-100 text-blue-800 rounded-full">
                    <?php echo htmlspecialchars($candidate['partylist_name']); ?>
                  </span>
                  <?php endif; ?>
                </div>
                <div class="flex items-center space-x-2">
                  <span class="text-sm font-semibold text-gray-900">
                    <?php echo $candidate['vote_count']; ?>
                  </span>
                  <span class="text-xs text-gray-500">votes</span>
                </div>
              </div>
              <?php if ($index < count($candidates) - 1): ?>
              <div class="border-b border-gray-100"></div>
              <?php endif; ?>
              <?php endforeach; ?>
            </div>
          </div>
          <?php endforeach; ?>
        </div>

        <!-- Recent Elections Table at the bottom -->
        <div class="bg-white rounded-xl shadow-lg p-4">
          <h3 class="text-lg font-bold text-gray-800 mb-3">Recent Elections</h3>
          <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
              <thead>
                <tr>
                  <th class="px-6 py-3 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Title
                  </th>
                  <th class="px-6 py-3 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Status
                  </th>
                  <th class="px-6 py-3 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                    Participation</th>
                  <th class="px-6 py-3 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">End
                    Date</th>
                </tr>
              </thead>
              <tbody class="divide-y divide-gray-200">
                <?php while($election = $recent_elections->fetch_assoc()): ?>
                <tr class="hover:bg-gray-50">
                  <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                    <?php echo htmlspecialchars($election['title']); ?>
                  </td>
                  <td class="px-6 py-4 whitespace-nowrap">
                    <span
                      class="px-3 py-1 inline-flex text-xs leading-5 font-semibold rounded-full 
                      <?php echo $election['status'] === 'active' ? 'bg-green-100 text-green-800' : 
                          ($election['status'] === 'completed' ? 'bg-gray-100 text-gray-800' : 'bg-yellow-100 text-yellow-800'); ?>">
                      <?php echo ucfirst($election['status']); ?>
                    </span>
                  </td>
                  <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                    <?php 
                    $participation = $election['total_students'] > 0 
                        ? round(($election['vote_count'] / $election['total_students']) * 100) 
                        : 0;
                    echo $participation . '%';
                    ?>
                  </td>
                  <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                    <?php echo date('M d, Y', strtotime($election['end_date'])); ?>
                  </td>
                </tr>
                <?php endwhile; ?>
              </tbody>
            </table>
          </div>
        </div>
      </div>
    </div>
  </div>

  <script>
  // Update chart configurations
  Chart.defaults.font.family = "'Inter', 'system-ui', '-apple-system', 'sans-serif'";
  Chart.defaults.font.size = 11;
  Chart.defaults.plugins.legend.labels.usePointStyle = true;
  Chart.defaults.plugins.legend.labels.boxWidth = 6;

  // Votes per Candidate Chart
  const ctx = document.getElementById('votesPerCandidateChart').getContext('2d');
  const votesPerCandidateChart = new Chart(ctx, {
    type: 'bar',
    data: {
      labels: <?php echo json_encode($candidate_labels); ?>,
      datasets: [{
        label: 'Votes',
        data: <?php echo json_encode($vote_counts); ?>,
        backgroundColor: <?php echo json_encode($backgroundColor); ?>,
        borderColor: <?php echo json_encode($backgroundColor); ?>,
        borderWidth: 1
      }]
    },
    options: {
      responsive: true,
      maintainAspectRatio: true,
      plugins: {
        legend: {
          display: false
        },
        tooltip: {
          callbacks: {
            label: function(context) {
              return `Votes: ${context.raw}`;
            }
          }
        }
      },
      scales: {
        x: {
          ticks: {
            font: {
              size: 10
            },
            maxRotation: 45,
            minRotation: 45
          }
        },
        y: {
          beginAtZero: true,
          ticks: {
            font: {
              size: 10
            },
            precision: 0
          }
        }
      }
    }
  });

  // Add custom legend with all positions
  const positionLegend = document.getElementById('positionLegend');

  // Define the position order
  const positionOrder = [
    'President',
    'Vice President',
    'Secretary',
    'Treasurer',
    'Auditor',
    'PIO',
    'Protocol Officer',
    'Grade 7 Representative',
    'Grade 8 Representative',
    'Grade 9 Representative',
    'Grade 10 Representative',
    'Grade 11 Representative',
    'Grade 12 Representative'
  ];

  // Create legend items in order
  positionOrder.forEach(position => {
    if (position in <?php echo json_encode($positionColors); ?>) {
      const color = <?php echo json_encode($positionColors); ?>[position];
      const legendItem = document.createElement('div');
      legendItem.className = 'flex items-center gap-2';
      legendItem.innerHTML = `
              <div class="w-3 h-3 rounded-full" style="background-color: ${color}"></div>
              <span class="text-xs text-gray-600">${position}</span>
          `;
      positionLegend.appendChild(legendItem);
    }
  });

  // Voting Participation Chart
  const votingParticipationCtx = document.getElementById('votingParticipationChart').getContext('2d');
  const votingParticipationChart = new Chart(votingParticipationCtx, {
    type: 'pie',
    data: {
      labels: ['Voted', 'Not Voted'],
      datasets: [{
        data: [<?php echo $vote_data['Voted']; ?>, <?php echo $vote_data['Not Voted']; ?>],
        backgroundColor: [
          'rgba(75, 192, 192, 1)', // Color for Voted
          'rgba(255, 99, 132, 1)' // Color for Not Voted
        ],
        borderColor: [
          'rgba(255, 255, 255, 1)',
          'rgba(255, 255, 255, 1)'
        ],
        borderWidth: 1
      }]
    },
    options: {
      responsive: true,
      maintainAspectRatio: true,
      plugins: {
        legend: {
          position: 'right',
          labels: {
            padding: 12,
            font: {
              size: 12
            },
            boxWidth: 15
          }
        }
      }
    }
  });

  // Election Participation Trends Chart
  const trendsCtx = document.getElementById('electionTrendsChart').getContext('2d');
  new Chart(trendsCtx, {
    type: 'line',
    data: {
      labels: <?php echo json_encode($election_labels); ?>,
      datasets: [{
        label: 'Participation Rate (%)',
        data: <?php echo json_encode($participation_rates); ?>,
        fill: true,
        borderColor: 'rgb(59, 130, 246)',
        backgroundColor: 'rgba(59, 130, 246, 0.1)',
        tension: 0.4,
        pointBackgroundColor: 'rgb(59, 130, 246)',
        pointBorderColor: '#fff',
        pointBorderWidth: 2,
        pointRadius: 6,
        pointHoverRadius: 8
      }]
    },
    options: {
      responsive: true,
      maintainAspectRatio: true,
      plugins: {
        legend: {
          display: false
        }
      },
      scales: {
        x: {
          ticks: {
            font: {
              size: 9
            },
            maxRotation: 45,
            minRotation: 45
          }
        },
        y: {
          beginAtZero: true,
          max: 100,
          ticks: {
            font: {
              size: 9
            },
            callback: function(value) {
              return value + '%';
            }
          }
        }
      }
    }
  });
  </script>
</body>

</html>