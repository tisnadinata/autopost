<form method="post" action="">
  <div class="form-group">
    <label for="exampleInputEmail1">Isi status yang ingin kamu buat disini :</label>
    <textarea class="form-control" name="status" ></textarea>
  </div>
  <button type="submit" class="btn btn-primary">POST TO FACEBOOK</button>
</form>
<?php
  if(isset($_POST['status'])){
    include '../config/config_db.php';
    define('FACEBOOK_SDK_V4_SRC_DIR', '../library/facebook-sdk-v5/');
		require_once '../library/facebook-sdk-v5/autoload.php';
    ini_set('display_errors',1);
    $fb = new Facebook\Facebook([
      'app_id' => FACEBOOK_ID,
      'app_secret' => FACEBOOK_SECRET,
      'default_graph_version' => 'v2.11',
    ]);

    $data = [
      'message' => $_POST['status'],
    ];
    echo "<div class='alert alert-default'>";
    try {
    // Returns a `Facebook\FacebookResponse` object
    $response = $fb->post('/me/feed', $data, $_SESSION['fb_access_token'] );
    } catch(Facebook\Exceptions\FacebookResponseException $e) {
      echo 'Graph returned an error: ' . $e->getMessage()." </alert>";
      exit;
    } catch(Facebook\Exceptions\FacebookSDKException $e) {
      echo 'Facebook SDK returned an error: ' . $e->getMessage()." </alert>";
      exit;
    }
    $graphNode = $response->getGraphNode();
    // echo 'Photo ID: ' . $graphNode['id'];
    echo "Your post success with id ".$graphNode['id']." </alert>";
  }
?>