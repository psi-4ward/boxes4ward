<?php

$DB = \Database::getInstance();

if($DB->fieldExists('do', 'tl_content') && $DB->fieldExists('ptable', 'tl_content')) {
    $DB->execute('UPDATE tl_content SET ptable=do WHERE ptable="" AND do="boxes4ward"');
}
