<?php
$title="contact";
require_once __DIR__.'/template/header.php';
require_once 'includes/uploader.php';
require 'classes/Services.php';
if ( isset($_SESSION['contact_form'])) var_dump($_SESSION['contact_form']);

?>
<form action="<?php echo $_SERVER['PHP_SELF']?>"method="post" enctype="multipart/form-data">
    <div class="form-group">
        <label for="name">Name</label>
        <input type="text" name="name" class="form-control" placeholder="enter your name" value="<?php if( isset($_SESSION['contact_form']['name']) ) echo $_SESSION['contact_form']['name']?>">
        <span class="text-danger"><?php echo $nameError?></span>
    </div>
    <div class="form-group">
        <label for="email">Your Email</label>
        <input type="email" name="email" class="form-control" placeholder="enter your email" value="<?php if( isset($_SESSION['contact_form']['email']) ) echo $_SESSION['contact_form']['email']?>">
        <span class="text-danger"><?php echo $emailError?></span>

    </div>
    <div class="form-group">
        <label for="document">document: </label>
        <input type="file" name="document" >
        <span class="text-danger"><?php echo $documentError?></span>
    </div>
    <div >
        <label for="services">services: </label>
        <select class="form-select form-control " aria-label="Default select example">
            <option selected>Open this select menu</option>

            <?php
            $services=new Services;
            echo "gg." ;
            foreach ($services->all() as $service){?>
                <option value="<?php echo $service['name']?>"><?php echo $service['name']?></option>
            <?Php  } ?>
        </select>
    </div>

    <div class="form-group">
        <label for="message">message</label>
        <textarea  name="message" class="form-control" rows="6" placeholder="enter your message"><?php if( isset($_SESSION['contact_form']['message']) ) echo $_SESSION['contact_form']['message']?></textarea>
        <span class="text-danger"><?php echo $messageError?></span>

    </div>
    <button class="btn btn-success" type="submit">send</button>
</form>


<?php
require_once __DIR__.'/template/footer.php'
?>
