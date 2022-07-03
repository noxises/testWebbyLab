<?php

class View
{
    public function generate_html($file, array $vars = [])
    {
        ob_start();

        foreach ($vars as $k => $v)
        {
            $$k = $v;
        }

        require ROOT_FOLDER.'/application/Views/'.$file;

        return ob_get_clean();
    }
}