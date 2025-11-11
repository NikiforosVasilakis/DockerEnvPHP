<?php

// Define a base coupon code.
$code = "SAVE";

// Append a random number between 100 and 999 to the base code using 'rand'.
echo "Coupon Code: " . $code . rand(100, 999);
