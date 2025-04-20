<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Trainings by Person - SSW Training Reports</title>
    <link rel="stylesheet" href="/mattlam/ssw-ai-assist-training-reports/assets/css/style.css">
    <style>
        /* Additional styles for the Title column */
        .report-table th.title-column,
        .report-table td.title-column {
            width: 40%;
            min-width: 300px;
        }
        
        /* Search form styles */
        .search-form {
            margin-bottom: 2rem;
            padding: 1rem;
            background-color: #f5f5f5;
            border-radius: 4px;
        }
        
        .search-form input[type="text"] {
            padding: 0.5rem;
            font-size: 1rem;
            border: 1px solid #ddd;
            border-radius: 4px;
            width: 300px;
            margin-right: 1rem;
        }
        
        .search-form button {
            padding: 0.5rem 1rem;
            font-size: 1rem;
            background-color: #4b2e83;
            color: white;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }
        
        .search-form button:hover {
            background-color: #35215d;
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
        <h1>Trainings by Person</h1>
    </header>
    
    <main class="container">
        <a href="/mattlam/ssw-ai-assist-training-reports/" class="nav-link">← Back to Main Page</a>
        <form class="search-form" method="GET" action="">
            <input type="text" 
                   name="search" 
                   placeholder="Enter name or identifier..."
                   value="<?php echo htmlspecialchars($_GET['search'] ?? ''); ?>">
            <button type="submit">Show Trainings for Person</button>
        </form>

        <div class="report-container">
            <?php if (isset($_GET['search']) && empty($trainings)): ?>
                <p>No training records found for your search.</p>
            <?php elseif (!isset($_GET['search'])): ?>
                <p>Please enter a search term to find training records.</p>
            <?php else: ?>
                <table class="report-table">
                    <thead>
                        <tr>
                            <th class="title-column">Title</th>
                            <th>Participation Date</th>
                            <th>First Name</th>
                            <th>Last Name</th>
                            <th>Identifier</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($trainings as $training): ?>
                            <tr>
                                <td class="title-column"><?php echo htmlspecialchars($training['Title']); ?></td>
                                <td><?php echo htmlspecialchars($training['ParticipationDate']); ?></td>
                                <td><?php echo htmlspecialchars($training['FirstName']); ?></td>
                                <td><?php echo htmlspecialchars($training['LastName']); ?></td>
                                <td><?php echo htmlspecialchars($training['Identifier']); ?></td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            <?php endif; ?>
        </div>
    </main>
</body>
</html>







