<?php

class Oss
{
    public function __construct()
    {
        include_once './application/third_party/oss/sdk.class.php';

        $this->ossbuket = OSS_BUCKET;
        $this->ossid = OSS_ACCESS_ID;
        $this->osskey = OSS_ACCESS_KEY;
        $this->ossserver = OSS_SERVER;
        $this->ossobj = new ALIOSS($this->ossid, $this->osskey, $this->ossserver);
    }

    /**
     * [upload_by_file 上传文件].
     *
     * @param [type] $osspath [本地服务器路径]
     *
     * @return [type] [description]
     */
    public function upload_by_file($osspath)
    {
        $serverpath = $osspath;
        //$osspath    = substr_replace($osspath, "", 0, 1);
        $is_object_exist = $this->ossobj->is_object_exist($this->ossbuket, $osspath);
        $isexist = $is_object_exist->isOK();
        if ($isexist) {
            return $is_object_exist->header['_info']['url'];
        } else {
            $response = $this->ossobj->upload_file_by_file($this->ossbuket, $osspath, $serverpath);

            return $response->header['_info']['url'];
        }

        return false;
    }
    /**
     * [delete_object 删除文件].
     *
     * @param [type] $osspath [description]
     *
     * @return [type] [description]
     */
    public function delete_object($osspath)
    {
        $isok = true;
        //$osspath = substr_replace($osspath, "", 0, 1);
        $isexist = $this->ossobj->is_object_exist($this->ossbuket, $osspath);
        if ($isexist) {
            $response = $this->ossobj->delete_object($this->ossbuket, $osspath);
            $isok = $response->isOK();
            if (!$isok) {
                //$this->_format($response);
                return false;
            }
        }

        return $isok;
    }

    /**
     * [is_object_exist 查看文件是否存在].
     *
     * @param [type] $osspath [description]
     *
     * @return bool [description]
     */
    public function is_object_exist($osspath)
    {
        $osspath = substr_replace($osspath, '', 0, 1);
        $response = $this->ossobj->is_object_exist($this->ossbuket, $osspath);
        $isok = $response->isOK();
        if (!$isok) {
            //$this->_format($response);
            die();
        }

        return $isok;
    }

    //格式化返回结果
    public function _format($response)
    {
        echo '|-----------------------Start---------------------------------------------------------------------------------------------------'."\n";
        echo '|-Status:'.$response->status."\n";
        echo '|-Body:'."\n";
        echo $response->body."\n";
        echo "|-Header:\n";
        print_r($response->header);
        echo '-----------------------End-----------------------------------------------------------------------------------------------------'."\n\n";
    }
}
