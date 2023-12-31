<?php require 'header.php'; ?>

<!doctype html>
<html lang="en">

<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
	<title>Employee Payroll List</title>
	<link rel="stylesheet" href="https://cdn.datatables.net/1.11.5/css/jquery.dataTables.min.css">
	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
</head>

<body>

	<div class="content">
		<div class="animated fadeIn">
			<div class="row">
				<div class="col-md-12">
					<div class="card">
						<div class="card-header">
							<strong class="card-title">Employee Payroll List</strong>
						</div>
						<div class="card-body">
							<div class="row">
								<div class="col-md-12">
									<p>Payroll Range: <b><?php echo date('F j, Y', strtotime($_GET['period_from'])) . ' - ' . date('F j, Y', strtotime($_GET['period_to'])) ?></b></p>
									<p>Payroll Type: <b><?php echo $_GET['period_type']; ?></b></p>
									<button class="btn btn-primary" onclick="downloadTable()">Download</button>
									<button class="btn btn-success btn-sm btn-block col-md-2 float-right" type="button" id="addDeductionBtn" data-toggle="modal" data-target="#addDeductionModal">
										<span class="fa fa-plus"></span> Add Deduction
									</button>
								</div>
							</div>
							<hr>

							<table id="employeePayroll" class="table table-striped table-bordered">
								<thead>
									<tr>
										<th>ID</th>
										<th>Name</th>
										<th>Basic Salary</th>
										<th>Overtime</th>
										<th>Gross Pay</th>
										<th>Deduction</th>
										<th>Net Pay</th>
										<th>Actions</th>
									</tr>
								</thead>
								<tbody></tbody>
							</table>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>

	<!-- Add Deduction Modal -->
	<div class="modal fade" id="addDeductionModal" tabindex="-1" role="dialog" aria-labelledby="addDeductionModalLabel" aria-hidden="true">
		<div class="modal-dialog" role="document">
			<div class="modal-content">
				<div class="modal-header">
					<!-- Your existing header content -->
				</div>
				<div class="modal-body">
					<form id="deductionForm">
						<!-- Remove the employee list with checkboxes -->
						<!-- Deduction type list with checkboxes -->
						<div class="form-group">
							<label for="deductionTypeList">Select Deduction Types:</label>
							<div id="deductionTypeListContainer">
								<!-- Checkbox options will be dynamically added here -->
								<div class="form-check">
									<input type="checkbox" class="form-check-input" value="SSS" id="deductionType_SSS" name="deductionTypeList[]">
									<label class="form-check-label" for="deductionType_SSS">SSS</label>
								</div>
								<!-- Percentage input for SSS -->
								<div class="form-group percentage-input">
									<label for="percentage_SSS">Percentage:</label>
									<input type="text" class="form-control" id="percentage_SSS" data-dedtype-id="SSS" placeholder="Enter percentage">
								</div>
							</div>
						</div>

						<!-- Save Deduction Button -->
						<button type="button" class="btn btn-primary" id="saveDeduction">Save Deduction</button>
					</form>
				</div>
			</div>
		</div>
	</div>

<!-- view modal -->
	<!-- <div class="modal fade show" id="uni_modal" role="dialog" aria-modal="true" style="padding-right: 19px; display: block;"> -->
    <div class="modal fade" id="viewEmployeePayrollModal" tabindex="-1" role="dialog" aria-labelledby="viewEmployeePayrollModalLabel" aria-hidden="true" >
	<div class="modal-dialog modal-md large" role="document">
      <div class="modal-content">
        <div class="modal-header">
        <h5 class="modal-title" id="viewEmployeePayrollModalLabel">Employee Payslip</h5>
      </div>
      <div class="modal-body">

