<?php
if (isset ($_POST['contactFF'])) {
  $to = "berezg86@gmail.com, marinamargusheva@gmail.com, psheunov.a@yandex.ru";
  $from = $_POST['contactFF'];
  $subject = "Заполнена контактная форма с ".$_SERVER['HTTP_REFERER'];
  $message = "Имя: ".$_POST['nameFF']."\nТелефон: ".$_POST['code'] .$_POST['phone']."\nEmail: ".$from."\nIP: ".$_SERVER['REMOTE_ADDR']."\nСообщение: ".$_POST['messageFF'];
  $boundary = md5(date('r', time()));
  $filesize = '';
  $headers = "MIME-Version: 1.0\r\n";
  $headers .= "From: " . $from . "\r\n";
  $headers .= "Reply-To: " . $from . "\r\n";
  $headers .= "Content-Type: multipart/mixed; boundary=\"$boundary\"\r\n";
  $message="
Content-Type: multipart/mixed; boundary=\"$boundary\"

  

--$boundary
Content-Type: text/plain; charset=\"utf-8\"
Content-Transfer-Encoding: 7bit

$message";
  for($i=0;$i<count($_FILES['fileFF']['name']);$i++) {
      if(is_uploaded_file($_FILES['fileFF']['tmp_name'][$i])) {
         $attachment = chunk_split(base64_encode(file_get_contents($_FILES['fileFF']['tmp_name'][$i])));
         $filename = $_FILES['fileFF']['name'][$i];
         $filetype = $_FILES['fileFF']['type'][$i];
         $filesize += $_FILES['fileFF']['size'][$i];
         $message.="

--$boundary
Content-Type: \"$filetype\"; name=\"$filename\"
Content-Transfer-Encoding: base64
Content-Disposition: attachment; filename=\"$filename\"

$attachment";
     }
   }
   $message.="
--$boundary--";

  if ($filesize < 1000000) {
    mail($to, $subject, $message, $headers."X-Mailer: PHP/" . phpversion());
    echo $_POST['nameFF'].', Ваше сообщение получено, спасибо!';
  } else {
    echo 'Извините, письмо не отправлено. Размер всех файлов превышает 1 МБ.';
  }
}
?>

