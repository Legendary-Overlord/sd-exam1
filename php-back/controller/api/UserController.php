<?php
class UserController extends BaseController
{

    //check https://codeofaninja.com/create-simple-rest-api-in-php/#File_structure
    //https://www.w3schools.com/php/php_file_upload.asp
    public function uploadAction(){

        header("Access-Control-Allow-Origin: *");
        header("Content-Type: multipart/form-data; charset=UTF-8");
        header("Access-Control-Allow-Methods: POST");
        header("Access-Control-Max-Age: 3600");
        header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");


        // Connect to FTP server
        $ftp_server = "localhost";
        
        // Use correct ftp username
        $ftp_username="one";
        
        // Use correct ftp password corresponding
        // to the ftp username
        $ftp_userpass="1234";

        try {
            //as seen in https://www.php.net/manual/en/function.file-put-contents.php
            // $filename->name = isset($_GET['filename']) ? $_GET['filename'] : die();
            $filename = $_FILES['userfile']['name'];
            $hostname = $ftp_username . ":" . $ftp_userpass . "@" . $ftp_server . "/" . $filename;

            /* the file content */
            // https://es.stackoverflow.com/questions/294029/para-que-sirve-file-get-contentsphp-input
            $content = $content . basename($_FILES['userfile']['name']);

            /* create a stream context telling PHP to overwrite the file */
            $options = array('ftp' => array('overwrite' => true));
            $stream = stream_context_create($options);
            /* and finally, put the contents */
            file_put_contents($hostname, $content, 0, $stream);
        } catch (Error $e) {
            http_response_code(500);
            // tell the user product does not exist
            echo json_encode(array("message" => "Server Error!"));
        }
    }
    /**
     * "/user/download" Endpoint - Download File
     */
    public function downloadAction()
    {
        $ftp_server = "localhost";

        $ftp_username="one";
 
        // Use correct ftp password corresponding
        // to the ftp username
        $ftp_userpass="1234";

        //error flag
        $strErrorDesc = '';

        //local_file
        $local_file->name = isset($_GET['filename']) ? $_GET['filename'] : die();

        try {
            // Establish ftp connection
            $ftp_connection = ftp_connect($ftp_server)
            or die("Could not connect to $ftp_server");
        
            if( $ftp_connection ) {
                echo "successfully connected to the ftp server!";
                
                // Logging in to established connection
                // with ftp username password
                $login = ftp_login($ftp_connection,
                        $ftp_username, $ftp_userpass);
                
                if($login) {
                    
                    // Checking whether logged in successfully
                    // or not
                    echo "<br>logged in successfully!";
                    
                    // Name or path of the localfile to
                    // where the file to be downloaded
                    $local_file =  $server_file;
                    
                    // Name or path of the server file to
                    // be downloaded
                    // $server_file = "server_file.txt";
                    
                    // Downloading the specified server file
                    if (ftp_get($ftp_connection, $local_file,
                            $server_file, FTP_BINARY)) {
                        echo "<br>Successfully downloaded "
                        . "from $server_file to $local_file.";
                    }
                    else {
                        echo "<br>Error while downloading from "
                            . "$server_file to $local_file.";
                    }
                    
                }
                else {
                    echo "<br>login failed!";
                }
                
                // echo ftp_get_option($ftp_connection, 1);
                // Closing  connection
            
                if(ftp_close($ftp_connection)) {
                    echo "<br>Connection closed Successfully!";
                }
                $fileLocal = fopen($local_file, 'r');
                if ($fileLocal) {
                    $responseData = fread($f, filesize($filename));
                    fclose($f);
                }
            }
        } catch (Error $e) {
            $strErrorDesc = $e->getMessage().'Something went wrong! Please contact support.';
                $strErrorHeader = 'HTTP/1.1 500 Internal Server Error';
        }
        // send output
        if (!$strErrorDesc) {
            $this->sendOutput(
                $responseData,
                array('Content-Type: application/octet-stream', 'HTTP/1.1 200 OK')
            );
        } else {
            $this->sendOutput(json_encode(array('error' => $strErrorDesc)), 
                array('Content-Type: application/octet-stream', $strErrorHeader)
            );
        }
    }

    /**
     * "/user/list" Endpoint - Get list of users
     */
    // public function listAction()
    // {
    //     $strErrorDesc = '';
    //     $requestMethod = $_SERVER["REQUEST_METHOD"];
    //     $arrQueryStringParams = $this->getQueryStringParams();
 
    //     if (strtoupper($requestMethod) == 'GET') {
    //         try {
    //             $userModel = new UserModel();
 
    //             $intLimit = 10;
    //             if (isset($arrQueryStringParams['limit']) && $arrQueryStringParams['limit']) {
    //                 $intLimit = $arrQueryStringParams['limit'];
    //             }
 
    //             $arrUsers = $userModel->getUsers($intLimit);
    //             $responseData = json_encode($arrUsers);
    //         } catch (Error $e) {
    //             $strErrorDesc = $e->getMessage().'Something went wrong! Please contact support.';
    //             $strErrorHeader = 'HTTP/1.1 500 Internal Server Error';
    //         }
    //     } else {
    //         $strErrorDesc = 'Method not supported';
    //         $strErrorHeader = 'HTTP/1.1 422 Unprocessable Entity';
    //     }
 
    //     // send output
    //     if (!$strErrorDesc) {
    //         $this->sendOutput(
    //             $responseData,
    //             array('Content-Type: application/json', 'HTTP/1.1 200 OK')
    //         );
    //     } else {
    //         $this->sendOutput(json_encode(array('error' => $strErrorDesc)), 
    //             array('Content-Type: application/json', $strErrorHeader)
    //         );
    //     }
    // }
}