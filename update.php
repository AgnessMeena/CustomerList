<?php
// Include config file
require_once "config.php";
 
// Define variables and initialize with empty values
$fname = $lname=$tname= ""; 
$fname_err =$lname_err=$tname_err = "";

// Processing form data when form is submitted
if(isset($_POST["id"]) && !empty($_POST["id"])){
    // Get hidden input value
    $id = $_POST["id"];
    
        $gname =intval($_POST["gname"]);
    // Validate first name
    $input_fname = trim($_POST["fname"]);
    if(empty($input_fname)){
        $fname_err = "Please enter a first name.";
    } elseif(!filter_var($input_fname, FILTER_VALIDATE_REGEXP, array("options"=>array("regexp"=>"/^[a-zA-Z\s]+$/")))){
        $fname_err = "Please enter a valid first name.";
    } else{
        $fname = $input_fname;
    }
    
    // Validate last name
    $input_lname = trim($_POST["lname"]);
    if(empty($input_lname)){
        $lname_err = "Please enter a last name.";
    } elseif(!filter_var($input_lname, FILTER_VALIDATE_REGEXP, array("options"=>array("regexp"=>"/^[a-zA-Z\s]+$/")))){
        $lname_err = "Please enter a valid last name.";
    } else{
        $lname = $input_lname;
    }
    
     // Validate town name
    $input_tname = trim($_POST["tname"]);
    if(empty($input_tname)){
        $tname_err = "Please enter a town name.";
    } elseif(!filter_var($input_tname, FILTER_VALIDATE_REGEXP, array("options"=>array("regexp"=>"/^[a-zA-Z\s]+$/")))){
        $tname_err = "Please enter a valid town name.";
    } else{
        $tname = $input_tname;
    }
    
    
   
    // Check input errors before inserting in database
   // if(empty($fname_err) && empty($lname_err) && empty(tname_err)){
        // Prepare an update statement
        $sql = "UPDATE customer SET first_name=?, last_name=?, town_name=?, gender_id=? WHERE id=?";
        
         
        if($stmt = mysqli_prepare($link, $sql)){
            // Bind variables to the prepared statement as parameters
            mysqli_stmt_bind_param($stmt, "sssi", $param_fname, $param_lname, $param_tname, $param_gname);
            
            // Set parameters
            $param_fname = $fname;
            $param_lname = $lname;
            $param_tname = $tname;
            $param_gname = $gname;
           
            
            // Attempt to execute the prepared statement
            if(mysqli_stmt_execute($stmt)){
                // Records updated successfully. Redirect to landing page
                header("location: index.php");
                exit();
            } else{
                echo "Something went wrong. Please try again later.";
            }
     //   }
         
        // Close statement
        mysqli_stmt_close($stmt);
    }
    
    // Close connection
    mysqli_close($link);
} else{
    // Check existence of id parameter before processing further
    if(isset($_GET["id"]) && !empty(trim($_GET["id"]))){
        // Get URL parameter
        $id =  trim($_GET["id"]);
        
        // Prepare a select statement
        $sql = "select  customer.id,customer.first_name,customer.last_name,customer.town_name,Gender.gender_name,customer.gender_id from customer customer, gender Gender where customer.gender_id = Gender.id and customer.id = ?";
        if($stmt = mysqli_prepare($link, $sql)){
            // Bind variables to the prepared statement as parameters
            mysqli_stmt_bind_param($stmt, "i", $param_id);
            
            // Set parameters
            $param_id = $id;
            
            // Attempt to execute the prepared statement
            if(mysqli_stmt_execute($stmt)){
                $result = mysqli_stmt_get_result($stmt);
    
                if(mysqli_num_rows($result) == 1){
                    /* Fetch result row as an associative array. Since the result set contains only one row, we don't need to use while loop */
                    $row = mysqli_fetch_array($result, MYSQLI_ASSOC);
                  //  print_r($row);
                    
                    // Retrieve individual field value
                    $fname = $row["first_name"]; 
                     $lname = $row["last_name"];
                     $tname = $row["town_name"];
                      $gid = $row["gender_id"];
                      $gname = $row["gender_name"];
                    
                } else{
                    // URL doesn't contain valid id. Redirect to error page
                    header("location: error.php");
                    exit();
                }
                
            } else{
                echo "Oops! Something went wrong. Please try again later.";
            }
        }
        
        // Close statement
        mysqli_stmt_close($stmt);
        
        // Close connection
        mysqli_close($link);
    }  else{
        // URL doesn't contain id parameter. Redirect to error page
        header("location: error.php");
        exit();
    }
}
?>
 
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Update Record</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.css">
    <style type="text/css">
        .wrapper{
            width: 500px;
            margin: 0 auto;
        }
    </style>
</head>
<body>
    <div class="wrapper">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <div class="page-header">
                        <h2>Update Record</h2>
                    </div>
                    <p>Please edit the input values and submit to update the record.</p>
                    <form action="<?php echo htmlspecialchars(basename($_SERVER['REQUEST_URI'])); ?>" method="post">
                        <div class="form-group <?php echo (!empty($name_err)) ? 'has-error' : ''; ?>">
                            <label>First Name</label>
                            <input type="text" name="fname" class="form-control" required value="<?php echo $fname; ?>">
                            <span class="help-block"><?php echo $name_err;?></span>
                        </div>
                         <div class="form-group <?php echo (!empty($name_err)) ? 'has-error' : ''; ?>">
                            <label>Last Name</label>
                            <input type="text" name="lname" class="form-control" requi  red value="<?php echo $lname; ?>">
                            <span class="help-block"><?php echo $name_err;?></span>
                        </div>
                         <div class="form-group <?php echo (!empty($name_err)) ? 'has-error' : ''; ?>">
                            <label>Town Name</label>
                            <input type="text" name="tname" class="form-control" required value="<?php echo $tname; ?>">
                            <span class="help-block"><?php echo $name_err;?></span>
                        </div>
                      
                    <div class="form-group">                
                                                          
                  <select type="text" name="gname" class="form-control" required>   
                      <option selected value="<?php echo $gid; ?>"> <?php echo $gname; ?></option>
                        <option value="2">Female</option>
                        <option value="1">Male</option>
                     </select>
                        </div>
                        <input type="hidden" name="id" value="<?php echo $id; ?>"/>
                        <input type="submit" class="btn btn-primary" value="Submit">
                        <a href="index.php" class="btn btn-default">Cancel</a>
                    </form>
                </div>
            </div>        
        </div>
    </div>
</body>
</html>