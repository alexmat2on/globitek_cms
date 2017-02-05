<?php
  require_once('../private/initialize.php');

  // Set default values for all variables the page needs.
  $firstname = isset($_POST['firstname']) ? $_POST['firstname'] : '';
  $lastname = isset($_POST['lastname']) ? $_POST['lastname'] : '';
  $email = isset($_POST['email']) ? $_POST['email'] : '';
  $username = isset($_POST['username']) ? $_POST['username'] : '';

  $errors = []; 
  // if this is a POST request, process the form
  // Hint: private/functions.php can help 
  if(is_post_request()) {
    // Confirm that POST values are present before accessing them.
    // Perform Validations
    // Hint: Write these in private/validation_functions.php

    // Validate First Name	  
    if(is_blank($firstname)) {
	    $errors[] = "First name cannot be blank.";
    } elseif (!has_length($firstname, ['min' => 2, 'max' => 255])) {
            $errors[] = "First name must be between 2 and 255 characters.";
    } elseif (!preg_match('/\A[A-Za-z\s\-,\.\']+\Z/', $firstname)) {
	    $errors[] = "First name can only contain upper and lower case letters, spaces, and the symbols:  - , . '";
    }

    // Validate Last Name
    if (is_blank($lastname)) {
            $errors[] = "Last name cannot be blank.";
    } elseif (!has_length($lastname, ['min' => 2, 'max' => 255])) {
            $errors[] = "Last name must be between 2 and 255 characters.";
    } elseif (!preg_match('/\A[A-Za-z\s\-,\.\']+\Z/', $lastname)) {
	    $errors[] = "First name can only contain upper and lower case letters, spaces, and the symbols:  - , . '";
    }
 

    // Validate Email Address
    if (is_blank($email)) {
        $errors[] = "Email cannot be blank.";
    } elseif (!has_length($email, ['min' => 2, 'max' => 255])) {
        $errors[] = "Email must be between 2 and 255 characters.";
    } elseif (!has_valid_email_format($email)) {
	$errors[] = "Email is not a valid email format.";
    } elseif (!preg_match('/\A[A-Za-z0-9\@\.]+\Z/', $email)) {
	    $errors[] = "Email can only contain upper and lower case letters, numbers and the symbols: @";
    }


    // Validate Username
    if (is_blank($username)) {
        $errors[] = "Username cannot be blank.";
    } elseif (!has_length($username, ['min' => 8, 'max' => 255])) {
        $errors[] = "Username must be between 8 and 255 characters.";
    } elseif (!preg_match('/\A[A-Za-z0-9\s_\']+\Z/', $username)) {
	    $errors[] = "Username can only contain upper and lower case letters, numbers and underscores";
    } 

    // if there were no errors, submit data to database
    if (count($errors) == 0) {
	    
      // Write SQL INSERT statement
      $date = date('Y-m-d H:i:s');
      $sql = "INSERT INTO users (first_name, last_name, email, username, created_at)
	      VALUES('{$firstname}','{$lastname}','{$email}','{$username}','{$date}')";

      // For INSERT statments, $result is just true/false
      $result = db_query($db, $sql);
      if($result) {
         db_close($db);

      //   TODO redirect user to success page
	redirect_to("registration_success.php");
      } else {
     //   // The SQL INSERT statement failed.
      //   // Just show the error, not the form
         echo db_error($db);
         db_close($db);
         exit;
      }
    }
  }
?>

<?php $page_title = 'Register'; ?>
<?php include(SHARED_PATH . '/header.php');?>

<div id="main-content">
  <h1>Register</h1>
  <p>Register to become a Globitek Partner.</p>

  <?php
    // TODO: display any form errors here
    // Hint: private/functions.php can help
    echo display_errors($errors);
  ?>

  <!-- TODO: HTML form goes here -->
  <form action="register.php" method="post">
	First Name:<br>
	<input type="text" name="firstname" value=<?php echo h($firstname); ?>><br><br>
	Last name:<br>
	<input type="text" name="lastname" value=<?php echo h($lastname); ?>><br><br>
	Email:<br>
	<input type="text" name="email" value=<?php echo h($email); ?>><br><br>
	Username:<br>
	<input type="text" name="username" value=<?php echo h($username); ?>><br><br>
	<input type="submit" value="Submit"><br>
   </form>
  
</div>

<?php include(SHARED_PATH . '/footer.php'); ?>

