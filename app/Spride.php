<?php

namespace App;

class Spride
{
    protected $url;
    protected $file;
    /*public function __construct($url = '',$file = '')
    {
        $this->url = $url;
        $this->file = $file;
    }*/


    /**
     * [getContentFromHtml description]
     * @Author   TANG
     * @DateTime 2017-07-26
     * @param    [type]     $url  [description]
     * @param    string $file [description]
     * @return   [type]           [description]
     */
    public function getContentFromWeb()
    {
        $ch = curl_init();
        $fp = fopen($this->file, 'w');

        curl_setopt($ch, CURLOPT_URL, $this->url);
        curl_setopt($ch, CURLOPT_FILE, $fp);
        curl_setopt($ch, CURLOPT_TIMECONDITION, 30);
        curl_setopt($ch, CURLOPT_HEADER, 0);

        curl_exec($ch);
        fclose($fp);
        curl_close($ch);
    }

    /**
     * [getImagesSrc description]
     * @Author   TANG
     * @DateTime 2017-07-26
     * @param    [type]     $file [description]
     * @return   [type]           [description]
     */
    public function getImagesSrc()
    {
        $contents = file_get_contents($this->file);

        preg_match_all('/<img.+src=\"?(.+\.(jpg|gif|bmp|bnp|png))\"?.+>/i', $contents, $math);

        return $math[1];
    }


    public function setCurlHeader($url)
    {
        $ch = curl_init();

        curl_setopt($ch, CURLOPT_URL, $url);

        //header
        $header = [
            'GET / HTTP/1.1',
            'User-Agent: Mozilla/5.0 (iPhone; CPU iPhone OS 10_3_1 like Mac OS X) AppleWebKit/603.1.30 (KHTML, like Gecko) Version/10.0 Mobile/14E304 Safari/602.1',
            'Accept: text/html,application/xhtml+xml,application/xml;q=0.9,image/webp,image/apng,*/*;q=0.8',
        ];

        curl_setopt($ch, CURLOPT_HTTPHEADER, $header);

        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);


        $output = curl_exec($ch);

        curl_close($ch);

        file_put_contents('github.html', $output);
    }


    /**
     * 下载图片
     * @param $url
     */
    public function downloadFromSrc($url)
    {
        //从网上下载图片
        $path = 'images/';
        $ch = curl_init();
        $filename = $path . md5(pathinfo($url, PATHINFO_BASENAME)) . '.png';

        $fp = fopen($filename, 'w');

        curl_setopt($ch, CURLOPT_URL, $url);

        // 设置获取的信息以文件流的形式输出
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);

        curl_setopt($ch, CURLOPT_FILE, $fp);

        $output = curl_exec($ch);

        $info = curl_getinfo($ch);

        if ($output === FALSE) {
            echo "curl Error" . curl_error($ch);
            print_r($info);
            die();
        }

        curl_close($ch);
    }
}
