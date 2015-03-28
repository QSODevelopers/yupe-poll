<?php
return [
    'module'   => array(
        'class'  => 'application.modules.poll.PollModule',
    ),
    'import' => [
        'application.modules.poll.models.*',
        'application.modules.poll.components.*',
    ],
    'rules'     => array(
        '/poll' => '/poll/default/index',
    ),
    'component' => array()
]
?>