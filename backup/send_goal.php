<?php
require __DIR__ . '/vendor/autoload.php';

use Ratchet\Client\Connector;
use React\EventLoop\Factory;

$loop = Factory::create();
$connector = new Connector($loop);

$connector('ws://192.168.123.118:9090')->then(function($conn) use ($loop) {
    $goal = [
        'goal' => [
            'target_pose' => [
                'header' => [
                    'frame_id' => 'map'
                ],
                'pose' => [
                    'position' => [
                        'x' => 1.0,
                        'y' => 1.0,
                        'z' => 0.0
                    ],
                    'orientation' => [
                        'x' => 0.0,
                        'y' => 0.0,
                        'z' => 0.0,
                        'w' => 1.0
                    ]
                ]
            ]
        ]
    ];

    $msg = json_encode([
        'op' => 'publish',
        'topic' => '/move_base/goal',
        'msg' => $goal
    ]);

    $conn->send($msg);
    $conn->close();
    $loop->stop();
}, function ($e) use ($loop) {
    echo "Could not connect: {$e->getMessage()}\n";
    $loop->stop();
});

$loop->run();
