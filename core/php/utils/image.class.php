<?php

class Image
{
    public $file;
    public $tmpFile;
    public $fileName;
    public $ext;
    public $resize;
    public $backgroundColor;
    public $srcWidth;
    public $srcHeight;
    public $limitWidth;
    public $limitHeight;
    public $newWidth;
    public $newHeight;

    public function __construct($file, $resize, $limitWidth = null, $limitHeight = null)
    {
        global $config;

        $this->file            = $file;
        $this->tmpFile         = $this->file["tmp_name"];
        $this->fileName        = $this->file["name"];
        $this->ext             = $this->GetImageExtension();
        $this->resize          = $resize;
        $this->backgroundColor = array(255, 255, 255);

        list($this->srcWidth, $this->srcHeight) = getimagesize($this->tmpFile);
        $this->limitWidth  = $limitWidth;
        $this->limitHeight = $limitHeight;
        list($this->newWidth, $this->newHeight) = $this->GetResize();
    }

    /**
     * @function ! Retourne l'extension de l'image
     */
    public function GetImageExtension()
    {
        switch ($this->file["type"])
        {
            case "image/jpeg":
            case "image/jpg":
                return "jpg";
                break;

            case "image/png":
                return "png";
                break;

            case "image/gif":
                return "gif";
                break;
        }
    }

    /**
     * @function ! Affecte la couleur d'image de fond
     */
    public function SetBackgroundColor($backgroundColor)
    {
        $this->backgroundColor = $backgroundColor;
    }

    public function GetCouleurPixel($x, $y)
    {
        switch ($this->ext)
        {
            case "jpg":
                $im = imagecreatefromjpeg($this->tmpFile);
                break;
            case "png":
                $im = imagecreatefrompng($this->tmpFile);
                break;
            case "gif":
                $im = imagecreatefromgif($this->tmpFile);
                break;
        }
        $colorIndex = imagecolorat($im, $x, $y);
        $colorTran  = imagecolorsforindex($im, $colorIndex);
        return $colorTran;
    }

    /**
     * @function : Récupére la largeur et la longueur de l'image en fonction des nouvelles dimensions souhaitées
     */
    public function GetResize()
    {
        $size = array();

        switch ($this->resize)
        {
            # La taille de l'image sera adapté a la taille fixé, si cette image est trop grande, l'image est rognée
            case "adaptative":
                $size[0] = $this->limitWidth;
                $size[1] = floor(($this->limitWidth * $this->srcHeight) / $this->srcWidth);
                if ($size[1] < $this->limitHeight)
                {
                    $size[0] = floor(($this->limitHeight * $this->srcWidth) / $this->srcHeight);
                    $size[1] = $this->limitHeight;
                }
                break;

            # La taille de l'image sera adapté a la taille fixé, si cette image est trop grande, l'image est rognée
            # Gére aussi le cas d'une image verticale
            case "adaptativeHV":
                # Image verticale
                if ($this->srcHeight > ($this->srcWidth - 10))
                {
                    $size[0] = $this->limitWidth;
                    $size[1] = floor(($this->limitWidth * $this->srcHeight) / $this->srcWidth);
                    if ($size[1] < $this->limitHeight)
                    {
                        $size[0] = floor(($this->limitHeight * $this->srcWidth) / $this->srcHeight);
                        $size[1] = $this->limitHeight;
                    }
                }
                # Image horizontale
                else
                {
                    $size[0] = $this->limitHeight;
                    $size[1] = floor(($this->limitHeight * $this->srcHeight) / $this->srcWidth);
                }
                break;

            case "complete":
                if ($this->srcWidth > $this->limitWidth || $this->srcHeight > $this->limitHeight)
                {
                    $size[0] = $this->limitWidth;
                    $size[1] = floor(($this->limitWidth * $this->srcHeight) / $this->srcWidth);
                    if ($size[1] > $this->limitHeight)
                    {
                        $size[0] = floor(($this->limitHeight * $this->srcWidth) / $this->srcHeight);
                        $size[1] = $this->limitHeight;
                    }
                }
                else
                {
                    $size[0] = $this->srcWidth;
                    $size[1] = $this->srcHeight;
                }
                break;

            case "auto":
                if ($this->srcWidth > $this->limitWidth || $this->srcHeight > $this->limitHeight)
                {
                    $size[0] = $this->limitWidth;
                    $size[1] = floor(($this->limitWidth * $this->srcHeight) / $this->srcWidth);
                    if ($size[1] > $this->limitHeight)
                    {
                        $size[0] = floor(($this->limitHeight * $this->srcWidth) / $this->srcHeight);
                        $size[1] = $this->limitHeight;
                    }
                }
                else
                {
                    $size[0] = $this->srcWidth;
                    $size[1] = $this->srcHeight;
                }
                break;

            case "width":
                $size[0] = $this->limitWidth;
                $size[1] = floor(($this->limitWidth * $this->srcHeight) / $this->srcWidth);
                break;

            case "height":
                $size[0] = floor(($this->limitHeight * $this->srcWidth) / $this->srcHeight);
                $size[1] = $this->limitHeight;
                break;
        }

        return $size;
    }

