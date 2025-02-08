<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css"/>
    <style>
        .sidebar {
            width: 250px;
            height: 100vh;
            position: fixed;
            left: 0;
            top: 0;
            background: #343a40;
            color: white;
            padding-top: 20px;
        }
        .sidebar a {
            padding: 10px 15px;
            display: block;
            color: white;
            text-decoration: none;
            transition: background 0.3s;
        }
        .sidebar a:hover {
            background: #495057;
        }
        .content {
            margin-left: 260px;
            padding: 20px;
        }
        .card {
            transition: transform 0.3s ease-in-out;
        }
        .card:hover {
            transform: scale(1.05);
        }
    </style>
</head>
<body>
    <div class="sidebar animate__animated animate__fadeInLeft">
        <h4 class="text-center">Admin Dashboard</h4>
        <a href="#">Users</a>
        <a href="#">Orders</a>
        <a href="#">Products</a>
        <a href="#">Settings</a>
    </div>

    <div class="content animate__animated animate__fadeInUp">
        <nav class="navbar navbar-dark bg-dark mb-4 animate__animated animate__fadeInDown">
            <div class="container-fluid">
                <form class="d-flex">
                    <input class="form-control me-2" type="search" placeholder="Search anything..." aria-label="Search">
                </form>
            </div>
        </nav>

        <div class="container">
            <div class="row mb-4">
                <div class="col-md-4">
                    <div class="card p-3 animate__animated animate__zoomIn">
                        <h5>Products</h5>
                        <p>2,567</p>
                        <p class="text-success">Increased 21%</p>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card p-3 animate__animated animate__zoomIn" style="animation-delay: 0.2s;">
                        <h5>Orders</h5>
                        <p>4,972</p>
                        <p class="text-success">Increased 12%</p>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card p-3 animate__animated animate__zoomIn" style="animation-delay: 0.4s;">
                        <h5>Revenue</h5>
                        <p>$65,950</p>
                        <p class="text-danger">Decreased 7%</p>
                    </div>
                </div>
            </div>

            <div class="card p-3 animate__animated animate__fadeInUp" style="animation-delay: 0.6s;">
                <h5>Orders & Revenue</h5>
                <canvas id="barChart"></canvas>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener("DOMContentLoaded", function () {
            const ctx = document.getElementById('barChart').getContext('2d');
            new Chart(ctx, {
                type: 'bar',
                data: {
                    labels: ["Jan", "Feb", "Mar", "Apr", "May", "Jun", "Jul", "Aug", "Sep", "Oct", "Nov", "Dec"],
                    datasets: [
                        {
                            label: "Orders",
                            backgroundColor: "rgba(75,192,192,0.6)",
                            data: [30, 40, 45, 50, 70, 90, 80, 65, 60, 75, 85, 95]
                        },
                        {
                            label: "Visits",
                            backgroundColor: "rgba(153,102,255,0.6)",
                            data: [50, 60, 70, 80, 90, 120, 110, 95, 85, 100, 105, 114]
                        }
                    ]
                }
            });
        });
    </script>
</body>
</html>
