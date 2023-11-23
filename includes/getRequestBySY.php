<?php
require_once '../connection/database.php';

$sql = "SELECT DISTINCT school_year FROM request";
$stmt= $conn->prepare($sql);
$stmt->execute();
$result = $stmt->get_result();

$schoolYears = [];

while($row = $result->fetch_assoc()){ 
    $schoolYears[] = $row['school_year'];
}

$categories = ["comlab usage", "repair", "equipment"];

foreach($schoolYears as $schoolYear){ //2021-2022
    foreach($categories as $category){ //comlab usage
        $countEveryRequestType = "SELECT COUNT(*) as count FROM request WHERE request_type = ? AND school_year = ?";
        $stmt = $conn->prepare($countEveryRequestType);
        $stmt->bind_param("ss", $category, $schoolYear);
        $stmt->execute();
        $countResult = $stmt->get_result();
        $countRow = $countResult->fetch_assoc();
        $requestCounts[$category][$schoolYear] = $countRow['count'];
        //comlab usage 
            //2021-2022 => 5
            //2022-2023 => 3
        //equipment
            //2021-2022 => 4
            //2022-2023 => 2
        //repair
            //2021-2022 => 6
            //2021-2022 => 5
    }
}

$stmt->close();
$conn->close();

$data = [
    'schoolYears' => $schoolYears,
    'requestCounts' => $requestCounts
];

header('Content-Type: application/json');
echo json_encode($data);
?>