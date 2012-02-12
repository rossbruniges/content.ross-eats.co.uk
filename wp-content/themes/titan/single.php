<?php
  if (in_category('Reviews')) {
    include 'single-review.php';
  } elseif (in_category('London Burritos')) {
      include 'single-burrito.php';
  } else {
    include 'single-standard.php';
  }
?>