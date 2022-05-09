<?php
class UserController extends BaseController
{

    public function upload2Action(){
        header('Content-Type: application/json; charset=utf-8');
        header("Access-Control-Allow-Origin: *");
        header("Access-Control-Allow-Methods: POST");
        header("Access-Control-Allow-Headers: Access-Control-Allow-Headers,Content-Type,Access-Control-Allow-Methods, Authorization");
        $response = array();
        try {
        
        // Undefined | Multiple Files | $_FILES Corruption Attack
        // If this request falls under any of them, treat it invalid.
        if (
            !isset($_FILES['userfile']['error']) ||
            is_array($_FILES['userfile']['error'])
        ) {
            throw new RuntimeException('Invalid parameters.');
        }

        // Check $_FILES['userfile']['error'] value.
        switch ($_FILES['userfile']['error']) {
            case UPLOAD_ERR_OK:
            break;
            case UPLOAD_ERR_NO_FILE:
            throw new RuntimeException('No file sent.');
            case UPLOAD_ERR_INI_SIZE:
            case UPLOAD_ERR_FORM_SIZE:
            throw new RuntimeException('Exceeded filesize limit.');
            default:
            throw new RuntimeException('Unknown errors.');
        }

        // You should also check filesize here. 
        // if ($_FILES['userfile']['size'] > 10000000000000000) {
        //     throw new RuntimeException('Exceeded filesize limit.');
        // }

        // DO NOT TRUST $_FILES['userfile']['mime'] VALUE !!
        // Check MIME Type by yourself.
        $finfo = new finfo(FILEINFO_MIME_TYPE);
        if (false === $ext = array_search(
            $finfo->file($_FILES['userfile']['tmp_name']),
            array(
            'jpg' => 'image/jpeg',
            'png' => 'image/png',
            'gif' => 'image/gif',
            ),
            true
        )) {
            throw new RuntimeException('Invalid file format.');
        }

        // You should name it uniquely.
        // DO NOT USE $_FILES['userfile']['name'] WITHOUT ANY VALIDATION !!
        // On this example, obtain safe unique name from its binary data.
        if (!move_uploaded_file(
            $_FILES['userfile']['tmp_name'],
            $_FILES['userfile']['name'],
        )) {
            throw new RuntimeException('Failed to move uploaded file.');
        }
        $uploaddir = "/var/www/uploads/";
        $ftp_server = "ftpserver";
        $ftp_username="one";
        $ftp_userpass="1234";
        $ftp_connection = ftp_connect($ftp_server)
        or die("Could not connect to $ftp_server");
        if( $ftp_connection ) {
            echo "successfully connected to the ftp server!";
            $login = ftp_login($ftp_connection,
                $ftp_username, $ftp_userpass);
            if($login) {
                echo "<br>login successfull!";
                    
                if (ftp_put($ftp_connection, $_FILES['userfile']['name'],
                $_FILES['userfile']['name'], FTP_BINARY)) {
                    echo "<br>Successfully uploaded ";
                }
                else {
                    echo "<br>Error while uploading";
                    throw new Error('Failed to upload file through FTP');
                    }
            }
            else {
                echo "<br>login failed!";
            }
            if(ftp_close($ftp_connection)) {
                echo "<br>Connection closed Successfully!";
            }
        }
        $response = array(
            "status" => "success",
            "error" => false,
            "message" => "File uploaded successfully"
        );
        echo json_encode($response);

        } catch (RuntimeException $e) {
        $response = array(
            "status" => "error",
            "error" => true,
            "message" => $e->getMessage()
        );
        echo json_encode($response);
        }
    }
    //check https://codeofaninja.com/create-simple-rest-api-in-php/#File_structure
    //https://www.w3schools.com/php/php_file_upload.asp
    public function uploadAction(){
        try {
            $uploaddir = "/var/www/uploads/";
            $ftp_server = "ftpserver";
            $ftp_username="one";
            $ftp_userpass="1234";
            $tmp_name = $_FILES["userfile"]["tmp_name"];
            echo $tmp_name;
            $file_name = $_FILES["userfile"]["name"];
            echo $file_name;
            // basename() may prevent filesystem traversal attacks;
            // further validation/sanitation of the filename may be appropriate
            $local_name = $uploaddir . basename($file_name);
            // $local_name = basename($tmp_name);
            // echo $local_name;
            // if (move_uploaded_file($tmp_name, $local_name)) {
                // echo "<br>Temporary Upload Successfull on move_uploaded_file method";
            // }else {
            //     throw new Error("Not a valid upload file", 1);
            // }
            $ftp_connection = ftp_connect($ftp_server)
            or die("Could not connect to $ftp_server");
            if( $ftp_connection ) {
                // echo "successfully connected to the ftp server!";
                $login = ftp_login($ftp_connection,
                        $ftp_username, $ftp_userpass);
                if($login) {
                    // echo "<br>login successfull!";
                    
                    if (ftp_put($ftp_connection, $file_name,
                    $local_name, FTP_BINARY)) {
                        // echo "<br>Successfully uploaded ";
                        // . "from $local_name to $file_name.";
                    }
                    else {
                        echo "<br>Error while uploading from "
                            . "$local_name to $file_name.";
                        throw new Error('Failed to upload file through FTP');
                    }
                }
                else {
                    echo "<br>login failed!";
                }
                if(ftp_close($ftp_connection)) {
                    echo "<br>Connection closed Successfully!";
                }
                http_response_code(200);
            }
            //as seen in https://www.php.net/manual/en/function.file-put-contents.php
            // $filename->name = isset($_GET['filename']) ? $_GET['filename'] : die();
            // $hostname = $ftp_username . ":" . $ftp_userpass . "@" . $ftp_server . "/" . $filename;
            /* the file content */
            // https://es.stackoverflow.com/questions/294029/para-que-sirve-file-get-contentsphp-input
            /* create a stream context telling PHP to overwrite the file */
            // $options = array('ftp' => array('overwrite' => true));
            // $stream = stream_context_create($options);
            // /* and finally, put the contents */
            // file_put_contents($hostname, $content, 0, $stream);
        } catch (Error $e) {
            http_response_code(500);
            // tell the user product does not exist
            echo json_encode(array("message" => $e->getMessage()));
        }
    }
    /**
     * "/user/download" Endpoint - Download File
     */
    public function downloadAction()
    {
        $ftp_server = "ftpserver";

        $ftp_username="one";
 
        // Use correct ftp password corresponding
        // to the ftp username
        $ftp_userpass="1234";

        //error flag
        $strErrorDesc = '';

        //local_file
        $server_file = isset($_GET['filename']) ? $_GET['filename'] : die();

        try {
            // Establish ftp connection
            $ftp_connection = ftp_connect($ftp_server)
            or die("Could not connect to $ftp_server");
        
            if( $ftp_connection ) {
                // echo "successfully connected to the ftp server!";
                
                // Logging in to established connection
                // with ftp username password
                $login = ftp_login($ftp_connection,
                        $ftp_username, $ftp_userpass);
                
                if($login) {
                    
                    // Checking whether logged in successfully
                    // or not
                    // echo "<br>logged in successfully!";
                    
                    // Name or path of the localfile to
                    // where the file to be downloaded
                    $local_file =  $server_file;
                    
                    // Name or path of the server file to
                    // be downloaded
                    // $server_file = "server_file.txt";
                    
                    // Downloading the specified server file
                    if (ftp_get($ftp_connection, $local_file,
                            $server_file, FTP_BINARY)) {
                        // echo "<br>Successfully downloaded "
                        // . "from $server_file to $local_file.";
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
                    // echo "<br>Connection closed Successfully!";
                }
                $fileLocal = fopen($local_file, 'r');
                if ($fileLocal) {
                    $responseData = fread($fileLocal, filesize($server_file));
                    fclose($fileLocal);
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
}