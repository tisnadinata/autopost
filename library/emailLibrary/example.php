<form action="" method="post">
  <button type="submit" name="submit">Click Me</button>
</form>

<?php
	require_once('function.php');
	if(isset($_POST['submit']))
	{
    $to       = 'tisnadinata@gmail.com';
    $subject  = 'Subject Pengiriman Email Uji Coba';
    $message  = '<p>Isi dari Email Testing</p>';
    smtp_mail($to, $subject, $message, '', '', 0, 0, true);
    
    /*
      jika menggunakan fungsi mail biasa : mail($to, $subject, $message);
      dapat juga menggunakan fungsi smtp secara dasar : smtp_mail($to, $subject, $message);
      jangan lupa melakukan konfigurasi pada file function.php
    */
	}
?>