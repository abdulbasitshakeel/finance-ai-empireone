<?php

header("Access-Control-Allow-Origin: *");
header("Content-Type: text/csv; charset=UTF-8");
header("Content-Disposition: attachment; filename=receipts_export.csv");

include("include/db.php");

$startDate = isset($_GET['startDate']) ? $_GET['startDate'] : null;
$endDate   = isset($_GET['endDate']) ? $_GET['endDate'] : null;

$sql = "SELECT id, date, order_or_reference_number, supplier_name, supplier_address, supplier_register_name, 
               supplier_tin, purchase_category, expense_category, gross_purchase_amount, 
               net_purchase_amount, input_tax, vat_exempt_purchases, zero_rated_purchases 
        FROM reciepts_data WHERE 1=1";

if ($startDate && $endDate) {
    $sql .= " AND STR_TO_DATE(date, '%m/%d/%y') BETWEEN STR_TO_DATE('$startDate', '%m/%d/%y') AND STR_TO_DATE('$endDate', '%m/%d/%y')";
}

$result = mysqli_query($conn, $sql);

// Output CSV header row
$output = fopen("php://output", "w");
fputcsv($output, [
    'ID', 'Date', 'Order #', 'Supplier Name', 'Supplier Address', 'Supplier Register Name',
    'Supplier TIN', 'Purchase Category', 'Expense Category', 'Gross Amount',
    'Net Amount', 'Input Tax', 'VAT Exempt', 'Zero Rated'
]);

// Output data rows
while ($row = mysqli_fetch_assoc($result)) {
    fputcsv($output, $row);
}

fclose($output);
mysqli_close($conn);
exit;

?>