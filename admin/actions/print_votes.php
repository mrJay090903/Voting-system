<?php
session_start();
include '../../database/db.php';

if (!isset($_SESSION['user_type']) || $_SESSION['user_type'] !== 'admin') {
    header("Location: ../../index.php");
    exit();
}

// Get all votes with student and candidate details
$votes_sql = "
    SELECT 
        s.StudentID,
        s.FullName as student_name,
        s.Grade as student_grade,
        c.position,
        cs.FullName as candidate_name,
        p.name as partylist_name,
        e.title as election_title
    FROM votes v
    JOIN students s ON v.student_id = s.StudentID
    JOIN candidates c ON v.candidate_id = c.id
    JOIN students cs ON c.student_id = cs.StudentID
    JOIN elections e ON v.election_id = e.id
    LEFT JOIN partylists p ON c.partylist_name = p.name
    ORDER BY 
        s.Grade,
        s.FullName,
        CASE 
            WHEN c.position = 'President' THEN 1
            WHEN c.position = 'Vice President' THEN 2
            WHEN c.position = 'Secretary' THEN 3
            WHEN c.position = 'Treasurer' THEN 4
            WHEN c.position = 'Auditor' THEN 5
            WHEN c.position = 'PIO' THEN 6
            WHEN c.position = 'Protocol Officer' THEN 7
            ELSE 8
        END,
        c.position
";

$votes_result = $conn->query($votes_sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Student Votes Report</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body class="bg-gray-100">
    <div class="container mx-auto px-4 py-8">
        <div class="bg-white rounded-lg shadow-lg p-6">
            <div class="flex justify-between items-center mb-6">
                <h1 class="text-2xl font-bold text-gray-800">Student Votes Report</h1>
                <button onclick="window.print()" class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600">
                    <i class="fas fa-print mr-2"></i>Print Report
                </button>
            </div>
            
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Student ID</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Student Name</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Grade</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Position</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Voted Candidate</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Partylist</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Election</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        <?php 
                        $current_student = '';
                        while ($row = $votes_result->fetch_assoc()): 
                            $row_class = $current_student === $row['StudentID'] ? '' : 'border-t-2 border-gray-300';
                            $current_student = $row['StudentID'];
                        ?>
                            <tr class="<?php echo $row_class; ?> hover:bg-gray-50">
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                    <?php echo htmlspecialchars($row['StudentID']); ?>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                    <?php echo htmlspecialchars($row['student_name']); ?>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                    <?php echo htmlspecialchars($row['student_grade']); ?>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                    <?php echo htmlspecialchars($row['position']); ?>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                    <?php echo htmlspecialchars($row['candidate_name']); ?>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                    <?php echo htmlspecialchars($row['partylist_name'] ?? 'Independent'); ?>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                    <?php echo htmlspecialchars($row['election_title']); ?>
                                </td>
                            </tr>
                        <?php endwhile; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <style>
        @media print {
            body * {
                visibility: hidden;
            }
            .container, .container * {
                visibility: visible;
            }
            button {
                display: none;
            }
            .container {
                position: absolute;
                left: 0;
                top: 0;
            }
        }
    </style>
</body>
</html> 