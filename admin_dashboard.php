<?php
require_once 'config.php';

// التحقق من تسجيل دخول المشرف
if (!isAdmin()) {
    header('Location: admin_login.php');
    exit;
}

// تنفيذ عملية تصدير البيانات إلى ملف Excel
if (isset($_POST['export_excel'])) {
    header('Content-Type: text/csv; charset=utf-8');
    header('Content-Disposition: attachment; filename=students_data.csv');
    
    $output = fopen('php://output', 'w');
    fprintf($output, chr(0xEF).chr(0xBB).chr(0xBF)); // BOM for UTF-8
    
    // عناوين الأعمدة
    fputcsv($output, [
        'رقم الجلوس', 'الاسم', 'الرقم القومي', 'رقم الهاتف', 'النوع', 'السن',
        'محل الإقامة', 'المؤهل', 'نوع التعليم', 'المرحلة الحالية', 'التخصص'
    ]);
    
    $stmt = $pdo->query("SELECT * FROM students ORDER BY created_at DESC");
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        fputcsv($output, [
            $row['seat_number'],
            $row['full_name'],
            $row['national_id'],
            $row['phone_number'],
            $row['gender'],
            $row['age'],
            $row['residence'],
            $row['qualification'],
            $row['education_type'],
            $row['current_stage'],
            $row['specialization']
        ]);
    }
    
    fclose($output);
    exit;
}

// جلب بيانات الطلاب
$stmt = $pdo->query("SELECT * FROM students ORDER BY created_at DESC");
$students = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>لوحة تحكم المشرف</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Cairo:wght@400;600;700&display=swap" rel="stylesheet">
    <link href="static/style.css" rel="stylesheet">
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-dark bg-primary">
        <div class="container">
            <a class="navbar-brand" href="admin_dashboard.php">لوحة تحكم المشرف</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav me-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="logout.php">تسجيل الخروج</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <div class="container mt-4">
        <div class="admin-panel">
            <div class="admin-header">
                <h2>بيانات الطلاب المسجلين</h2>
                <form method="POST" class="export-buttons">
                    <button type="submit" name="export_excel" class="btn btn-success">
                        تصدير إلى Excel
                    </button>
                </form>
            </div>

            <div class="table-responsive">
                <table class="data-table table">
                    <thead>
                        <tr>
                            <th>رقم الجلوس</th>
                            <th>الاسم</th>
                            <th>الرقم القومي</th>
                            <th>رقم الهاتف</th>
                            <th>المرحلة</th>
                            <th>التخصص</th>
                            <th>تاريخ التسجيل</th>
                            <th>الإجراءات</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($students as $student): ?>
                            <tr>
                                <td><?php echo htmlspecialchars($student['seat_number']); ?></td>
                                <td><?php echo htmlspecialchars($student['full_name']); ?></td>
                                <td><?php echo htmlspecialchars($student['national_id']); ?></td>
                                <td><?php echo htmlspecialchars($student['phone_number']); ?></td>
                                <td><?php echo htmlspecialchars($student['current_stage']); ?></td>
                                <td><?php echo htmlspecialchars($student['specialization'] ?? '-'); ?></td>
                                <td><?php echo date('Y-m-d', strtotime($student['created_at'])); ?></td>
                                <td>
                                    <a href="view_student.php?id=<?php echo $student['id']; ?>" class="btn btn-sm btn-primary">عرض</a>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html> 