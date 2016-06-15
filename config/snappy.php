<?php

/*return array(


    'pdf' => array(
        'enabled' => ,
        'binary' => '/usr/local/bin/wkhtmltopdf',
        'timeout' => ,
        'options' => array(),
    ),
    'image' => array(
        'enabled' => ,
        'binary' => '/usr/local/bin/wkhtmltoimage',
        'timeout' => ,
        'options' => array(),
    ),


);*/

return array(


    'pdf' => array(
        'enabled' => true,
        'binary' => "\"C:\\Program Files\\wkhtmltopdf\\bin\\wkhtmltopdf.exe\"",
        'timeout' => false,
        'options' => array(),
    ),
    'image' => array(
        'enabled' => true,
        'binary' => "\"C:\\Program Files\\wkhtmltopdf\\bin\\wkhtmltoimage.exe\"",
        'timeout' => false,
        'options' => array(),
    ),


);
