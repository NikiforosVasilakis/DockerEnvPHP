<?php

// Define 'price' with a decimal value.
$price = 1234.567;

// Format 'price' to two decimal places with a comma as a decimal point and period as a thousand separator.
echo "Price: $" . number_format($price, 2, ",", ".");