    /**
     * @function : Copie l'image vers une destination
     * @param $typeCopy :
     * 	-> copie soit la version resize
     * 	-> copie soit la version original
     */
    public function CopyTo($path, $fileName, $typeCopy = null)
    {

        if (!is_dir($path))
        {
            mkdir($path, 0777, true);
        }

        switch ($typeCopy)
        {
            default :

                #Si Resize auto, witdh ou height, alors upload une image avec les nouvelles dimension de l'image
                if ($this->resize == "auto" || $this->resize == "width" || $this->resize == "height")
                {
                    $resizeWidth  = $this->newWidth;
                    $resizeHeight = $this->newHeight;
                    $ximg         = 0;
                    $yimg         = 0;
                }
                #Sinon on upload une image qui posséde toujours les mêmes dimensions
                elseif ($this->resize == "adaptative" || $this->resize == "complete")
                {
                    $resizeWidth  = $this->limitWidth;
                    $resizeHeight = $this->limitHeight;
                    $ximg         = ($this->newWidth == $this->limitWidth) ? 0 : floor(($this->limitWidth - $this->newWidth) / 2);
                    $yimg         = ($this->newHeight == $this->limitHeight) ? 0 : floor(($this->limitHeight - $this->newHeight) / 2);
                }
                elseif ($this->resize == "adaptativeHV")
                {
                    # Image verticale
                    if ($this->srcHeight > ($this->srcWidth - 10))
                    {
                        $resizeWidth  = $this->limitWidth;
                        $resizeHeight = $this->limitHeight;
                        $ximg         = ($this->newWidth == $this->limitWidth) ? 0 : floor(($this->limitWidth - $this->newWidth) / 2);
                        $yimg         = ($this->newHeight == $this->limitHeight) ? 0 : floor(($this->limitHeight - $this->newHeight) / 2);
                    }
                    else
                    {
                        $resizeWidth  = $this->limitHeight;
                        $resizeHeight = $this->limitWidth;
                        $ximg         = ($this->newWidth == $this->limitHeight) ? 0 : floor(($this->limitHeight - $this->newWidth) / 2);
                        $yimg         = ($this->newHeight == $this->limitWidth) ? 0 : floor(($this->limitWidth - $this->newHeight) / 2);
                    }
                }

                switch ($this->ext)
                {
                    case "jpg":
                        $imgSrcCopy    = imagecreatefromjpeg($this->tmpFile);
                        $imgResizeCopy = imagecreatetruecolor($resizeWidth, $resizeHeight);
                        $background    = imagecolorallocate($imgResizeCopy, $this->backgroundColor[0], $this->backgroundColor[1], $this->backgroundColor[2]);
                        imagefilledrectangle($imgResizeCopy, 0, 0, $resizeWidth, $resizeHeight, $background);
                        imagecopyresampled($imgResizeCopy, $imgSrcCopy, $ximg, $yimg, 0, 0, $this->newWidth, $this->newHeight, $this->srcWidth, $this->srcHeight);
                        $res           = imagejpeg($imgResizeCopy, $path . $fileName . "." . $this->ext, 90);
                        if ($res) return true;
                        else return false;
                        break;
                    case "png":
                        $imgSrcCopy    = imagecreatefrompng($this->tmpFile);
                        $imgResizeCopy = imagecreatetruecolor($resizeWidth, $resizeHeight);
                        $background    = imagecolorallocate($imgResizeCopy, $this->backgroundColor[0], $this->backgroundColor[1], $this->backgroundColor[2]);
                        imagefilledrectangle($imgResizeCopy, 0, 0, $resizeWidth, $resizeHeight, $background);
                        imagecolorallocate($imgResizeCopy, $this->backgroundColor[0], $this->backgroundColor[1], $this->backgroundColor[2]);
                        imagecopyresampled($imgResizeCopy, $imgSrcCopy, $ximg, $yimg, 0, 0, $this->newWidth, $this->newHeight, $this->srcWidth, $this->srcHeight);
                        $res           = imagepng($imgResizeCopy, $path . $fileName . "." . $this->ext, 0);
                        if ($res) return true;
                        else return false;
                        break;
                    case "gif":
                        $imgSrcCopy    = imagecreatefromgif($this->tmpFile);
                        $imgResizeCopy = imagecreatetruecolor($resizeWidth, $resizeHeight);
                        $background    = imagecolorallocate($imgResizeCopy, $this->backgroundColor[0], $this->backgroundColor[1], $this->backgroundColor[2]);
                        imagefilledrectangle($imgResizeCopy, 0, 0, $resizeWidth, $resizeHeight, $background);
                        imagecolorallocate($imgResizeCopy, $this->backgroundColor[0], $this->backgroundColor[1], $this->backgroundColor[2]);
                        imagecopyresampled($imgResizeCopy, $imgSrcCopy, $ximg, $yimg, 0, 0, $this->newWidth, $this->newHeight, $this->srcWidth, $this->srcHeight);
                        $res           = imagegif($imgResizeCopy, $path . $fileName . "." . $this->ext);
                        if ($res) return true;
                        else return false;
                        break;
                }
                break;

            case "original":
                $res = copy($this->tmpFile, $path . $fileName . "." . $this->ext);
                if ($res) return true;
                else return false;
                break;
        }
    }

}
?>