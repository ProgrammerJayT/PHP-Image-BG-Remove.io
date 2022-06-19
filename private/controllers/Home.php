<?php

class Home extends Controller
{
    function index(){

        if ($_SERVER['REQUEST_METHOD'] == 'POST') {

            $supportedExtension = array('jpg', 'jpeg', 'png');

            $imageExtension = explode('/', $_FILES['image']['type']);
            $imageExtension = $imageExtension[1];

            $path = $_FILES['image']['tmp_name'];

            if (!in_array($imageExtension, $supportedExtension)) {
                echo '<script>alert("File type not supported");</script>';
            } else {

                $results = array();

                $client = new GuzzleHttp\Client();
                $res = $client->post('https://api.remove.bg/v1.0/removebg', [
                    'multipart' => [
                        [
                            'name'     => 'image_file',
                            'contents' => fopen($path, 'r')
                        ],
                        [
                            'name'     => 'size',
                            'contents' => 'auto'
                        ]
                    ],
                    'headers' => [
                        'X-Api-Key' => 'SET_YOUR_API_KEY'
                    ]
                ]);
                
                if (!file_exists('output')) {
                    mkdir('removed-bg', 0777, true);
                }
                $fp = fopen("removed-bg/removed-bg.png", "wb");
                fwrite($fp, $res->getBody());
                fclose($fp);

                if ($res->getStatusCode() == 200) {
                    $results['res'] = 'success';
                    $results['message'] = 'Image background successfully removed';
                    $results['imageURI'] = 'removed-bg/removed-bg.png';

                    $_SESSION['return'] = $results;
                    $this->redirect('Output');

                } else {
                    $results['res'] = 'error';
                    $results['message'] = 'Error removing background';

                    $_SESSION['return'] = $results;
                    $this->redirect('Home');
                }
            }
        }
        
        $this->view('home');
    }
}
