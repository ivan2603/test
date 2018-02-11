<?php
/**
 * Created by PhpStorm.
 * User: ivan
 * Date: 08.02.18
 * Time: 22:41
 */

Class OutputController {

    public function actionJson() {

        $data = Shop::getProductList();

        $json = preg_replace_callback('/\\\u([0-9a-fA-F]{4})/',
            create_function('$match', 'return mb_convert_encoding("&amp;#" . intval($match[1], 16) . ";", "UTF-8", "HTML-ENTITIES");'),
            json_encode($data, JSON_UNESCAPED_UNICODE));
        echo $json;
        require_once (ROOT.'/views/book/json_output.php');
        return true;
    }
}