<div class="contriner-fluid">
	<div class="col-md-50">
		<h5><b>Employee ID :</small><span id="empIdViewModal"></span></b></h5>
		<h4><b>Name: </small><span id="lnameViewModal"></span>, <span id="fnameViewModal"></span></b></h4>
		<hr class="divider">
		<div class="row">
			<div class="col-md-6">
				<p><b>Payroll Ref : <span id="emppayIdViewModal"></span></b></p>
				<p><b>Payroll Range : <span id="payrollFromViewModal"></span> to <span id="payrollToViewModal"></span></b></p>
			</div>
			
		</div>
	
		<hr class="divider">
		<div class="row">
			<div class="col-md-6">
				<div class="card">
					<div class="card-header">
						<span><b>Earnings</b></span>
						
					</div>
					<div class="card-body">
						<ul class="list-group">
						<li class="list-group-item d-flex justify-content-between align-items-center">
						   <b>Basic Salary</b>
					    <span class="badge badge-primary badge-pill"><span id="basicSalaryViewModal"></span></span>
					  </li>
					  <li class="list-group-item d-flex justify-content-between align-items-center">
						   Hours Rendered
					    <span class="badge badge-primary badge-pill"><span id="hoursRenderedViewModal"></span></span>
					  </li>
					  <li class="list-group-item d-flex justify-content-between align-items-center">
						   OT Hours
					    <span class="badge badge-primary badge-pill"><span id="otHours"></span></span>
					  </li>
					  <li class="list-group-item d-flex justify-content-between align-items-center">
						   OT Payment
					    <span class="badge badge-primary badge-pill"><span id="otPayment"></span></span>
					  </li>
					  <li class="list-group-item d-flex justify-content-between align-items-center">
						   <b>Gross Pay</b>
					    <span class="badge badge-primary badge-pill"><span id="grossPay"></span></span>
					  </li>
						  
					</ul>
					</div>
				</div>
			</div>
			<div class="col-md-6">
				<div class="card">
					<div class="card-header">
						<span><b>Deductions</b></span>
					</div>
					<div class="card-body">
						<ul class="list-group">

						<li class="list-group-item d-flex justify-content-between align-items-center">
							Tax
							<span class="badge badge-primary badge-pill" id="TaxDeduction">0.00</span>
						</li>

						<li class="list-group-item d-flex justify-content-between align-items-center">
							SSS
							<span class="badge badge-primary badge-pill" id="SSSDeduction">0.00</span>
						</li>

						<li class="list-group-item d-flex justify-content-between align-items-center">
							PhilHealth
							<span class="badge badge-primary badge-pill" id="PhilHealthDeduction">0.00</span>
						</li>

						<li class="list-group-item d-flex justify-content-between align-items-center">
							PagIBIG
							<span class="badge badge-primary badge-pill" id="PagIBIGDeduction">0.00</span>
						</li>

						<li class="list-group-item d-flex justify-content-between align-items-center">
							Salary Advance
							<span class="badge badge-primary badge-pill" id="SalaryAdvanceDeduction">0.00</span>
						</li>

						<li class="list-group-item d-flex justify-content-between align-items-center">
							Other
							<span class="badge badge-primary badge-pill" id="OtherDeduction">0.00</span>
						</li>

							<li class="list-group-item d-flex justify-content-between align-items-center">
						   <b>Deduction Total</b> 
						   <span class="badge badge-primary badge-pill"><span id="deductionTotal"></span></span>
					  </li>
						  
						</ul>
					</div>
				</div>
			</div>

			<div class="col-md-6">
				<div class="card">
					<div class="card-header">
						<span><b>Total Payment</b></span>
						
					</div>
					<div class="card-body">
						<ul class="list-group">
							<li class="list-group-item d-flex justify-content-between align-items-center">
						   <b>Net Pay</b>
						   <span class="badge badge-primary badge-pill"><span id="netPay"></span></span>
					  </li>
						  
						</ul>
					</div>
				</div>
			</div>
		
		</div>
	</div>
	<hr>
			<div class="row">
				<div class="col-lg-12">
					<button class="btn btn-primary btn-sm btn-block col-md-2 float-right" type="button" data-dismiss="modal">Close</button>
				</div>
			</div>
</div>
<style type="text/css">
	.list-group-item>span>p{
		margin:unset;
	}
	.list-group-item>span>p>small{
		font-weight: 700
	}
	#uni_modal .modal-footer{
		display: none;
	}
	.alist,.dlist{
		width: 100%
	}
</style>
</div>
     
      </div>
    </div>
  </div>



<!-- Add Individual Deduction Modal -->
<div class="modal fade" id="addIndivDeductionModal" tabindex="-1" role="dialog" aria-labelledby="addIndivDeductionModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addIndivDeductionModalLabel">Add Individual Deduction</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="addDeductionForm">
                    <input type="hidden" id="selectedEmpId">
                    <div class="form-group">
                        <label for="deductionType">Deduction Type</label>
                        <select class="form-control" id="deductionType">
                            <!-- Options for deduction types will be populated here -->
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="deductionAmount">Amount</label>
                        <input type="number" class="form-control" id="deductionAmount" required>
                    </div>
                    <button type="button" id="saveIndividualDeduction" class="btn btn-primary">Save Deduction</button>
                </form>
            </div>
        </div>
    </div>
</div>




