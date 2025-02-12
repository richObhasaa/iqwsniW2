<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Statistics Analysis</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <style>
        body { padding-top: 56px; }
        .menu-btn { cursor: pointer; font-size: 24px; position: fixed; left: 15px; top: 15px; z-index: 1000; background: #007bff; padding: 10px; color: white; border-radius: 5px; }
        .sidebar { position: fixed; left: -250px; top: 0; width: 250px; height: 100%; background: #343a40; color: white; padding-top: 20px; transition: left 0.3s; z-index: 999; }
        .sidebar a { color: white; display: block; padding: 15px; text-decoration: none; }
        .sidebar a:hover { background: #495057; }
        .show-sidebar { left: 0; }
    </style>
</head>
<body>

    <!-- Hamburger Menu -->
    <div class="menu-btn" onclick="toggleSidebar()">☰ Menu</div>

    <!-- Sidebar Navigation -->
    <div class="sidebar" id="sidebar">
        <a href="#" onclick="showPage(1)">1️⃣ Light Bulb Analysis</a>
        <a href="#" onclick="showPage(2)">2️⃣ Empirical Rule Analysis</a>
    </div>

    <div class="container mt-4">

        <!-- Page 1: Light Bulb Analysis -->
        <div id="page1">
            <h2>1️⃣ Light Bulb Quality Analysis</h2>
            <?php
                $mean_diameter = 10;
                $std_dev_diameter = 0.5;
                $lower_limit = 9.5;
                $upper_limit = 10.5;

                // Calculate Z-scores
                $z_lower = ($lower_limit - $mean_diameter) / $std_dev_diameter;
                $z_upper = ($upper_limit - $mean_diameter) / $std_dev_diameter;

                // Normal CDF function approximation
                function normalCDF($z) {
                    return 0.5 * (1 + erf($z / sqrt(2)));
                }

                $probability_within_limits = normalCDF($z_upper) - normalCDF($z_lower);
                $defective_rate = 1 - $probability_within_limits;
                $defective_percentage = round($defective_rate * 100, 2);
            ?>

            <p>Z-score for 9.5 cm: <strong><?php echo round($z_lower, 2); ?></strong></p>
            <p>Z-score for 10.5 cm: <strong><?php echo round($z_upper, 2); ?></strong></p>
            <p>Percentage of defective bulbs: <strong><?php echo $defective_percentage; ?>%</strong></p>

            <canvas id="lightBulbChart"></canvas>
        </div>

        <!-- Page 2: Empirical Rule Analysis -->
        <div id="page2" style="display:none;">
            <h2>2️⃣ Empirical Rule Analysis</h2>
            <?php
                $mean = 75;
                $std_dev = 8;
                $total_students = 200;

                // Empirical Rule Calculations
                $within_1_std_dev = 0.68 * $total_students;
                $within_2_std_dev = 0.95 * $total_students;
                $within_3_std_dev = 0.997 * $total_students;
                $outliers = $total_students - $within_3_std_dev;
            ?>

            <p>68% (1 SD): <strong><?php echo round($within_1_std_dev); ?> students</strong></p>
            <p>95% (2 SD): <strong><?php echo round($within_2_std_dev); ?> students</strong></p>
            <p>99.7% (3 SD): <strong><?php echo round($within_3_std_dev); ?> students</strong></p>
            <p>Potential outliers: <strong><?php echo round($outliers); ?> students</strong></p>

            <canvas id="empiricalChart"></canvas>
        </div>
    </div>

    <!-- JavaScript for Sidebar and Chart -->
    <script>
        function toggleSidebar() {
            let sidebar = document.getElementById('sidebar');
            sidebar.classList.toggle('show-sidebar');
        }

        function showPage(page) {
            document.getElementById('page1').style.display = (page === 1) ? 'block' : 'none';
            document.getElementById('page2').style.display = (page === 2) ? 'block' : 'none';
            toggleSidebar();
        }

        // Light Bulb Quality Chart
        var ctx1 = document.getElementById('lightBulbChart').getContext('2d');
        new Chart(ctx1, {
            type: 'bar',
            data: {
                labels: ['Within Quality Limit', 'Defective'],
                datasets: [{
                    label: 'Percentage',
                    data: [<?php echo 100 - $defective_percentage; ?>, <?php echo $defective_percentage; ?>],
                    backgroundColor: ['#28a745', '#dc3545']
                }]
            }
        });

        // Empirical Rule Chart
        var ctx2 = document.getElementById('empiricalChart').getContext('2d');
        new Chart(ctx2, {
            type: 'bar',
            data: {
                labels: ['Within 1 SD (68%)', 'Within 2 SD (95%)', 'Within 3 SD (99.7%)', 'Outliers'],
                datasets: [{
                    label: 'Number of Students',
                    data: [<?php echo round($within_1_std_dev); ?>, <?php echo round($within_2_std_dev); ?>, <?php echo round($within_3_std_dev); ?>, <?php echo round($outliers); ?>],
                    backgroundColor: ['#007bff', '#28a745', '#ffc107', '#dc3545']
                }]
            }
        });
    </script>

</body>
</html>
