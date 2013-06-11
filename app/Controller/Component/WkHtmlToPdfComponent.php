<?php  

App::uses('Folder', 'Utility');
App::uses('File', 'Utility');

class WkHtmlToPdfComponent extends Component 
{ 

/** 
 * wkhtmltopdf component class for exporting a view as pdf 
 *  
 * @author Zuha
 * 
 * @category Components 
 */ 

    public function startup($controller) 
    {
        //generate random number to ensure file is unique 
        $randomNumber = mt_rand();
        $this->randomNumber = $randomNumber;  
        $this->controller = $controller;
        $this->siteFolder = new Folder(TMP, true, 0755); 
        $fileName = 'viewDump' . $randomNumber . '.tmp'; 
        $this->viewFile = new File($this->siteFolder->pwd().DS.$fileName); 
    } 

    public function createPdf($layout = null) 
    { 
        //prevent view from rendering normally 
        $this->controller->autoRender = false; 
        $this->controller->output = ''; 

        //render view to memory with optional layout specified 
        $view = $this->controller->render($layout);

        if ($this->viewFile !== false) 
        { 
            $this->viewFile->delete(); 
        } 

        //write view from memory to file and then execute wkhtmltopdf externally to generate the pdf
        if ($this->viewFile->write($view, 'w')) 
        { 
            $this->viewFile->close(); 

            $controllerName = strtolower($this->controller->name); 

            $url = "http://{$_SERVER['HTTP_HOST']}/{$controllerName}/getViewDump/{$fileName}"; 
            $output = TMP."output{$randomNumber}.pdf";
            switch(PHP_INT_SIZE) {
                case 4:
                     $cmd = VENDORS . 'wkhtmltopdf/32bit/wkhtmltopdf ' . $url . ' ' . $output;
                    break;
                case 8:
                     $cmd = VENDORS . 'wkhtmltopdf/32bit/wkhtmltopdf ' . $url . ' ' . $output;
                    break;
                default:
                    throw new Exception('32/64? no found', 1);
                    break;
            }
            exec($cmd); 
        } 

        //send file to browser and trigger download dialogue box 
        $this->returnFile(TMP."output{$randomNumber}.pdf", "document{$randomNumber}.pdf"); 

        //remove files 
        $this->cleanUp(); 
    } 

    public function getViewDump($fileName) 
    { 
        //prevent view from rendering normally 
        $this->controller->autoRender = false; 
        $this->controller->output = ''; 

        print_r($this->viewFile->read()); 
    } 

    public function cleanUp() 
    { 
        //delete viewDump 
        $this->viewFile->delete(); 

        //delete outputPdf 
        $this->pdfFile = new File(TMP.'output' . $this->randomNumber . '.pdf'); 
        $file->delete(); 
    } 

    private function returnFile($file, $name, $mime_type='') 
    { 
        /* 
            This function takes a path to a file to output ($file), 
            the filename that the browser will see ($name) and 
            the MIME type of the file ($mime_type, optional). 

            If you want to do something on download abort/finish, 
            register_shutdown_function('function_name'); 
        */ 
        if (!is_readable($file)) die('File not found or inaccessible!'); 

        $size = filesize($file); 
        $name = rawurldecode($name); 

        /* Figure out the MIME type (if not specified) */ 
        $known_mime_types = array( 
                "pdf" => "application/pdf", 
                "txt" => "text/plain", 
                "html" => "text/html", 
                "htm" => "text/html", 
                "exe" => "application/octet-stream", 
                "zip" => "application/zip", 
                "doc" => "application/msword", 
                "xls" => "application/vnd.ms-excel", 
                "ppt" => "application/vnd.ms-powerpoint", 
                "gif" => "image/gif", 
                "png" => "image/png", 
                "jpeg"=> "image/jpg", 
                "jpg" =>  "image/jpg", 
                "php" => "text/plain" 
        ); 

        if ($mime_type == '') 
        { 
            $file_extension = strtolower(substr(strrchr($file, "."), 1)); 

            if (array_key_exists($file_extension, $known_mime_types)) 
            { 
                $mime_type = $known_mime_types[$file_extension]; 
            } 
            else 
            { 
                $mime_type = "application/force-download"; 
            } 
        } 

        //@ob_end_clean(); //turn off output buffering to decrease cpu usage 
        // required for IE, otherwise Content-Disposition may be ignored 
        if (ini_get('zlib.output_compression')) ini_set('zlib.output_compression', 'Off'); 

        header('Content-Type: ' . $mime_type); 
        header('Content-Disposition: attachment; filename="' . $name . '"'); 
        header('Content-Transfer-Encoding: binary'); 
        header('Accept-Ranges: bytes'); 

        /* The three lines below basically make the download non-cacheable */ 
        header('Cache-control: private'); 
        header('Pragma: private'); 
        header('Expires: Mon, 26 Jul 1997 05:00:00 GMT'); 

        // multipart-download and download resuming support 
        if (isset($_SERVER['HTTP_RANGE'])) 
        { 
            list($a, $range) = explode('=', $_SERVER['HTTP_RANGE'], 2); 
            list($range) = explode(',', $range, 2); 
            list($range, $range_end) = explode('-', $range); 

            $range = intval($range); 

            $range_end = (!$range_end) ? $size-1 : intval($range_end); 
            $new_length = $range_end-$range + 1; 

            header('HTTP/1.1 206 Partial Content'); 
            header('Content-Length: ' . $new_length); 
            header('Content-Range: bytes ' . ($range - $range_end / $size)); 
        } 
        else 
        { 
            $new_length = $size; 

            header('Content-Length: ' . $size); 
        } 

        /* output the file itself */ 
        $chunksize = 1 * (1024 * 1024); //you may want to change this 
        $bytes_send = 0; 

        if ($file = fopen($file, 'r')) 
        { 
            if (isset($_SERVER['HTTP_RANGE'])) fseek($file, $range); 

            while (!feof($file) && (!connection_aborted()) && ($bytes_send < $new_length)) 
            { 
                $buffer = fread($file, $chunksize); 

                print($buffer); 
                flush(); 

                $bytes_send += strlen($buffer); 
            } 

            fclose($file); 
        } 
        else 
        { 
            die('Error - can not open file.'); 
        } 
    } 
} 
?>