<?php
// Include config file
require_once "config.php";
 
// Define variables and initialize with empty values
$fname = $lname=$tname= ""; 
$fname_err =$lname_err =$tname_err = "";
 
// Processing form data when form is submitted
if($_SERVER["REQUEST_METHOD"] == "POST"){
    // Validate name
    $gname =intval($_POST["gname"]);
     $input_fname = trim($_POST["fname"]);
    if(empty($input_fname)){
        $fname_err = "Please enter a first name.";
    } elseif(!filter_var($input_fname, FILTER_VALIDATE_REGEXP, array("options"=>array("regexp"=>"/^[a-zA-Z\s]+$/")))){
        $fname_err = "Please enter a valid first name.";
    } else{
        $fname = $input_fname;
    }
    
    // Validate name
    $input_lname = trim($_POST["lname"]);
    if(empty($input_lname)){
        $name_err = "Please enter a last name.";
    } elseif(!filter_var($input_lname, FILTER_VALIDATE_REGEXP, array("options"=>array("regexp"=>"/^[a-zA-Z\s]+$/")))){
        $lname_err = "Please enter a valid last name.";
    } else{
        $lname = $input_lname;
    }
     // Validate name
    $input_tname = trim($_POST["tname"]);
    if(empty($input_tname)){
        $tname_err = "Please enter a town name.";
    } elseif(!filter_var($input_tname, FILTER_VALIDATE_REGEXP, array("options"=>array("regexp"=>"/^[a-zA-Z\s]+$/")))){
        $tname_err = "Please enter a valid town name.";
    } else{
        $tname = $input_tname;
    }
            // Prepare an insert statement
     
     
    // Check input errors before inserting in database
  if(empty($fname_err) && empty($lname_err) && empty($tname_err) && ($gname==1|| $gname==2)){
       echo  $sql = "INSERT INTO customer (first_name, last_name, town_name,gender_id) VALUES ('".$fname."','".$lname."','".$tname."','".$gname."')";
             
   if(mysqli_query($link, $sql)){
    echo "Records inserted successfully.";
} else{
    echo "ERROR: Could not able to execute $sql. " . mysqli_error($link);
}
 
// Close connection
mysqli_close($link);
           
            
            // Attempt to execute the prepared statement
            
   }else{
      echo "Invalid data";
  }
         
       
    
    
    // Close connection
}
?>
 
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Create Customer</title>
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
                        <h2>Create Customer</h2>
                    </div>
                    <p>Please fill this form and submit to add Customer  to the database.</p>
                    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
                        <div class="form-group <?php echo (!empty($fname_err)) ? 'has-error' : ''; ?>">
                            <label>First Name</label>
                            <input type="text" name="fname" class="form-control" required value="<?php echo $fname; ?>">
                            <span class="help-block"><?php echo $fname_err;?></span>
                        </div>
                       <div class="form-group <?php echo (!empty($lname_err)) ? 'has-error' : ''; ?>">
                            <label>Last Name</label>
                            <input type="text" name="lname" class="form-control" required value="<?php echo $lname; ?>">
                            <span class="help-block"><?php echo $lname_err;?></span>
                        </div>
                        <div class="form-group <?php echo (!empty($tname_err)) ? 'has-error' : ''; ?>">
                            <label>Town Name</label>
                            <input type="text" name="tname" class="form-control" required value="<?php echo $tname; ?>">
                            <span class="help-block"><?php echo $tname_err;?></span>
                        </div>
                        <div class="form-group">                
                                                          
                  <select type="text" name="gname" class="form-control" required>   
                      <option value="">Select Gender</option>
                        <option value="2">Female</option>
                        <option value="1">Male</option>
                     </select>
                        </div>
                        <input type="submit" class="btn btn-primary" value="Submit">
                        <a href="index.php" class="btn btn-default">Cancel</a>
                    </form>
                </div>
            </div>        
        </div>
    </div>
</body>
</html>