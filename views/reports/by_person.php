<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Trainings by Person - SSW Training Reports</title>
    <link rel="stylesheet" href="/mattlam/ssw-ai-assist-training-reports/assets/css/style.css">
</head>
<body>
    <header class="banner">
        <h1>Trainings by Person</h1>
    </header>
    
    <main class="container">
        <div class="report-container">
            <?php if (!empty($trainings)): ?>
                <table class="report-table">
                    <thead>
                        <tr>
                            <th>Training ID</th>
                            <th>Certification ID</th>
                            <th>Title</th>
                            <th>Participation Date</th>
                            <th>First Name</th>
                            <th>Last Name</th>
                            <th>Identifier</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($trainings as $training): ?>
                            <tr>
                                <td><?php echo htmlspecialchars($training['TrainingActivityId']); ?></td>
                                <td><?php echo htmlspecialchars($training['CertificationActivityId']); ?></td>
                                <td><?php echo htmlspecialchars($training['Title']); ?></td>
                                <td><?php echo htmlspecialchars($training['ParticipationDate']); ?></td>
                                <td><?php echo htmlspecialchars($training['FirstName']); ?></td>
                                <td><?php echo htmlspecialchars($training['LastName']); ?></td>
                                <td><?php echo htmlspecialchars($training['Identifier']); ?></td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            <?php else: ?>
                <p>No training records found.</p>
            <?php endif; ?>
        </div>
    </main>
</body>
</html>
