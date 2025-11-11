<?php

// Define 'url' with a sample URL containing a scheme, host, path, and query.
$url = "https://www.example.com/search?q=php+functions&lang=en";

// Use 'parse_url' to split the URL into its components.
$parsedUrl = parse_url($url);

// Display the scheme (protocol) of the URL.
echo "Scheme: " . $parsedUrl['scheme'] . "<br>";

// Display the host (domain) of the URL.
echo "Host: " . $parsedUrl['host'] . "<br>";

// Display the path of the URL.
echo "Path: " . $parsedUrl['path'] . "<br>";

// Display the query parameters of the URL.
echo "Query: " . $parsedUrl['query'];
