<?php
defined('JPATH_BASE') or die();

if (!defined('DS')) {
    /** string Shortcut for the DIRECTORY_SEPARATOR define */
    define('DS', DIRECTORY_SEPARATOR);
}

if (!defined('JPATH_ROOT')) {
    /** string The root directory of the file system in native format */
    define('JPATH_ROOT', JPath::clean(JPATH_SITE));
}

/**
 * Image uploader
 *
 * @static
 * @package     Joomla.Framework
 * @subpackage  FileSystem
 * @since       1.5
 */
class JImageUpload
{
    const MAX_FILE_SIZE = 1000000;

    private static $lastError = 0;

    static private function _mime()
    {
        return array(
            "image/jpeg",
            "image/png",
            "image/gif",
        );
    }

    static private function _ext()
    {
        return array(
            'gif' => 'gif',
            'jpeg' => 'jpeg',
            'jpg' => 'jpeg',
            'png' => 'png',
        );
    }

    static public function getLastError()
    {
        $res = self::$lastError;
        self::$lastError = 0;
        return $res;
    }

    static public function needUpload($files, $name)
    {
        $isCorrect = is_array($files) && isset($files[$name]) && !empty($files[$name]);
        if (!$isCorrect)
            return false;

        // Файл вообще не пришел
        if (isset($files[$name]['error']) && $files[$name]['error'] == UPLOAD_ERR_NO_FILE)
            return false;

        return true;
    }

    static public function upload($files, $name, $directory, $resizeWidth)
    {
        $isCorrect = is_array($files) && isset($files[$name]) && !empty($files[$name]);
        if (!$isCorrect)
            return false;

        $file = $files[$name];

        $temp = explode(".", $file["name"]);
        $extension = end($temp);

        if (!array_key_exists($extension, self::_ext()) || !in_array($file['type'], self::_mime()))
        {
            self::$lastError = UPLOAD_ERR_EXTENSION;
            return false;
        }

        if ($file['size'] > self::MAX_FILE_SIZE)
        {
            self::$lastError = UPLOAD_ERR_INI_SIZE;
            return false;
        }

        if ($file["error"] > 0)
        {
            self::$lastError = $file['error'];
            return false;
        }

        if (strrpos($directory, '/', -1) !== strlen($directory))
            $directory .= '/';
        if (strpos($directory, '/') !== 0)
            $directory = '/'.$directory;
        $directory = JPath::clean().$directory;

        if (!is_dir($directory))
        {
            self::$lastError = UPLOAD_ERR_CANT_WRITE;
            return false;
        }

        $fileName = md5(time().$file['name']).'.'.$extension;
        if (file_exists($directory . $fileName))
            unlink($directory . $fileName);

        $exts = self::_ext();
        $imageCreateFrom = 'imagecreatefrom'.$exts[$extension];
        $imageNew = 'image'.$exts[$extension];

        $width = $resizeWidth; //*** Fix Width & Heigh (Autu caculate) ***//
        $size = getimagesize($file["tmp_name"]);
        $imagesOrig = call_user_func($imageCreateFrom, $file["tmp_name"]);
        $photoX = imagesx($imagesOrig);
        $photoY = imagesy($imagesOrig);
        if ($photoX < $resizeWidth)
            $width = $photoX;
        $height = round($width * $size[1] / $size[0]);
        $imagesFin = imagecreatetruecolor($width, $height);
        imagecopyresampled($imagesFin, $imagesOrig, 0, 0, 0, 0, $width+1, $height+1, $photoX, $photoY);
        call_user_func($imageNew, $imagesFin, $directory . $fileName);
        imagedestroy($imagesOrig);
        imagedestroy($imagesFin);

        return $fileName;
    }

    static public function deleteOldFile($files, $name, &$model, $field)
    {
        $isCorrect = is_array($files) && isset($files[$name]) && !empty($files[$name]);
        if (!$isCorrect)
            return false;

        if (!empty($model) && !empty($model->$field))
        {
            $path = JPath::clean();
            if (file_exists($path . $model->$field))
            {
                unlink($path . $model->$field);
                $model->$field = '';
            }
        }
        return true;
    }
}