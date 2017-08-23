<?php
function DOM_Tidy($html)
{
    $dom = new \DOMDocument();

    if (libxml_use_internal_errors(true) === true)
    {
        libxml_clear_errors();
    }

    $html = mb_convert_encoding($html, 'HTML-ENTITIES', 'UTF-8');
    $html = preg_replace(array('~\R~u', '~>[[:space:]]++<~m'), array("\n", '><'), $html);

    if ((empty($html) !== true) && ($dom->loadHTML($html) === true))
    {
        $dom->formatOutput = true;

        if (($html = $dom->saveXML($dom->documentElement, LIBXML_NOEMPTYTAG)) !== false)
        {
            $regex = array
            (
                '~' . preg_quote('<![CDATA[', '~') . '~' => '',
                '~' . preg_quote(']]>', '~') . '~' => '',
                '~></(?:area|base(?:font)?|br|col|command|embed|frame|hr|img|input|keygen|link|meta|param|source|track|wbr)>~' => ' />',
            );

            return '<!DOCTYPE html>' . "\n" .preg_replace(array_keys($regex), $regex, $html);
        }
    }

    return false;
}


    if(isset($_POST["export_data"]) && $_POST["export_data"] != ""){
        
$html = '
<!DOCTYPE html>
<html lang="en">                
'.$_POST["export_data"].'
</html>';
        
        $html = str_replace(' cz-shortcut-listen="true"', '', $html);
        $html = DOM_Tidy($html);
        
        if (function_exists('mb_strlen')) {
            $size = mb_strlen($html, '8bit');
        } else {
            $size = strlen($html);
        }        
    }

    
    if(isset($_POST['export_data_download']) && $_POST['export_data_download'] == '1'){
        header('Content-Description: File Transfer');
        header('Content-Type: application/octet-stream');
        header('Content-Disposition: attachment; filename=builder_data.html');
        header('Content-Transfer-Encoding: binary');
        header('Expires: 0');
        header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
        header('Pragma: public');
        header('Content-Length: ' . $size);
        ob_clean();
    }
    
    echo $html;
    
?>