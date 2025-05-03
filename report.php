<?php
session_start();
require 'includes/db.php';
require 'vendor/autoload.php'; // for FPDF via Composer

if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    header("Location: login.php");
    exit;
}


$reportMessage = "";

// Generate today's report
if (isset($_POST['generate'])) {
    $today = date('Y-m-d');

    $stmt = $pdo->prepare("SELECT 
        COUNT(*) as total_orders,
        SUM(pickup_or_delivery = 'delivery') as total_deliveries
        FROM orderss
        WHERE order_date = ?");
    $stmt->execute([$today]);
    $data = $stmt->fetch();

    $check = $pdo->prepare("SELECT id FROM daily_reports WHERE report_date = ?");
    $check->execute([$today]);

    if ($check->rowCount() == 0) {
        $save = $pdo->prepare("INSERT INTO daily_reports (report_date, total_orders, total_deliveries) VALUES (?, ?, ?)");
        $save->execute([$today, $data['total_orders'], $data['total_deliveries']]);
        $reportMessage = "✅ Report for today has been generated.";
    } else {
        $reportMessage = "⚠️ Report for today already exists.";
    }
}

// PDF Export
if (isset($_POST['export_pdf'])) {
    $pdf = new \FPDF();
    $pdf->AddPage();
    $pdf->SetFont('Arial', 'B', 14);
    $pdf->Cell(190, 10, 'Sarah\'s Short Cakes - Daily Reports', 0, 1, 'C');
    $pdf->Ln(4);

    $pdf->SetFont('Arial', 'B', 10);
    $pdf->Cell(40, 10, 'Date', 1);
    $pdf->Cell(40, 10, 'Total Orders', 1);
    $pdf->Cell(40, 10, 'Deliveries', 1);
    $pdf->Cell(70, 10, 'Generated At', 1);
    $pdf->Ln();

    $stmt = $pdo->query("SELECT * FROM daily_reports ORDER BY report_date DESC");
    while ($row = $stmt->fetch()) {
        $pdf->SetFont('Arial', '', 10);
        $pdf->Cell(40, 10, $row['report_date'], 1);
        $pdf->Cell(40, 10, $row['total_orders'], 1);
        $pdf->Cell(40, 10, $row['total_deliveries'], 1);
        $pdf->Cell(70, 10, $row['generated_at'], 1);
        $pdf->Ln();
    }

    $pdf->Output('D', 'daily_reports.pdf');
    exit;
}

// Fetch all previous reports
$reports = $pdo->query("SELECT * FROM daily_reports ORDER BY report_date DESC")->fetchAll();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Daily Reports</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100">
    <div class="p-6">
        <h2 class="text-2xl font-bold text-pink-600 mb-4">Daily Order Reports</h2>

        <?php if ($reportMessage): ?>
            <div class="mb-4 px-4 py-2 rounded text-white <?= str_contains($reportMessage, '✅') ? 'bg-green-500' : 'bg-yellow-500' ?>">
                <?= $reportMessage ?>
            </div>
        <?php endif; ?>

        <form method="POST" class="mb-6 flex flex-wrap gap-4">
            <button name="generate" class="bg-pink-600 text-white px-6 py-2 rounded hover:bg-pink-700 transition">
                Generate Today’s Report
            </button>
            <button name="export_pdf" class="bg-blue-600 text-white px-6 py-2 rounded hover:bg-blue-700 transition">
                Export PDF
            </button>
        </form>

        <table class="min-w-full bg-white shadow-md rounded-xl overflow-hidden">
            <thead class="bg-pink-100 text-pink-800">
                <tr>
                    <th class="px-4 py-2 text-left">Date</th>
                    <th class="px-4 py-2 text-left">Total Orders</th>
                    <th class="px-4 py-2 text-left">Deliveries</th>
                    <th class="px-4 py-2 text-left">Generated At</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($reports as $report): ?>
                    <tr class="border-b hover:bg-gray-50">
                        <td class="px-4 py-3"><?= $report['report_date'] ?></td>
                        <td class="px-4 py-3"><?= $report['total_orders'] ?></td>
                        <td class="px-4 py-3"><?= $report['total_deliveries'] ?></td>
                        <td class="px-4 py-3 text-sm text-gray-600"><?= $report['generated_at'] ?></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</body>
</html>
