<?php
function filterString($field){
    //removes tags and remove or encode special characters from a string.
    $field=filter_var(trim($field),FILTER_SANITIZE_STRING);
    if(empty($field))
    {
        return false ;
    }
    else
    {
        return $field;
    }
}
function canUpload($file){
    $allowedType=[
        'jpg'=>'image/jpeg'  ,
        'png'=>'image/png'  ,
        'gif'=>'image/gif'  ,
    ];
    // to  see real type of document
    $fileMimeType=mime_content_type($file['tmp_name']);
    if(!in_array($fileMimeType,$allowedType)) return "File type is not allowed ";
    // this mean 10 M
    $fileSize=10 * 1024 * 1024;
    if(!$file['size']>$fileSize) return'file size not allowed , allowed size is 10M';
    return true;
}
function filterEmail($field){
    // Remove all illegal characters from an email address
    $field=filter_var(trim($field),FILTER_SANITIZE_EMAIL);
    // Check if the filed valid email address:
    if(filter_var($field,FILTER_VALIDATE_EMAIL))
    {
        return $field;
    }
    else
    {
        return false;
    }
}
$emailError=$nameError=$documentError=$messageError='';
if($_SERVER['REQUEST_METHOD']=='POST')
{
    $_SESSION['contact_form']['name']=filterString($_POST['name']);
    $_SESSION['contact_form']['email']=filterEmail($_POST['email']);
    $_SESSION['contact_form']['message']=filterString($_POST['message']);
//    echo "<pre>"; print_r($_POST); print_r($_FILES);echo "<pre>";
    $file=$_FILES['document'];
    //validate string
    if (! $_SESSION['contact_form']['name']) $nameError='your name is required';
    //validate email address
    if(!$_SESSION['contact_form']['email']) $emailError='your email is required';

    if (!$_SESSION['contact_form']['message']) $messageError='your message is required';

    // in document, we have 5 info name , type , tmp_name , error , size
    if(isset($_FILES['document']) && $file['error']==0)
    {
        $canUpload=canUpload($file);
        if ($canUpload === true)
        {
            $uploadDir="uploads";
            if(!is_dir($uploadDir)){
                umask(0);
                mkdir($uploadDir,0775);
            }
            $fileName=time().$file['name'];
            move_uploaded_file($file['tmp_name'],$uploadDir.'/'.$fileName);
        }
        else
        {
            $documentError=$canUpload;
        }
    }
    if (!$nameError && !$emailError && !$messageError && !$documentError){
        $headers = 'MIME-Version: 1.0' . "\r\n";
        $headers .= 'Content-type: text/html; charset=UFT-8' . "\r\n";
        $headers .= 'From: '.$_SESSION['contact_form']['email']."\r\n". 'Reply-To: '.$_SESSION['contact_form']['email']."\r\n" . 'X-Mailer: PHP/' . phpversion();
        $mailMessage='<html><body>
            <p></p>'.$_SESSION['contact_form']['message'].'
            </body></html>';
        if (mail('dvomaralsulami@gmail.com','new message from '.$_SESSION['contact_form']['name'],$mailMessage,$headers)){
          header('location: index.php');
            unset($_SESSION['contact_form']);
            die();

        }
    }
}