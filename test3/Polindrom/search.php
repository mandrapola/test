<?php
require_once 'FinderPolindrom.php';

$arg = getopt('', ['text:']);
$text = $arg['text'] ?? null;
if (null === $text) {
    exit("Отсутствует параметр text\n");
}
$finder = new FinderPolindrom();
$finder->setText($text);
$finder->search();
echo "***********************\n";
echo $finder->getPolindrom()."\n";
echo "***********************\n";
