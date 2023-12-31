<?php
include('config.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $periodId = isset($_POST['period_id']) ? $_POST['period_id'] : null;
    $deductionTypeList = isset($_POST['deductionTypeList']) ? $_POST['deductionTypeList'] : [];

    if (empty($periodId) || empty($deductionTypeList)) {
        echo json_encode(['error' => 'Period ID or deduction type list is empty']);
        exit();
    }

    foreach ($deductionTypeList as $deductionTypeId) {
        // Fetch percentage_amount and amount for the given dedtype_id
        $deductionTypeQuery = "SELECT percentage_amount, amount FROM deduction_template WHERE dedtype_id = '$deductionTypeId'";
        $deductionTypeResult = mysqli_query($conn, $deductionTypeQuery);

        if (!$deductionTypeResult) {
            echo json_encode(['error' => 'Error fetching deduction type details']);
            exit();
        }

        $deductionTypeRow = mysqli_fetch_assoc($deductionTypeResult);
        $percentageAmount = $deductionTypeRow['percentage_amount'];
        $fixedAmount = $deductionTypeRow['amount'];

        // Fetch basic_salary for the given period_id
        $basicSalaryQuery = "SELECT emp_id, emppay_id, basic_salary FROM employee_payroll WHERE period_id = '$periodId'";
        $basicSalaryResult = mysqli_query($conn, $basicSalaryQuery);

        if (!$basicSalaryResult) {
            echo json_encode(['error' => 'Error fetching basic salary']);
            exit();
        }

        while ($basicSalaryRow = mysqli_fetch_assoc($basicSalaryResult)) {
            $employeeId = $basicSalaryRow['emp_id'];
            $emppayId = $basicSalaryRow['emppay_id'];
            $basicSalary = $basicSalaryRow['basic_salary'];

            // Calculate amount based on percentage_amount, if greater than 0
            $amount = ($percentageAmount > 0) ? ($basicSalary * ($percentageAmount * 0.01)) : $fixedAmount;

            // Insert into deduction_details table
            $insertQuery = "INSERT INTO deduction_details (dedtype_id, deduction_type, emppay_id, amount) 
                            VALUES ('$deductionTypeId', (SELECT deduction_type FROM deduction_template WHERE dedtype_id = '$deductionTypeId'), '$emppayId', '$amount')";

            $insertResult = mysqli_query($conn, $insertQuery);

            if (!$insertResult) {
                echo json_encode(['error' => 'Error saving deduction details']);
                exit();
            }
        }
    }

    // Update deductions_total in employee_payroll table
    $deductionsTotalQuery = "UPDATE employee_payroll ep
                            SET ep.deductions_total = (SELECT SUM(amount) FROM deduction_details dd WHERE dd.emppay_id = ep.emppay_id)
                            WHERE ep.period_id = '$periodId'";

    $updateDeductionsTotalResult = mysqli_query($conn, $deductionsTotalQuery);

    if (!$updateDeductionsTotalResult) {
        echo json_encode(['error' => 'Error updating deductions total']);
        exit();
    }

    echo json_encode(['success' => 'Deductions saved successfully']);
} else {
    echo json_encode(['error' => 'Invalid request method']);
}

mysqli_close($conn);
?>
