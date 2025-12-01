<?php
function groupEmailsByDomain($emails) {
    $grouped = []; 
    foreach ($emails as $email) {
        $domain = explode('@', $email)[1];
        $grouped[$domain][] = $email;
    }
    return $grouped;
}

$emails = [
    "alice@example.com",
    "bob@test.com",
    "carol@example.com",
    "dave@test.com",
    "eve@sample.com"
];

$groupedEmails = groupEmailsByDomain($emails);

foreach ($groupedEmails as $domain => $group) {
    echo "Domain: $domain\n";
    echo "Emails: " . implode(", ", $group) . "\n\n";
}
?>