<?php
function getJson()
{
    $json = [
        [
            'type' => 'div',
            'value' => 'main div',
            'styles' => [
                'cssClass' => 'container text-center'
            ],
            'blocks' => [
                /* IMAGE */
                [
                    'type' => 'div',
                    'styles' => [
                        'cssClass' => '',
                        'cssText' => 'margin-bottom: 20px;'
                    ],
                    'blocks' => [
                        [
                            'type' => 'image',
                            'styles' => [
                                'cssClass' => ''
                            ],
                            'src' => 'https://www.google.com/images/branding/googlelogo/2x/googlelogo_color_120x44dp.png'
                        ]
                    ]
                ],
                /* INPUT */
                [
                    'type' => 'div',
                    'styles' => [
                        'cssClass' => '',
                        'cssText' => 'margin-bottom: 10px;'
                    ],
                    'blocks' => [
                        [
                            'type' => 'inputtext',
                            'styles' => [
                                'cssClass' => 'form-control'
                            ]
                        ]
                    ]
                ],
                [
                    'type' => 'div',
                    'styles' => [
                        'cssClass' => '',
                        'cssText' => 'margin-bottom: 20px;'
                    ],
                    'blocks' => [
                        [
                            'type' => 'button',
                            'styles' => [
                                'cssClass' => 'btn btn-default'
                            ],
                            'value' => 'Search'
                        ]
                    ]
                ],
                /* 3 BLOCKS OF TEXTS */
                [
                    'type' => 'div',
                    'value' => 'second div',
                    'styles' => [
                        'cssClass' => 'text-div'
                    ],
                    'blocks' => [
                        [
                            'type' => 'text',
                            'value' => 'text1',
                            'text' => 'Google Impact Challenge: Disabilities invites us all to aim our collective might at creating a world that works for everyone. We pledged $20 million in grants to 29 nonprofits using technology to take on a wide range of accessibility challenges all over the world',
                            'styles' => [
                                'cssClass' => 'col-sm-4'
                            ]
                        ],
                        [
                            'type' => 'text',
                            'value' => 'text2',
                            'text' => 'I’m thrilled to announce that in 2017 Google will reach 100% renewable energy for our global operations — including both our data centers and offices. This is a huge milestone. We were one of the first corporations to create large-scale',
                            'styles' => [
                                'cssClass' => 'col-sm-4'
                            ]
                        ],
                        [
                            'type' => 'text',
                            'value' => 'text3',
                            'text' => 'We believe innovation can lead not only to better products, but also to a better world — for everyone. At Google.org, we invest $100,000,000 in grants annually in organizations with bold ideas that create lasting change',
                            'styles' => [
                                'cssClass' => 'col-sm-4'
                            ]
                        ]
                    ]
                ]
            ]
        ]
    ];

    return json_encode($json);
}
?>

<!DOCTYPE html>
<html>
<head>
    <!-- Bootstrap CSS - just for styles -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">
    <link rel="stylesheet" href="styles.css">
</head>

<body>
    <script src="rendererModule.js"></script>

    <script>
        var json = '<?php echo getJson(); ?>';

        var result = rendererModule.getDOM(json);

        document.body.append(result);
    </script>
</body>
</html>

