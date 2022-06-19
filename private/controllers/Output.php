<?php

class Output extends Controller
{
    function index(){

        if (isset($_SESSION['return'])) {

            $result = $_SESSION['return']['res'];
            print_r($_SESSION['return']['imageURI']);

            if ($result == 'success'){
                $imageURI = $_SESSION['return']['imageURI'];
            } else {
                $imageURI = 'https://cdn.oncheckin.com/blogassets/blog-d888cc31-b202-4676-bdbe-e01432534be7.png';
            }
            
            $message = $_SESSION['return']['message'];
        } else {
            $this->redirect('Home');
        }

        $this->view('results/results', ['imageURI' => $imageURI, 'message' => $message]);
    }
}