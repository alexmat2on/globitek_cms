<?php

  // is_blank('abcd')
  function is_blank($value='') {
	  return !isset($value) || trim($value) == '';
  }

  // has_length('abcd', ['min' => 3, 'max' => 5])
  function has_length($value, $options=array()) {
	  $length = strlen($value);
	      if(isset($options['max']) && ($length > $options['max'])) {
		      return false;
	      } elseif(isset($options['min']) && ($length < $options['min'])) {
	              return false;
	      } elseif(isset($options['exact']) && ($length != $options['exact'])) {
		      return false;
	      } else {
	              return true;
	      }
  }

  // has_valid_email_format('test@test.com')
  function has_valid_email_format($value) {
	  $is_email = false;
	  for($i = 0; $i < strlen($value); $i++) {
		  if($value[$i] == '@' and $i > 0) $is_email = true;
	  }
	  return $is_email;
  }

?>
