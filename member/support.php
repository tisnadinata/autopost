<div class="container-fluid">
	<div class="row">
       <div class="col-md-6">
            <div class="card">
                <div class="card-header" data-background-color="blue">
                    <h4 class="title">Contact us and get our Support</h4>                
                </div>
                <div class="card-content">
                    <?php
                        if(isset($_POST['send'])){
                            include_once '../library/emailLibrary/function.php';
                            kirimEmail("support@getrich.com",$_POST['title'],"<b>User Information :</b> <br> User Name :  ".$_SESSION['user_data']->user_fname."<br> User Phone :  ".$_SESSION['user_data']->user_phone."<br> Answer/Reply this email to : ".$_POST['email']."<br><br> <b>Support Description : </b><br> ".$_POST['desc']);
                            echo '<div class="alert alert-success" role="alert">
                                    Success send email with subject <b>'.$_POST['title'].'</b>.
                                </div>
                                <meta http-equiv="refresh" content="4; url=?p=support" />                                
                            ';
                        }
                    ?>
                    <form action="" method="post">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group label-floating">
                                    <label class="control-label">Email Subject</label>
                                    <input type="text" class="form-control" name="title">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group label-floating">
                                    <label class="control-label">To which email we should reply to ?</label>
                                    <input type="email" class="form-control" name="email" value="<?php echo $_SESSION['user_data']->user_email;?>">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group label-floating">
                                <label class="control-label">Describe what you need here</label>
                                    <textarea class="form-control" name="desc" required rows="13"></textarea>
                                </div>
                            </div>
                        </div>
                        <button type="submit" name="send" class="btn btn-info pull-right">Send Email Support</button>
                        <div class="clearfix"></div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>