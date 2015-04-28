<?php
return [
    'module'   => array(
        'class'  => 'application.modules.poll.PollModule',
    ),
    'import' => [
        'application.modules.poll.models.*',
    ],
    'rules'     => array(
        '/poll' => 'poll/default/index',
    ),
    'component' => array()
]
?>