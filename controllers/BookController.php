<?php

class BookController {

    public function actionIndex() {

        require_once (ROOT.'/views/book/index.php');
        return true;
    }

    public function actionForm() {
        session_start();

        if (isset($_POST) && !empty($_POST)) {

            if ($_POST['captcha'] == $_SESSION['captcha']) {
                $message = Book::addReview($_POST, $_FILES);
            } else {
                $message = '<span style="color: red">ERROR CAPTCHA</span>';
            }

        }

        require_once (ROOT.'/views/book/form.php');
        return true;
    }

    public function actionList() {

        $guestList = array();

        if (!empty($_POST['submit'])) {
            $indent = $_POST['submit'];
        } else {
            $indent = 0;
        }

        $guestList = Book::getGuestList($indent);

        require_once (ROOT.'/views/book/list.php');
        return true;
    }
}