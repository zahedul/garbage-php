<?php
/**
*/
class Imageresize(){

	private $imageName;
	private $imageType;
	private $imageExt;
	private $imagePath;
	private $imageHeight;
	private $imageWidth;

	private $deleteImage;

	private $imageMaxHeight;
	private $imageMaxWidth;

	private $newImagePath;		

	private $imageNewName;
	private $changeExt;

	function __construct(){

	}

	public function setImage(){
		
	}
}

private function imageResize($targetImage) {

        list($uploadImgWidth, $uploadImgHeight) = getimagesize($targetImage['imgPath']);
        $newHeight = $uploadImgHeight;
        $newWidth = $uploadImgWidth;
        if ($uploadImgWidth > 605 || $uploadImgHeight > 545) {
            $ratioH = 545 / $uploadImgHeight;
            $ratioW = 605 / $uploadImgWidth;
            if ($ratioW > $ratioH) {
                $newHeight = 545;
                $newWidth = $uploadImgWidth * $ratioH;
            } else {
                $newWidth = 605;
                $newHeight = $uploadImgHeight * $ratioW;
            }
            $newImagePath = $_SERVER['DOCUMENT_ROOT'] . $this->getRequest()->getBaseUrl() .'/public/uploads/logo/';
            
            $newImagePath = str_replace('//', '/', $newImagePath);
            $newtargetImage = $newImagePath . $targetImage['imgName'];

            $dst_r = ImageCreateTrueColor($newWidth, $newHeight);
            $targetImageInfo = getimagesize($targetImage['imgPath']);
            if ($targetImageInfo):
                switch ($targetImageInfo['mime']) {
                    case "image/gif":

                        $img_r = imagecreatefromgif($targetImage['imgPath']);
                        imagecopyresampled($dst_r, $img_r, 0, 0, 0, 0, $newWidth, $newHeight, $uploadImgWidth, $uploadImgHeight);

                        imagegif($dst_r, $newtargetImage);

                        break;
                    case "image/jpeg":

                        $img_r = imagecreatefromjpeg($targetImage['imgPath']);
                        imagecopyresampled($dst_r, $img_r, 0, 0, 0, 0, $newWidth, $newHeight, $uploadImgWidth, $uploadImgHeight);

                        imagejpeg($dst_r, $newtargetImage, 90);

                        break;
                    case "image/png":

                        $img_r = imagecreatefrompng($targetImage['imgPath']);
                        imagecopyresampled($dst_r, $img_r, 0, 0, 0, 0, $newWidth, $newHeight, $uploadImgWidth, $uploadImgHeight);

                        imagepng($dst_r, $newtargetImage);

                        break;
                    default:
                        break;
                }
            endif;
        }
        $newImageInfo = array(
            'height' =>$newHeight,
            'width'  =>$newWidth,
            'imgName'=>$targetImage['imgName'],
            );
        return $newImageInfo;
    }