</div>

	<!-- Scripts -->
	<script src="https://cdn.jsdelivr.net/npm/jquery@2.2.4/dist/jquery.min.js"></script>
	<script src="https://cdn.jsdelivr.net/npm/popper.js@1.14.4/dist/umd/popper.min.js"></script>
	<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.1.3/dist/js/bootstrap.min.js"></script>
	<script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>

	<script>

		// Define the function outside of the $(document).ready() to make it globally accessible
		function viewEmployeePayrollDetails(empId) {
    // Get period_id from URL
    const urlParams = new URLSearchParams(window.location.search);
    const periodId = urlParams.get('period_id');

    // AJAX call to fetch payroll details
    $.ajax({
        url: 'view_payslip_custom.php', // Replace with the path to your PHP file
        type: 'GET',
        data: {
            emp_id: empId,
            period_id: periodId
        },
        success: function(response) {
            // Assuming response is a JSON object
            var data = JSON.parse(response); // Make sure the response is parsed correctly

            // Update payroll details in the modal
            $('#empIdViewModal').text(data.emp_id);
            $('#lnameViewModal').text(data.lname);
            $('#fnameViewModal').text(data.fname);
            $('#emppayIdViewModal').text(data.emppay_id);
            $('#payrollFromViewModal').text(data.period_from);
            $('#payrollToViewModal').text(data.period_to);
            $('#periodTypeViewModal').text(data.period_type);
            $('#basicSalaryViewModal').text(data.basic_salary);
            $('#hoursRenderedViewModal').text(data.hours_rendered);
            $('#otHours').text(data.ot_hrs);
            $('#otPayment').text(data.ot_payment);
            $('#grossPay').text(data.gross_pay);
            $('#netPay').text(data.net_pay);
			$('#deductionTotal').text(data.deductions_total);

            // Update deduction details
            if (data.deductions) {
                for (const [key, value] of Object.entries(data.deductions)) {
                    $(`#${key}Deduction`).text(value); // Update the modal with deduction values, assuming you have corresponding elements in your modal
                }
            }

            // Show the modal
            $('#viewEmployeePayrollModal').modal('show');
        },
        error: function(xhr, status, error) {
            // Handle errors
            console.error(error);
        }
    });
}


		function openAddIndivDeductionModal(empId) {
			// Get period_id from URL
			const urlParams = new URLSearchParams(window.location.search);
			const periodId = urlParams.get('period_id');

			// Store empId in a hidden input in your modal
			$('#selectedEmpId').val(empId);

			// Fetch deduction types
			$.ajax({
				url: "fetch-deduction-types.php",
				method: "GET",
				dataType: "json",
				success: function (response) {
					var deductionTypeSelect = $("#deductionType");
					deductionTypeSelect.empty();

					response.forEach(function (deductionType) {
						deductionTypeSelect.append(
							$('<option></option>').val(deductionType.dedtype_id).text(deductionType.deduction_type)
						);
					});

					// Now show the modal
					$('#addIndivDeductionModal').modal('show');
				},
				error: function (error) {
					console.error('Error fetching deduction types:', error);
				}
			});
		}

		$('#saveIndividualDeduction').on('click', function () {
			var empId = $('#selectedEmpId').val();
			var dedtypeId = $('#deductionType').val();
			var amount = $('#deductionAmount').val();
			const urlParams = new URLSearchParams(window.location.search);
			const periodId = urlParams.get('period_id');

			if (amount && dedtypeId) {
				var formData = {
					emp_id: empId,
					period_id: periodId,
					dedtype_id: dedtypeId,
					amount: amount
				};

				// AJAX request to save the deduction for the specific employee
				$.ajax({
					url: 'save-individual-deduction.php',
					type: 'POST',
					data: formData,
					success: function (response) {
						alert(response);
						$('#addIndivDeductionModal').modal('hide');
						// Optionally reload the table or update the UI
						window.location.reload();
					},
					error: function (error) {
						console.error('Error saving deduction:', error);
					}
				});
			} else {
				alert("Please select a deduction type and enter an amount.");
			}
		});













		$(document).ready(function () {
			var dataTable = $('#employeePayroll').DataTable({
				"ajax": {
					"url": "fetch-emp-paylist.php",
					"data": {
						"period_id": <?php echo $_GET['period_id']; ?> // Pass the period_id as a parameter
					},
					"type": "POST"
				},
				"columns": [
					{ "data": "emp_id" },
					{
						"data": null,
						"render": function (data, type, row) {
							return row.lname + ', ' + row.fname;
						}
					},
					{ "data": "basic_salary" },
					{ "data": "ot_payment" },
					{ "data": "gross_pay" }, // Add the new columns
					{ "data": "deductions_total" },
					{ "data": "net_pay" },
					{
						"render": function (data, type, row) {
						var viewButton = '<button class="btn btn-info btn-sm" onclick="viewEmployeePayrollDetails(' + row.emp_id + ')">View</button>';
						var addIndivDeductionButton = '<button class="btn btn-warning btn-sm" onclick="openAddIndivDeductionModal(' + row.emp_id + ')">Add Deduction</button>';
						return viewButton + addIndivDeductionButton;
					}
				}
				]
			});

			// Add event listener for opening and closing details
			$('#employeePayroll tbody').on('click', 'td.details-control', function () {
				var tr = $(this).closest('tr');
				var row = dataTable.row(tr);

				if (row.child.isShown()) {
					// This row is already open - close it
					row.child.hide();
					tr.removeClass('shown');
				} else {
					// Open this row
					row.child(format(row.data())).show();
					tr.addClass('shown');
				}
			});
		});
	</script>

