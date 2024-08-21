<?php
function imageResize($orginalImage,$width,$height) {
    $targetWidth =50;
    $targetHeight =50;
    $thumbnailImage=imagecreatetruecolor($targetWidth,$targetHeight);
    imagecopyresampled($thumbnailImage,$orginalImage,0,0,0,0,$targetWidth,$targetHeight, $width,$height);
    return $thumbnailImage;
}

function createThumbnail($imageType, $file, $width, $height, $folderPath, $fileNewName){
	
	switch ($imageType) {
            case IMAGETYPE_PNG:
                $originalImage = imagecreatefrompng($file); 
                $thumbnailImage = imageResize($originalImage,$width, $height);
                imagepng($thumbnailImage, $folderPath . "/thumbnail/" . $fileNewName );
                break;
            case IMAGETYPE_GIF:
                $originalImage = imagecreatefromgif($file); 
                $thumbnailImage = imageResize($originalImage,$width, $height);
                imagegif($thumbnailImage,$folderPath . "/thumbnail/" . $fileNewName);
                break;
            case IMAGETYPE_JPEG:
                $originalImage = imagecreatefromjpeg($file); 
                $thumbnailImage = imageResize($originalImage,$width, $height);
                imagejpeg($thumbnailImage,$folderPath . "/thumbnail/" . $fileNewName);
                break;
            default:
                echo "Invalid Image type.";
                exit;
                break;
    }
    move_uploaded_file($file, $folderPath . $fileNewName);
    	
}
?>