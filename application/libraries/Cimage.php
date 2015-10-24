<?php

class Cimage
{
    /**
     * 生成保持原图纵横比的缩略图，支持.png .jpg .gif
     * 缩略图类型统一为.png格式
     * $srcFile     原图像文件名称
     * $toW         缩略图宽
     * $toH         缩略图高
     * $toFile      缩略图文件名称，为空覆盖原图像文件.
     *
     * @return bool
     */
    /*
    public function create_thumbnail($srcFile, $toW, $toH, $toFile="")
    {
        if ($toFile == "")
        {
               $toFile = $srcFile;
        }
        $info = "";
        //返回含有4个单元的数组，0-宽，1-高，2-图像类型，3-宽高的文本描述。
        //失败返回false并产生警告。
        $data = getimagesize($srcFile, $info);
        if (!$data)
            return false;

        //将文件载入到资源变量im中
        switch ($data[2]) //1-GIF，2-JPG，3-PNG
        {
        case 1:
            if(!function_exists("imagecreatefromgif"))
            {
                //echo "the GD can't support .gif, please use .jpeg or .png! <a href='javascript:history.back();'>back</a>";
                exit();
            }
            $im = imagecreatefromgif($srcFile);
            break;

        case 2:
            if(!function_exists("imagecreatefromjpeg"))
            {
                //echo "the GD can't support .jpeg, please use other picture! <a href='javascript:history.back();'>back</a>";
                exit();
            }
            $im = imagecreatefromjpeg($srcFile);
            break;

        case 3:
            $im = imagecreatefrompng($srcFile);
            break;
        }

        //计算缩略图的宽高
        $srcW = imagesx($im);
        $srcH = imagesy($im);
        $toWH = $toW / $toH;
        $srcWH = $srcW / $srcH;
        if ($toWH <= $srcWH)
        {
            $ftoW = $toW;
            $ftoH = (int)($ftoW * ($srcH / $srcW));
        }
        else
        {
            $ftoH = $toH;
            $ftoW = (int)($ftoH * ($srcW / $srcH));
        }

        if (function_exists("imagecreatetruecolor"))
        {
            $ni = imagecreatetruecolor($ftoW, $ftoH); //新建一个真彩色图像
            if ($ni)
            {
                //重采样拷贝部分图像并调整大小 可保持较好的清晰度
                imagecopyresampled($ni, $im, 0, 0, 0, 0, $ftoW, $ftoH, $srcW, $srcH);
            }
            else
            {
                //拷贝部分图像并调整大小
                $ni = imagecreate($ftoW, $ftoH);
                imagecopyresized($ni, $im, 0, 0, 0, 0, $ftoW, $ftoH, $srcW, $srcH);
            }
        }
        else
        {
            $ni = imagecreate($ftoW, $ftoH);
            imagecopyresized($ni, $im, 0, 0, 0, 0, $ftoW, $ftoH, $srcW, $srcH);
        }

        //保存到文件 统一为.png格式
        imagepng($ni, $toFile); //以 PNG 格式将图像输出到浏览器或文件
        ImageDestroy($ni);
        ImageDestroy($im);
        return true;
    }
    */
    /**
     * 生成缩略图.
     *
     * @author yangzhiguo0903@163.com
     *
     * @param string     源图绝对完整地址{带文件名及后缀名}
     * @param string     目标图绝对完整地址{带文件名及后缀名}
     * @param int        缩略图宽{0:此时目标高度不能为0，目标宽度为源图宽*(目标高度/源图高)}
     * @param int        缩略图高{0:此时目标宽度不能为0，目标高度为源图高*(目标宽度/源图宽)}
     * @param int        是否裁切{宽,高必须非0}
     * @param int/float  缩放{0:不缩放, 0<this<1:缩放到相应比例(此时宽高限制和裁切均失效)}
     *
     * @return bool
     */
    public function img2thumb($src_img, $dst_img, $width = 300, $height = 230, $cut = 0, $proportion = 0)
    {
        if (!is_file($src_img)) {
            return false;
        }
        $ot = strtolower($this->fileext($dst_img));
        $otfunc = 'image'.($ot == 'jpg' ? 'jpeg' : $ot);
        $srcinfo = getimagesize($src_img);
        $src_w = $srcinfo[0];
        $src_h = $srcinfo[1];
        $type = strtolower(substr(image_type_to_extension($srcinfo[2]), 1));
        $createfun = 'imagecreatefrom'.($type == 'jpg' ? 'jpeg' : $type);

        $dst_h = $height;
        $dst_w = $width;
        $x = $y = 0;

        /*
         * 缩略图不超过源图尺寸（前提是宽或高只有一个）
         */
        if (($width > $src_w && $height > $src_h) || ($height > $src_h && $width == 0) || ($width > $src_w && $height == 0)) {
            $proportion = 1;
        }
        if ($width > $src_w) {
            $dst_w = $width = $src_w;
        }
        if ($height > $src_h) {
            $dst_h = $height = $src_h;
        }

        if (!$width && !$height && !$proportion) {
            return false;
        }
        if (!$proportion) {
            if ($cut == 0) {
                if ($dst_w && $dst_h) {
                    if ($dst_w / $src_w > $dst_h / $src_h) {
                        $dst_w = $src_w * ($dst_h / $src_h);
                        $x = 0 - ($dst_w - $width) / 2;
                    } else {
                        $dst_h = $src_h * ($dst_w / $src_w);
                        $y = 0 - ($dst_h - $height) / 2;
                    }
                } elseif ($dst_w xor $dst_h) {
                    if ($dst_w && !$dst_h) {
                        //有宽无高

                        $propor = $dst_w / $src_w;
                        $height = $dst_h = $src_h * $propor;
                    } elseif (!$dst_w && $dst_h) {
                        //有高无宽

                        $propor = $dst_h / $src_h;
                        $width = $dst_w = $src_w * $propor;
                    }
                }
            } else {
                if (!$dst_h) {
                    //裁剪时无高

                    $height = $dst_h = $dst_w;
                }
                if (!$dst_w) {
                    //裁剪时无宽

                    $width = $dst_w = $dst_h;
                }
                $propor = min(max($dst_w / $src_w, $dst_h / $src_h), 1);
                $dst_w = (int) round($src_w * $propor);
                $dst_h = (int) round($src_h * $propor);
                $x = ($width - $dst_w) / 2;
                $y = ($height - $dst_h) / 2;
            }
        } else {
            $proportion = min($proportion, 1);
            $height = $dst_h = $src_h * $proportion;
            $width = $dst_w = $src_w * $proportion;
        }

        $src = $createfun($src_img);
        $dst = imagecreatetruecolor($width ? $width : $dst_w, $height ? $height : $dst_h);
        $white = imagecolorallocate($dst, 255, 255, 255);
        imagefill($dst, 0, 0, $white);

        if (function_exists('imagecopyresampled')) {
            imagecopyresampled($dst, $src, $x, $y, 0, 0, $dst_w, $dst_h, $src_w, $src_h);
        } else {
            imagecopyresized($dst, $src, $x, $y, 0, 0, $dst_w, $dst_h, $src_w, $src_h);
        }
        $otfunc($dst, $dst_img);
        imagedestroy($dst);
        imagedestroy($src);

        return true;
    }
    public function fileext($file)
    {
        return pathinfo($file, PATHINFO_EXTENSION);
    }
}
