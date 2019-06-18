<?php
function clearBracket($text) {
    return preg_replace('/\)\)+/',')',$text);
}