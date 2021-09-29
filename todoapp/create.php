<?php
// Include config file
require_once "config.php";
 
// Define variables and initialize with empty values
$name = $address = $designation = $department = $employee_status = $salary = "";
$name_err = $address_err = $designation_err = $department_err = $employee_status_err = $salary_err = "";
 
// Processing form data when form is submitted
if($_SERVER["REQUEST_METHOD"] == "POST"){
    // Validate name
    $input_name = trim($_POST["name"]);
    if(empty($input_name)){
        $name_err = "Please enter a name.";
    } elseif(!filter_var($input_name, FILTER_VALIDATE_REGEXP, array("options"=>array("regexp"=>"/^[a-zA-Z\s]+$/")))){
        $name_err = "Please enter a valid name.";
    } else{
        $name = $input_name;
    }
    
    // Validate address
    $input_address = trim($_POST["address"]);
    if(empty($input_address)){
        $address_err = "Please enter an address.";     
    } else{
        $address = $input_address;
    }

    //Validate designation
    $input_designation = trim($_POST["designation"]);
    if(empty($input_designation)){
        $designation_err = "Please enter your designation.";
    } else{
        $designation = $input_designation;
    }

     //Validate Department
    $input_department = trim($_POST["department"]);
    if(empty($input_department)){
        $department_err = "Please enter your department.";
    } else{
        $department = $input_department;
    }

    //Validate Employee Status
    $input_employee_status = trim($_POST["employee_status"]);
    if(empty($input_employee_status)){
        $employee_status_err = "Please enter your employee status.";
    } else{
        $employee_status = $input_employee_status;
    }
    
    // Validate salary
    $input_salary = trim($_POST["salary"]);
    if(empty($input_salary)){
        $salary_err = "Please enter the salary amount.";     
    } elseif(!ctype_digit($input_salary)){
        $salary_err = "Please enter a positive integer value.";
    } else{
        $salary = $input_salary;
    }
    
    // Check input errors before inserting in database
    if(empty($name_err) && empty($address_err) && empty($designation_err) && empty($department_err) && empty($employee_status_err) && empty($salary_err)){
        // Prepare an insert statement
        $sql = "INSERT INTO employees (name, address, designation, department, employee_status, salary) VALUES (?, ?, ?, ?, ?, ?)";
         
        if($stmt = mysqli_prepare($link, $sql)){
            // Bind variables to the prepared statement as parameters
            mysqli_stmt_bind_param($stmt, "ssssss", $param_name, $param_address, $param_designation, $param_department, $param_employee_status, $param_salary);
            
            // Set parameters
            $param_name = $name;
            $param_address = $address;
            $param_designation = $designation;
            $param_department = $department;
            $param_employee_status = $employee_status;
            $param_salary = $salary;
            
            // Attempt to execute the prepared statement
            if(mysqli_stmt_execute($stmt)){
                // Records created successfully. Redirect to landing page
                header("location: index.php");
                exit();
            } else{
                echo "Oops! Something went wrong. Please try again later.";
            }
        }
         
        // Close statement
        mysqli_stmt_close($stmt);
    }
    
    // Close connection
    mysqli_close($link);
}
?>
 
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Create Record</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
    body{
        background: linear-gradient(135deg, #1cd8d2, #93edc7);
    }
        .wrapper{
            width: 600px;
            margin: 0 auto;
            box-shadow: 4px 4px 20px 0px #0000003d;
            border-radius: 20px;
            
        }
        .wrapper:hover{
            box-shadow: 4px 4px 20px 0px #0000003d;
        }
    </style>
</head>
<body>
    <div class="wrapper">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <h2 class="mt-5">Create Record</h2>
                    <p>Please fill this form and submit to add employee record to the database.</p>
                    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
                        <div class="form-group">
                            <label>Name</label>
                            <input type="text" name="name" class="form-control <?php echo (!empty($name_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $name; ?>">
                            <span class="invalid-feedback"><?php echo $name_err;?></span>
                        </div>
                        <div class="form-group">
                            <label>Address</label>
                            <textarea name="address" class="form-control <?php echo (!empty($address_err)) ? 'is-invalid' : ''; ?>"><?php echo $address; ?></textarea>
                            <span class="invalid-feedback"><?php echo $address_err;?></span>
                        </div>
                        <div class="form-group">
                            <label>Designation</label>
                            <textarea name="designation" class="form-control <?php echo (!empty($designation_err)) ? 'is-invalid' : ''; ?>"><?php echo $designation; ?></textarea>
                            <span class="invalid-feedback"><?php echo $designation_err;?></span>
                        </div>
                        <div class="form-group">
                            <label>Department</label>
                            <textarea name="department" class="form-control <?php echo (!empty($department_err)) ? 'is-invalid' : ''; ?>"><?php echo $department; ?></textarea>
                            <span class="invalid-feedback"><?php echo $department_err;?></span>
                        </div>
                        <div class="form-group">
                            <label>Employee Status</label>
                            <textarea name="employee_status" class="form-control <?php echo (!empty($employee_status_err)) ? 'is-invalid' : ''; ?>"><?php echo $employee_status; ?></textarea>
                            <span class="invalid-feedback"><?php echo $employee_status_err;?></span>
                        </div>
                        <div class="form-group">
                            <label>Salary</label>
                            <input type="text" name="salary" class="form-control <?php echo (!empty($salary_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $salary; ?>">
                            <span class="invalid-feedback"><?php echo $salary_err;?></span>
                        </div>
                        <input type="submit" class="btn btn-primary" value="Submit">
                        <a href="index.php" class="btn btn-secondary ml-2">Cancel</a>
                    </form>
                </div>
            </div>        
        </div>
    </div>
</body>
</html>