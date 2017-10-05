<?php

namespace App\Logic\Image;

use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\File;
use Intervention\Image\ImageManager;
use App\ExperienceImages;

class ImageRepository
{
    public function upload( $form_data )
    {
        $experience_id = $form_data["experience_id"];
        $names = [];

        if(isset($form_data['file'])) {
            $photo = $form_data['file'];


            $originalName = $photo->getClientOriginalName();
            $extension = $photo->getClientOriginalExtension();
            $originalNameWithoutExt = substr($originalName, 0, strlen($originalName) - strlen($extension) - 1);

            $filename = $this->sanitize($originalNameWithoutExt);
            $allowed_filename = $this->createUniqueFilename($filename, $extension);
            $names[] = $allowed_filename;
            $uploadSuccess1 = $this->original($photo, $allowed_filename);
            $uploadSuccess2 = $this->icon($photo, $allowed_filename);

            $imagedir = $uploadSuccess1->dirname . "/" . $uploadSuccess1->basename;
            $icondir = $uploadSuccess2->dirname . "/" . $uploadSuccess2->basename;

            if (!$uploadSuccess1 || !$uploadSuccess2) {

                return Response::json([
                    'error' => true,
                    'message' => 'Server error while uploading',
                    'code' => 500
                ], 500);

            }
            ExperienceImages::updateOrCreate([
                "experience_id" => $experience_id,
                "image_file" => $imagedir,
                "icon_file" => $icondir,
                "thumbnail" => 0
            ]);
        }else if(isset($form_data["files"])){
            $photos = $form_data['files'];

            foreach($photos as $photo) {
                $originalName = $photo->getClientOriginalName();
                $extension = $photo->getClientOriginalExtension();
                $originalNameWithoutExt = substr($originalName, 0, strlen($originalName) - strlen($extension) - 1);

                $filename = $this->sanitize($originalNameWithoutExt);
                $allowed_filename = $this->createUniqueFilename($filename, $extension);
                $names[] = $allowed_filename;
                $uploadSuccess1 = $this->original($photo, $allowed_filename);
                $uploadSuccess2 = $this->icon($photo, $allowed_filename);

                $imagedir = $uploadSuccess1->dirname . "/" . $uploadSuccess1->basename;
                $icondir = $uploadSuccess2->dirname . "/" . $uploadSuccess2->basename;

                if (!$uploadSuccess1 || !$uploadSuccess2) {

                    return Response::json([
                        'error' => true,
                        'message' => 'Server error while uploading',
                        'code' => 500
                    ], 500);

                }
                ExperienceImages::updateOrCreate([
                    "experience_id" => $experience_id,
                    "image_file" => $imagedir,
                    "icon_file" => $icondir,
                    "thumbnail" => 0
                ]);
            }
        }

        return Response::json([
            'error' => false,
            'code'  => 200,
            'filename' => json_encode($names)
        ], 200);

    }

    public function createUniqueFilename( $filename, $extension )
    {
        $full_size_dir = Config::get('images.full_size').date("Y")."/".date("m")."/";
        $full_image_path = $full_size_dir . $filename . '.' . $extension;

        if(!File::exists(Config::get('images.full_size').date("Y"))){
            File::makeDirectory(Config::get('images.full_size').date("Y"));
        }
        if(!File::exists($full_size_dir)){
            File::makeDirectory($full_size_dir);
        }
        if ( File::exists( $full_image_path ) )
        {
            // Generate token for image
            $imageToken = substr(sha1(mt_rand()), 0, 5);
            return $filename . '-' . $imageToken . '.' . $extension;
        }

        return $filename . '.' . $extension;
    }

    /**
     * Optimize Original Image
     */
    public function original( $photo, $filename )
    {
        $full_size_dir = Config::get('images.full_size').date("Y")."/".date("m")."/";
        if(!File::exists(Config::get('images.full_size').date("Y"))){
            File::makeDirectory(Config::get('images.full_size').date("Y"));
        }
        if(!File::exists($full_size_dir)){
            File::makeDirectory($full_size_dir);
        }
        $manager = new ImageManager();
        $image = $manager->make( $photo )->save($full_size_dir . $filename );

        return $image;
    }

    /**
     * Create Icon From Original
     */
    public function icon( $photo, $filename )
    {
        $full_icon_dir = Config::get('images.icon_size').date("Y")."/".date("m")."/";
        if(!File::exists(Config::get('images.icon_size').date("Y")."/")){
            File::makeDirectory(Config::get('images.icon_size').date("Y"));
        }
        if(!File::exists($full_icon_dir)){
            File::makeDirectory($full_icon_dir);
        }
        $manager = new ImageManager();
        $image = $manager->make( $photo )->resize(200, null, function ($constraint) {
            $constraint->aspectRatio();
        })
            ->save( $full_icon_dir  . $filename );

        return $image;
    }

    /**
     * Delete Image From Session folder, based on server created filename
     */
    public function delete( $file_path,$experience_id )
    {
        $file_path = ltrim($file_path, '/');


        $full_size_dir = Config::get('images.full_size').date("Y")."/".date("m")."/";
        $icon_size_dir = Config::get('images.icon_size').date("Y")."/".date("m")."/";

        $sessionImage = ExperienceImages::whereExperienceId($experience_id)->whereImageFile($file_path)->orWhere('icon_file','like',$file_path)->first();
        if(empty($sessionImage))
        {
            return Response::json([
                'error' => true,
                'code'  => 400
            ], 400);

        }

        $full_path1 = $full_size_dir . $sessionImage->filename;
        $full_path2 = $icon_size_dir . $sessionImage->filename;

        if ( File::exists( $full_path1 ) )
        {
            File::delete( $full_path1 );
        }

        if ( File::exists( $full_path2 ) )
        {
            File::delete( $full_path2 );
        }

        if( !empty($sessionImage))
        {
            $sessionImage->delete();
        }

        return Response::json([
            'error' => false,
            'code'  => 200
        ], 200);
    }

    function sanitize($string, $force_lowercase = true, $anal = false)
    {
        $strip = array("~", "`", "!", "@", "#", "$", "%", "^", "&", "*", "(", ")", "_", "=", "+", "[", "{", "]",
            "}", "\\", "|", ";", ":", "\"", "'", "&#8216;", "&#8217;", "&#8220;", "&#8221;", "&#8211;", "&#8212;",
            "â€”", "â€“", ",", "<", ".", ">", "/", "?");
        $clean = trim(str_replace($strip, "", strip_tags($string)));
        $clean = preg_replace('/\s+/', "-", $clean);
        $clean = ($anal) ? preg_replace("/[^a-zA-Z0-9]/", "", $clean) : $clean ;

        return ($force_lowercase) ?
            (function_exists('mb_strtolower')) ?
                mb_strtolower($clean, 'UTF-8') :
                strtolower($clean) :
            $clean;
    }
}