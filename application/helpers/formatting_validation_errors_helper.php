<?php
defined('BASEPATH') or exit('No direct script access allowed');
/**
 * Mempersingkat baris formating form validation_errors untuk Notify JS message
 * 
 * @param object $errors - form validation_errors(' ', ' ')
 * @return string HTML formatted string, newline replace by <br>
 */
if (!function_exists('formatting_validation_errors')) {

  function formatting_validation_errors($errors) {
    $errors = trim(preg_replace('/\s+/', ' ', $errors)); // replace one or more newline with space
    $errors = explode('. ', $errors);
    $errors = implode('<br>', $errors);
    return $errors;
  }

}