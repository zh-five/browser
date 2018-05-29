<?php
/**
 * 模拟浏览器的请求
 *
 * @author        肖武 <five@v5ip.com>
 * @datetime      2018/5/29 下午7:58
 */

namespace Five\Browser;

use Five\Browser\RequstInterface;

class Requst implements RequstInterface {

    public function __construct($cookie_file = '/tmp/brower.cookie', $client_ip = '') {
        
    }

    public function pageGet($url, $arr_data = [], $referer = '') {
        // TODO: Implement pageGet() method.
    }

    public function pagePost($url, $arr_data = [], $referer = '') {
        // TODO: Implement pagePost() method.
    }

    public function ajaxGet($url, $arr_data = [], $referer = '') {
        // TODO: Implement ajaxGet() method.
    }

    public function ajaxPost($url, $arr_data = [], $referer = '') {
        // TODO: Implement ajaxPost() method.
    }

    /**
     * 获取curl的选项数组
     * @param string $url
     * @param array  $arr_head 头部信息
     *
     * @return array
     */
    protected function getOptionArray($url, $arr_head) {
        
        return [
            CURLOPT_URL        => $url,
            CURLOPT_HTTPHEADER => $arr_head, //自定义头部信息
            CURLOPT_REFERER    => $this->conf['referer'],
            CURLOPT_USERAGENT  => $this->conf['user_agent'],
            CURLOPT_TIMEOUT    => $this->conf['timeout'],
            CURLOPT_COOKIEJAR  => $this->cookie_file,//结束后保存cookie
            CURLOPT_COOKIEFILE => $this->cookie_file,//读取cookie发送
            CURLOPT_HEADER     => true, //返回header
            CURLOPT_NOBODY     => false, //返回body
            CURLOPT_ENCODING   => 'gzip, deflate', //Accept-Encoding:gzip, deflate

            //重定向
            CURLOPT_FOLLOWLOCATION => true, //自动获取重定向地址内容
            CURLOPT_MAXREDIRS      => 6,    //最大重定向次数
            CURLOPT_AUTOREFERER    => TRUE, //重定向时，自动设置 header 中的Referer:信息。
        ];
    }

}