<script>
	$(document).ready(function () {

		$('#deductionType_salary_advance').change(function () {
			$('#salaryAdvanceAmount').prop('disabled', !this.checked);
		});

		// Handle checkbox changes for Other
		$('#deductionType_other').change(function () {
			$('#otherDeductionAmount').prop('disabled', !this.checked);
		});


		$('#addDeductionBtn').click(function () {
			// Fetch employee names
			$.ajax({
				url: "fetch-employee-names.php",
				method: "GET",
				dataType: "json",
				data: {
					"period_id": <?php echo $_GET['period_id']; ?> // Include the period_id in the request
				},
				success: function (response) {
					if (Array.isArray(response) && response.length > 0) {
						// Populate the employee list with checkboxes
						var employeeListContainer = $("#employeeListContainer");
						employeeListContainer.empty(); // Clear existing content

						// Add "Select All" option
						var selectAllCheckbox = $("<input>", {
							type: "checkbox",
							id: "selectAllEmployees"
						});
						var selectAllLabel = $("<label>", {
							text: " Select All"
						});
						employeeListContainer.append(selectAllCheckbox);
						employeeListContainer.append(selectAllLabel);
						employeeListContainer.append("<br>");

						// Add individual employee checkboxes
						response.forEach(function (employee) {
							var checkbox = $("<input>", {
								type: "checkbox",
								name: "selectedEmployees[]",
								value: employee.emp_id,
								"data-emppay-id": employee.emppay_id, // Add the data attribute
								"data-basic-salary": employee.basic_salary // Add the data attribute for basic_salary
							});
							var label = $("<label>", {
								text: employee.lname + ', ' + employee.fname
							});
							employeeListContainer.append(checkbox);
							employeeListContainer.append(label);
							employeeListContainer.append("<br>");
						});

						// Handle "Select All" functionality
						$("#selectAllEmployees").on("change", function () {
							var isChecked = $(this).prop("checked");
							$("input[name='selectedEmployees[]']").prop("checked", isChecked);

							// Get the values of all checked checkboxes
							var selectedEmployeeData = [];
							$("input[name='selectedEmployees[]']:checked").each(function () {
								selectedEmployeeData.push({
									emp_id: $(this).val(),
									emppay_id: $(this).data("emppay-id"), // Add the data attribute
									basic_salary: $(this).data("basic-salary") // Add the data attribute for basic_salary
								});
							});
							console.log("Selected Employee Data:", selectedEmployeeData);
						});

						// Handle individual checkbox clicks
						$("input[name='selectedEmployees[]']").on("change", function () {
							// Get the values of all checked checkboxes
							var selectedEmployeeData = [];
							$("input[name='selectedEmployees[]']:checked").each(function () {
								selectedEmployeeData.push({
									emp_id: $(this).val(),
									emppay_id: $(this).data("emppay-id"), // Add the data attribute
									basic_salary: $(this).data("basic-salary") // Add the data attribute for basic_salary
								});
							});
							console.log("Selected Employee Data:", selectedEmployeeData);
						});
					} else {
						console.error('Invalid response for employee data:', response);
					}
				},
				error: function (error) {
					console.log(error);
				}
			});
		});

			// Fetch deduction types
			$.ajax({
				url: "fetch-deduction-types.php",
				method: "GET",
				dataType: "json",
				success: function (response) {
					if (Array.isArray(response) && response.length > 0) {
						// Populate the deduction type list with checkboxes
						var deductionTypeListContainer = $("#deductionTypeListContainer");
						deductionTypeListContainer.empty(); // Clear existing content

						response.forEach(function (deductionType) {
							var checkbox = $("<input>", {
								type: "checkbox",
								class: "form-check-input",
								value: deductionType.dedtype_id,
								id: "deductionType_" + deductionType.dedtype_id,
								name: "deductionTypeList[]"
							});
							var label = $("<label>", {
								class: "form-check-label",
								text: deductionType.deduction_type,
								for: "deductionType_" + deductionType.dedtype_id
							});

							var checkboxContainer = $("<div>", { class: "form-check" });
							checkboxContainer.append(checkbox);
							checkboxContainer.append(label);

							deductionTypeListContainer.append(checkboxContainer);

							// Add percentage field if applicable
							if (deductionType.has_percentage) {
								var percentageInput = $("<input>", {
									type: "text",
									class: "form-control",
									id: "percentage_" + deductionType.dedtype_id,
									placeholder: "Enter percentage"
								});
								var percentageLabel = $("<label>", {
									class: "mt-2",
									text: "Percentage:"
								});

								deductionTypeListContainer.append(percentageLabel);
								deductionTypeListContainer.append(percentageInput);
							}
						});
					}

					// Updated code for handling checkbox changes in deduction types
					$("input[name='deductionTypeList[]']").on("change", function () {
						// Get the values of the selected deduction types
						var selectedDeductionTypes = $("input[name='deductionTypeList[]']:checked").map(function () {
							return $(this).val();
						}).get();

						// Log selected deduction types to console for debugging
						console.log("Selected Deduction Types:", selectedDeductionTypes);

						// Check if any selected deduction type has a percentage field
						selectedDeductionTypes.forEach(function (deductionType) {
							// Get the percentage amount directly from the deduction type data
							var percentageAmount = parseFloat($("#percentage_" + deductionType).data("percentage-amount"));

							if (!isNaN(percentageAmount) && percentageAmount > 0) {
								// Create an array to hold deduction details
								var deductionDetails = [];

								// Calculate deduction amount for each selected employee
								$("input[name='selectedEmployees[]']:checked").each(function () {
									var empId = $(this).val();
									var empPayId = $(this).data('emppay-id');
									var basicSalary = parseFloat($(this).data('basic-salary'));

									// Check if basicSalary is a valid number
									if (!isNaN(basicSalary) && basicSalary > 0) {
										// Create an object for each employee with deduction details
										var employeeDeduction = {
											emp_id: empId,
											emppay_id: empPayId,
											deductionType: deductionType,
											deductionAmount: basicSalary * (percentageAmount * 0.01)
										};

										// Push the employee deduction object to the array
										deductionDetails.push(employeeDeduction);

										// Log the deduction amount for each employee
										console.log("Deduction Amount for employee " + empId + ": " + employeeDeduction.deductionAmount);
									} else {
										// Log an error if basicSalary is not a valid number
										console.error("Error: Invalid basic salary for employee " + empId);
									}
								});

								// Log or use deductionDetails array as needed
								console.log("Deduction Details:", deductionDetails);

								// Proceed with the AJAX request using deductionDetails
								$.ajax({
									url: 'save-deduction.php', // Replace with your backend endpoint
									type: 'POST',
									data: { deductionDetails: deductionDetails },
									success: function (response) {
										alert(response);
										$('#addDeductionModal').modal('hide');
									},
									error: function (error) {
										console.log(error);
									}
								});
							}
						});
					});
				}
			});

			// Inside the saveDeduction click event handler
			$('#saveDeduction').on('click', function () {
				// Get selected deduction types
				var selectedDeductionTypes = $("input[name='deductionTypeList[]']:checked").map(function () {
					return $(this).val();
				}).get();

				// Log values to console for debugging
				console.log('Selected Deduction Types:', selectedDeductionTypes);

				// Check if the deduction types array is non-empty
				if (selectedDeductionTypes.length > 0) {
					// Log a message indicating that the condition is met
					console.log('Condition met - proceeding with AJAX request');

					// Create an object to hold the form data
					var formData = {
						period_id: <?php echo $_GET['period_id']; ?>,
						deductionTypeList: selectedDeductionTypes,
						// Add other form fields if needed
					};

					// Log formData to console for debugging
					console.log('Form Data:', formData);

					// Make the AJAX request
					$.ajax({
						url: 'save-deduction.php', // Replace with your backend endpoint
						type: 'POST',
						data: formData,
						success: function (response) {
							alert(response);
							$('#addDeductionModal').modal('hide');
							location.reload()
						},
						error: function (error) {
							console.log(error);
						}
					});
				} else {
					// Log a message indicating that the condition is not met
					console.log('Condition not met - alerting user');

					alert("Please select at least one deduction type.");
				}
			});



			
		});


</script>
</body>
</html>
