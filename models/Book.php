<?php
class Book {

    public $data = array();

    static function getGuestList($indent)
    {
        $db = Db::getConnection();
        if ($indent) {
            if ($indent == 1) {
                $result = $db->query('SELECT id, name, email, message, file_path, homepage, browser, ip, data FROM user_messages GROUP BY name');
            } elseif ($indent == 2) {
                $result = $db->query('SELECT id, name, email, message, file_path, homepage, browser, ip, data FROM user_messages GROUP BY email');
            } elseif ($indent == 3) {
                $result = $db->query('SELECT id, name, email, message, file_path, homepage, browser, ip, data FROM user_messages GROUP BY data');
            }
        } else {
            $result = $db->query('SELECT id, name, email, message, file_path, homepage, browser, ip, data FROM user_messages ORDER BY id DESC ');
        }

        $result->setFetchMode(PDO::FETCH_ASSOC);

        $i = 0;
        while ($row = $result->fetch()) {
            $guestList[$i]['user_id'] = $row['id'];
            $guestList[$i]['user_name'] = $row['name'];
            $guestList[$i]['user_email'] = $row['email'];
            $guestList[$i]['user_message'] = $row['message'];
            $guestList[$i]['user_file'] = ltrim($row['file_path']);
            $guestList[$i]['user_page'] = $row['homepage'];
            $guestList[$i]['user_browser'] = $row['browser'];
            $guestList[$i]['user_ip'] = $row['ip'];
            $guestList[$i]['date_add'] = $row['data'];
            $i++;
        }

        return $guestList;

    }

    public static function addReview($data, $file) {

        $message = '';

        $user_name = trim($data['user']);
        $user_email = trim($data['email']);
        $user_url = trim($data['url']);
        $user_message = trim($data['message']);
        $user_browser = $_SERVER["HTTP_USER_AGENT"];
        $user_ip = $_SERVER['REMOTE_ADDR'];
        $date_add = date('Y-m-d');

        if (isset($file['upload']['name']) && is_uploaded_file($file['upload']['tmp_name'])) {
            $image_name = self::addImage($file);
            if (empty($image_name)) {
                $message = '<span style="color: red">Photo upload error!</span>';
            }
            xdebug_var_dump($file);
        }

        if (!self::checkUserName($user_name)) {
            $message = '<span style="color: red">Enter the correct name!</span>';
        } elseif (!self::checkUserEmail($user_email)) {
            $message = '<span style="color: red">Enter the correct email!</span>';
        } elseif (!self::checkUserMessage($user_message)) {
            $message = '<span style="color: red">Enter the correct message!</span>';
        } else {
            $message = '';
        }
        if ($message == '') {
            $db = Db::getConnection();
            $sql = 'INSERT INTO user_messages (name, email, message, file_path, homepage, browser, ip, data) '
               . 'VALUES (:user_name, :user_email, :user_message, :image_name, :user_url, :user_browser, :user_ip, :date_add)';

            $result = $db->prepare($sql);
            $result->bindParam(':user_name',    $user_name, PDO::PARAM_STR);
            $result->bindParam(':user_email',   $user_email, PDO::PARAM_STR);
            $result->bindParam(':user_message', $user_message, PDO::PARAM_STR);
            $result->bindParam(':image_name',   $image_name, PDO::PARAM_STR);
            $result->bindParam(':user_url',     $user_url, PDO::PARAM_STR);
            $result->bindParam(':user_browser', $user_browser, PDO::PARAM_STR);
            $result->bindParam(':user_ip',      $user_ip, PDO::PARAM_STR);
            $result->bindParam(':date_add',     $date_add, PDO::PARAM_STR);


            if ($result->execute()) {
                $message = '<span style="color: green">The addition was successful!</span>';
            }

        }

        return $message;

   }

   private static function addImage($file) {

       $errors = '';
       $max_image_width = 5000;
       $max_image_height = 5000;

       $size = getimagesize($file['upload']['tmp_name']);

       $img_dir = './assets/files/';

       $valid_types = array('image/jpg', 'text/plain', 'image/gif', 'image/png');
       if (in_array($file['upload']['type'], $valid_types)) {

           if (($size) && ($size[0] < $max_image_width) && ($size[1] < $max_image_height)) {
               if (@move_uploaded_file($file['upload']['tmp_name'], $img_dir . $file['upload']['name'])) {


                   if ($file['upload']['type'] == "image/jpeg") {
                       $src = ImageCreateFromJPG($img_dir . $file['upload']['name']);
                   } elseif ($file['upload']['type'] == "image/png") {
                       $src = ImageCreateFromPNG($img_dir . $file['upload']['name']);
                   } elseif ($file['upload']['type'] == "image/gif") {
                       $src = ImageCreateFromGIF($img_dir . $file['upload']['name']);
                   } else {
                       $errors[] = 'Ошибка загрузки';
                   }

                   $dst = ImageCreateTrueColor(300, 270);

                   ImageCopyResampled($dst, $src, 0, 0, 0, 0, 300, 270, ImageSX($src), ImageSY($src));


                   $image_name = $img_dir.$file['upload']['name'];
                   echo $image_name;
               } else {
                   $errors = 'ERROR';
               }
           } else {
               $errors = 'ERROR';
           }
       } else {
           $errors = 'ERROR';
       }

       if (!$errors) {
           return $image_name;
       } else {
           return false;
       }

   }

    private static function checkUserName($user_name) {

        if (!empty($user_name) && strlen($user_name) >= 3) {
            return true;
        } else {
            return false;
        }
    }


    private static function checkUserEmail($user_email) {

        if (!empty($user_email) && filter_var($user_email, FILTER_VALIDATE_EMAIL)) {
            return true;
        } else {
            return false;
        }

    }

    private static function checkUserMessage($user_message) {

        if (!empty($user_message) && strlen($user_message) >= 10) {
            return true;
        } else {
            return false;
        }
    }


}