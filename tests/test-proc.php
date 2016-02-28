<?php

$spec = [
    0 => ['pipe', 'r'], // STDIN  for child process
    1 => ['pipe', 'w'], // STDOUT for child process
    2 => ['pipe', 'w'], // STDERR for child process
];
$pipes = [];

$env = [
    'REDIRECT_STATUS' => 'CGI',
    'CONTENT_LENGTH'  => 0,
    'REQUEST_METHOD'  => 'GET',
    'SCRIPT_FILENAME' => 'tests/app.php',
    'QUERY_STRING'    => '',
];

$proc = proc_open('php-cgi', $spec, $pipes, getcwd(), $env);

$ret    = 0;
$stdout = '';
$stderr = '';

if (is_resource($proc)) {
    fwrite($pipes[0], '');
    fclose($pipes[0]);

    $stdout = stream_get_contents($pipes[1]);
    fclose($pipes[1]);

    $stderr = stream_get_contents($pipes[2]);
    fclose($pipes[2]);
}

echo "\n\n=== STDOUT:\n";
echo $stdout;

echo "\n\n===STDERR: \n";
echo $stderr;
