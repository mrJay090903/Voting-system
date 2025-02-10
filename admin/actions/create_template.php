<?php
// Create CSV template
$headers = ['Student ID', 'Full Name', 'Grade', 'Email', 'Contact Number'];
$sample_data = [
    ['2023-0001', 'John Doe', 'Grade 10', 'john.doe@example.com', '09123456789'],
    ['2023-0002', 'Jane Smith', 'Grade 11', 'jane.smith@example.com', '09987654321']
];

// Create templates directory if it doesn't exist
if (!file_exists('../templates')) {
    mkdir('../templates', 0777, true);
}

$fp = fopen('../templates/student_import_template.csv', 'w');

// Write headers
fputcsv($fp, $headers);

// Write sample data
foreach ($sample_data as $row) {
    fputcsv($fp, $row);
}

fclose($fp);
?> 