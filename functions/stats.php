<?php
function getTotalOrders($db) {
    $result = $db->table('orders')->read();
    return count($result);
}

function getTotalRevenue($db) {
    $orders = $db->table('orders')->read();
    $totalRevenue = 0;
    foreach ($orders as $order) {
        $totalRevenue += $order['total_amount'];
    }
    return $totalRevenue;
}

function getMostPopularItem($db) {
    $orderItems = $db->table('order_items')->read();
    $itemCounts = [];
    foreach ($orderItems as $item) {
        $itemId = $item['item_id'];
        if (isset($itemCounts[$itemId])) {
            $itemCounts[$itemId]++;
        } else {
            $itemCounts[$itemId] = 1;
        }
    }
    if (!empty($itemCounts)) {
        $mostPopularItemId = array_keys($itemCounts, max($itemCounts))[0];
        $mostPopularItem = $db->table('menu_items')->find($mostPopularItemId, 'item_id');
        return $mostPopularItem['item_name'];
    }
    return "No items ordered yet.";
}

function getActiveOrders($db) {
    $orders = $db->table('orders')->read();
    $activeOrders = 0;
    foreach ($orders as $order) {
        if ($order['status'] !== 'Delivered') {
            $activeOrders++;
        }
    }
    return $activeOrders;
}

function getTotalReservations($db) {
    $reservations = $db->table('reservations')->read();
    return count($reservations);
}

function getWeeklyRevenue($db) {
    // Fetch revenue data for the last 7 days (grouped by day of the week)
    $query = "SELECT DAYNAME(created_at) as day, SUM(total_amount) as revenue 
              FROM orders 
              WHERE created_at >= DATE_SUB(CURDATE(), INTERVAL 7 DAY) 
              GROUP BY DAYOFWEEK(created_at), DAYNAME(created_at)
              ORDER BY DAYOFWEEK(created_at)";
    $result = $db->table('orders')->rawQuery($query);

    // Initialize an array for all days of the week
    $daysOfWeek = ['Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday', 'Sunday'];
    $weeklyData = array_fill_keys($daysOfWeek, 0); // Set default revenue to 0 for all days

    // Populate the array with fetched data
    foreach ($result as $row) {
        $weeklyData[$row['day']] = (float)$row['revenue'];
    }

    return array_values($weeklyData); // Return revenue values in order of days
}

function getMonthlyRevenue($db) {
    // Fetch revenue data for the last 4 weeks (grouped by week of the month)
    $query = "SELECT WEEK(created_at, 1) - WEEK(DATE_SUB(created_at, INTERVAL DAYOFMONTH(created_at) - 1 DAY), 1) + 1 as week, 
                     SUM(total_amount) as revenue 
              FROM orders 
              WHERE created_at >= DATE_SUB(CURDATE(), INTERVAL 1 MONTH) 
              GROUP BY week 
              ORDER BY week";
    $result = $db->table('orders')->rawQuery($query);

    // Initialize an array for 4 weeks
    $monthlyData = array_fill(0, 4, 0); // Set default revenue to 0 for all weeks

    // Populate the array with fetched data
    foreach ($result as $row) {
        $monthlyData[$row['week'] - 1] = (float)$row['revenue']; // Adjust for zero-based index
    }

    return $monthlyData;
}

function getYearlyRevenue($db) {
    // Fetch revenue data for the last 12 months (grouped by month)
    $query = "SELECT MONTHNAME(created_at) as month, SUM(total_amount) as revenue 
              FROM orders 
              WHERE created_at >= DATE_SUB(CURDATE(), INTERVAL 12 MONTH) 
              GROUP BY MONTH(created_at), MONTHNAME(created_at)
              ORDER BY MONTH(created_at)";
    $result = $db->table('orders')->rawQuery($query);

    // Initialize an array for all months of the year
    $monthsOfYear = ['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December'];
    $yearlyData = array_fill_keys($monthsOfYear, 0); // Set default revenue to 0 for all months

    // Populate the array with fetched data
    foreach ($result as $row) {
        $yearlyData[$row['month']] = (float)$row['revenue'];
    }

    return array_values($yearlyData); // Return revenue values in order of months
}
?>