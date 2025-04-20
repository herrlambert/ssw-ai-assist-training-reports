<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Expired Trainings - SSW Training Reports</title>
    <link rel="stylesheet" href="/mattlam/ssw-ai-assist-training-reports/assets/css/style.css">
    <style>
        /* Training selector form styles */
        .training-selector {
            margin-bottom: 2rem;
            padding: 1rem;
            background-color: #f5f5f5;
            border-radius: 4px;
        }
        
        .training-selector select {
            padding: 0.5rem;
            font-size: 1rem;
            border: 1px solid #ddd;
            border-radius: 4px;
            width: 400px;
            margin-right: 1rem;
        }
        
        .training-selector button {
            padding: 0.5rem 1rem;
            font-size: 1rem;
            background-color: #4b2e83;
            color: white;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }
        
        .training-selector button:hover {
            background-color: #35215d;
        }
        
        .expired-warning {
            color: #d73f3f;
            font-weight: bold;
        }

        .report-description {
            margin-bottom: 1rem;
            color: #666;
            font-size: 1.1rem;
        }

        .nav-link {
            display: inline-block;
            margin-bottom: 1rem;
            color: #4b2e83;
            text-decoration: none;
        }

        .nav-link:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>
    <header class="banner">
        <a href="https://www.washington.edu" class="banner-logo">
            <img src="https://www.washington.edu/brand/files/2014/09/W-Logo_White_RGB.png" alt="W Logo">
            <span class="uw-text">University of Washington</span>
        </a>
        <h1>Expired Trainings</h1>
    </header>
    
    <main class="container">
        <a href="/mattlam/ssw-ai-assist-training-reports/" class="nav-link">← Back to Main Page</a>
        <p class="report-description">Show persons who have not taken selected training in past 2 years</p>
        <form class="training-selector" method="GET" action="">
            <select name="training" required>
                <option value="">Select a Training...</option>
                <?php foreach ($uniqueTitles as $title): ?>
                    <option value="<?php echo htmlspecialchars($title); ?>"
                            <?php echo $selectedTitle === $title ? 'selected' : ''; ?>>
                        <?php echo htmlspecialchars($title); ?>
                    </option>
                <?php endforeach; ?>
            </select>
            <button type="submit">Show Expired Trainings</button>
        </form>

        <div class="report-container">
            <?php if (!empty($selectedTitle) && empty($trainings)): ?>
                <p>No expired trainings found for the selected training.</p>
            <?php elseif (!empty($trainings)): ?>
                <table class="report-table">
                    <thead>
                        <tr>
                            <th>Last Name</th>
                            <th>First Name</th>
                            <th>Identifier</th>
                            <th>Most Recent Date</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($trainings as $training): ?>
                            <tr>
                                <td><?php echo htmlspecialchars($training['LastName']); ?></td>
                                <td><?php echo htmlspecialchars($training['FirstName']); ?></td>
                                <td><?php echo htmlspecialchars($training['Identifier']); ?></td>
                                <td><?php echo htmlspecialchars($training['ParticipationDate']); ?></td>
                                <td class="expired-warning">Expired</td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            <?php endif; ?>
        </div>
    </main>
</body>
</html>



