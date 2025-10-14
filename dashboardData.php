<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
include("include/db.php");

$sqlTotals = "
    SELECT 
        SUM(CAST(REPLACE(gross_purchase_amount, ',', '') AS DECIMAL(15,2))) AS grossPurchases,
        SUM(CAST(REPLACE(net_purchase_amount, ',', '') AS DECIMAL(15,2))) AS netPurchases,
        SUM(CAST(REPLACE(input_tax, ',', '') AS DECIMAL(15,2))) AS inputTax,
        SUM(CAST(REPLACE(vat_exempt_purchases, ',', '') AS DECIMAL(15,2))) AS vatExemptPurchases,
        SUM(CAST(REPLACE(zero_rated_purchases, ',', '') AS DECIMAL(15,2))) AS zeroRatedPurchases
    FROM reciepts_data
";
$resultTotals = mysqli_query($conn, $sqlTotals);
$totals = mysqli_fetch_assoc($resultTotals);

$sqlMonthly = "
    SELECT 
        m.month_name AS month,
        COALESCE(SUM(CAST(REPLACE(r.gross_purchase_amount, ',', '') AS DECIMAL(15,2))), 0) AS grossPurchases,
        COALESCE(SUM(CAST(REPLACE(r.net_purchase_amount, ',', '') AS DECIMAL(15,2))), 0) AS netPurchases,
        COALESCE(SUM(CAST(REPLACE(r.input_tax, ',', '') AS DECIMAL(15,2))), 0) AS inputTax
    FROM (
        SELECT 1 AS month_num, 'Jan' AS month_name UNION ALL
        SELECT 2, 'Feb' UNION ALL
        SELECT 3, 'Mar' UNION ALL
        SELECT 4, 'Apr' UNION ALL
        SELECT 5, 'May' UNION ALL
        SELECT 6, 'Jun' UNION ALL
        SELECT 7, 'Jul' UNION ALL
        SELECT 8, 'Aug' UNION ALL
        SELECT 9, 'Sep' UNION ALL
        SELECT 10, 'Oct' UNION ALL
        SELECT 11, 'Nov' UNION ALL
        SELECT 12, 'Dec'
    ) m
    LEFT JOIN reciepts_data r
        ON (
            MONTH(STR_TO_DATE(r.`date`, '%m/%d/%Y')) = m.month_num 
            AND YEAR(STR_TO_DATE(r.`date`, '%m/%d/%Y')) = YEAR(CURDATE())
        )
    GROUP BY m.month_num, m.month_name
    ORDER BY m.month_num
";
$resultMonthly = mysqli_query($conn, $sqlMonthly);
$monthlyTrends = [];
while ($row = mysqli_fetch_assoc($resultMonthly)) {
    $monthlyTrends[] = [
        'month' => $row['month'],
        'grossPurchases' => (float)$row['grossPurchases'],
        'netPurchases' => (float)$row['netPurchases'],
        'inputTax' => (float)$row['inputTax'],
    ];
}

$currentMonth = date('Y-m');
$lastMonth = date('Y-m', strtotime('-1 month'));

$sqlComparison = "
    SELECT 
        SUM(CASE WHEN DATE_FORMAT(STR_TO_DATE(`date`, '%m/%d/%Y'), '%Y-%m') = '$currentMonth'
        THEN CAST(REPLACE(gross_purchase_amount, ',', '') AS DECIMAL(15,2)) ELSE 0 END) AS thisMonth,
        SUM(CASE WHEN DATE_FORMAT(STR_TO_DATE(`date`, '%m/%d/%Y'), '%Y-%m') = '$lastMonth'
        THEN CAST(REPLACE(gross_purchase_amount, ',', '') AS DECIMAL(15,2)) ELSE 0 END) AS lastMonth,
        'Gross Purchases' AS category
    FROM reciepts_data
    UNION ALL
    SELECT 
        SUM(CASE WHEN DATE_FORMAT(STR_TO_DATE(`date`, '%m/%d/%Y'), '%Y-%m') = '$currentMonth'
        THEN CAST(REPLACE(net_purchase_amount, ',', '') AS DECIMAL(15,2)) ELSE 0 END),
        SUM(CASE WHEN DATE_FORMAT(STR_TO_DATE(`date`, '%m/%d/%Y'), '%Y-%m') = '$lastMonth'
        THEN CAST(REPLACE(net_purchase_amount, ',', '') AS DECIMAL(15,2)) ELSE 0 END),
        'Net Purchases'
    FROM reciepts_data
    UNION ALL
    SELECT 
        SUM(CASE WHEN DATE_FORMAT(STR_TO_DATE(`date`, '%m/%d/%Y'), '%Y-%m') = '$currentMonth'
        THEN CAST(REPLACE(input_tax, ',', '') AS DECIMAL(15,2)) ELSE 0 END),
        SUM(CASE WHEN DATE_FORMAT(STR_TO_DATE(`date`, '%m/%d/%Y'), '%Y-%m') = '$lastMonth'
        THEN CAST(REPLACE(input_tax, ',', '') AS DECIMAL(15,2)) ELSE 0 END),
        'Input Tax'
    FROM reciepts_data
";
$resultComparison = mysqli_query($conn, $sqlComparison);
$financialComparison = [];
while ($row = mysqli_fetch_assoc($resultComparison)) {
    $financialComparison[] = [
        'category' => $row['category'],
        'thisMonth' => (float)$row['thisMonth'],
        'lastMonth' => (float)$row['lastMonth'],
    ];
}

echo json_encode([
    'grossPurchases' => (float)$totals['grossPurchases'],
    'netPurchases' => (float)$totals['netPurchases'],
    'inputTax' => (float)$totals['inputTax'],
    'vatExemptPurchases' => (float)$totals['vatExemptPurchases'],
    'zeroRatedPurchases' => (float)$totals['zeroRatedPurchases'],
    'monthlyFinancialTrends' => $monthlyTrends,
    'financialComparison' => $financialComparison
]);

mysqli_close($conn);
?>
