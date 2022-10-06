<?php

namespace App\Services;

class Upload
{
    public string $target_file;
    public $temp_name;
    public string $save_name;
    public string $computed_path;
    public bool $make_thumb;
    public int $width;
    public int $height;

    public function __construct( string $string, string $path = "", bool $thumb = false, $width = 200, $height = 200 )
    {

        $this->make_thumb = $thumb;
        $this->width = $width;
        $this->height = $height;

        $this->computed_path = $_SERVER['DOCUMENT_ROOT'] .'/files/' . $path;
        $temp = explode(".", $_FILES[$string]["name"]);

        $this->save_name = round(microtime(true)) . '.' . end($temp);
        //        $this->save_name = $save_name .'.'. end($temp);

        if (!is_dir($this->computed_path)) { 
            mkdir($this->computed_path, 0777, true);
        }

        $this->target_file = $this->computed_path . '/' . $this->save_name;
        $this->temp_name = $_FILES[$string]["tmp_name"];
    }

    public function move() : bool
    {
        $moved = move_uploaded_file($this->temp_name, $this->target_file);
        if ($moved && $this->make_thumb) { 
            $this->makeThumbnails();
        }
        return $moved;
    }

    public static function check( $file ) : bool
    {
        return !( !isset($_FILES[ $file ]) || $_FILES[ $file ]['error'] == UPLOAD_ERR_NO_FILE );
    }

    public static function checkType( $file, $type = [] ) : bool
    {
        return in_array(pathinfo($_FILES[$file]['name'], PATHINFO_EXTENSION), $type);
    }


    public function makeThumbnails()
    {
        $thumbnail_width = $this->width;
        $thumbnail_height = $this->height;
        $imgcreatefrom = "imagecreatefromjpeg";
        $arr_image_details = getimagesize("$this->target_file"); // pass id to thumb name
        $original_width = $arr_image_details[0];
        $original_height = $arr_image_details[1];
        if ($original_width > $original_height) {
            $new_width = $thumbnail_width;
            $new_height = intval($original_height * $new_width / $original_width);
        } else {
            $new_height = $thumbnail_height;
            $new_width = intval($original_width * $new_height / $original_height);
        }
        $dest_x = intval(($thumbnail_width - $new_width) / 2);
        $dest_y = intval(($thumbnail_height - $new_height) / 2);
        if ($arr_image_details[2] == IMAGETYPE_GIF) {
            $imgt = "ImageGIF";
            $imgcreatefrom = "imagecreatefromgif";
        }
        if ($arr_image_details[2] == IMAGETYPE_JPEG) {
            $imgt = "ImageJPEG";
            $imgcreatefrom = "imagecreatefromjpeg";
        }
        if ($arr_image_details[2] == IMAGETYPE_PNG) {
            $imgt = "ImagePNG";
            $imgcreatefrom = "imagecreatefrompng";
        }
        if ($imgt) {

            $old_image = $imgcreatefrom("$this->target_file");
            $new_image = imagecreatetruecolor($thumbnail_width, $thumbnail_height);
            imagecopyresized($new_image, $old_image, $dest_x, $dest_y, 0, 0, $new_width, $new_height, $original_width, $original_height);
            $imgt($new_image, $this->computed_path . '/thumb_' . $this->save_name);
        }
    }

}
