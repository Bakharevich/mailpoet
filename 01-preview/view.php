<?php
class View {
    /**
     * Get preview
     *
     * @param $newsletter
     * @return string
     */
    public static function preview($newsletter)
    {
        $html = "";

        $html .= '<h3>' . $newsletter['subject'] . '</h3>';
        $html .= View::body($newsletter['body']);
        $html .= 'You are viewing <a href="' . htmlentities($_SERVER['PHP_SELF']) . '?id='. $newsletter['id'] . '">This newsletter</a>';

        return $html;
    }

    /**
     * Get HTML error
     *
     * @param $text
     * @param int $code
     * @return string
     */
    public static function error($text, $code = 500)
    {
        header("HTTP/1.0 " . $code);

        return "<h1>ERROR</h1><p>{$text}</p>";
    }

    /**
     * Format body
     *
     * @param $body
     * @return mixed
     */
    public static function body($body)
    {
        // do some format logic with BODY
        return $body;
    }
}