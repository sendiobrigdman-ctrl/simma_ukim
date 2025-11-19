<?php
$path = __DIR__ . '/../app/Models/User.php';
if (!file_exists($path)) {
    echo "MISSING\n";
    exit(1);
}
$s = file_get_contents($path);
$first = strpos($s, '<?php');
$second = false;
if ($first !== false) {
    $second = strpos($s, '<?php', $first + 5);
}
if ($second !== false) {
    // Keep only up to just before the second php tag
    $new = substr($s, 0, $second);
    file_put_contents($path, $new);
    echo "TRUNCATED\n";
    exit(0);
}
echo "NO_CHANGE\n";
