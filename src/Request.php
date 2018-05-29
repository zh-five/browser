<?php
/**
 * 模拟浏览器的请求
 *
 * @author        肖武 <five@v5ip.com>
 * @datetime      2018/5/29 下午7:58
 */

namespace Five\Browser;

use Five\Browser\RequstInterface;

class Request implements RequestInterface {

    /**
     * 配置信息
     * @var array
     */
    protected $conf = [
        'cookie'     => '',
        'user_agent' => 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_13_4) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/66.0.3359.181 Safari/537.36',
        'timeout'    => 10,
        'ip'         => '',
    ];

    /**
     * 存储cookie的文件
     * @var string
     */
    protected $cookie_file = '';

    /**
     * 伪装客户端的ip
     * @var string
     */
    protected $client_ip = '';

    /**
     * Requst constructor.
     *
     * @param string $cookie_file 存储cookie的文件路径
     * @param string $client_ip   伪装的客户端ip(基于head里的虚假代理数据实现,不一定有效)
     */
    public function __construct($cookie_file = '/tmp/brower.cookie', $client_ip = '') {
        $this->cookie_file = $cookie_file;
        $this->client_ip   = $client_ip;
    }

    public function pageGet($url, $arr_data = [], $referer = '') {
        return $this->get($url, $arr_data, $referer, false);
    }

    public function pagePost($url, $arr_data = [], $referer = '') {
        return $this->http($url, 'POST', $arr_data, $referer, false);
    }

    public function ajaxGet($url, $arr_data = [], $referer = '') {
        return $this->get($url, $arr_data, $referer, true);
    }

    public function ajaxPost($url, $arr_data = [], $referer = '') {
        return $this->http($url, 'POST', $arr_data, $referer, true);
    }


    //----------------------

    protected function get($url, $arr_data, $referer, $is_ajax) {
        if ($arr_data) {
            $url .= (strpos($url, '?') ? '&' : '?') . http_build_query($arr_data);
        }

        return $this->http($url, 'GET', [], $referer, $is_ajax);
    }

    protected function http($url, $method, $arr_data, $referer, $is_ajax) {
        //curl option
        $arr_option = $this->getOptionArray($url, $method, $arr_data, $referer, $is_ajax);

        $ch = curl_init();
        curl_setopt_array($ch, $arr_option);
        $result = curl_exec($ch);
        curl_close($ch);

        return $result;
    }


    protected function getHeadArray($referer, $is_ajax) {
        $arr_head = [
            'ACCEPT_ENCODING' => 'gzip, deflate',
            'ACCEPT_LANGUAGE' => 'zh-CN,zh;q=0.9,en;q=0.8,zh-TW;q=0.7',
            'REFERER' => $referer,
        ];
        
        //自定义
        if ($is_ajax) { //ajax请求
            $arr_head['X-Requested-With'] = 'XMLHttpRequest';
            $arr_head['Accept']           = 'application/json, text/javascript, */*; q=0.01';
        } else { //普通web请求
            $arr_head['Accept'] = 'text/html,application/xhtml+xml,application/xml;q=0.9,image/webp,image/apng,*/*;q=0.8';
            
        }
        
        
        //转换格式
        $out = [];
        foreach ($arr_head as $k => $v) {
            $out[] = $k.':'.$v;
        }
        
        return $out;
    }

    /**
     * 获取curl的选项数组
     *
     * @param string $url
     * @param array  $arr_head
     *
     * @return array
     */
    protected function getOptionArray($url, $method, $arr_data, $referer, $is_ajax) {

        $arr_head = $this->getHeadArray($referer, $is_ajax);

        $arr_option = [
            CURLOPT_URL        => $url,
            CURLOPT_HTTPHEADER => $arr_head, //自定义头部信息
            CURLOPT_USERAGENT  => $this->conf['user_agent'],
            CURLOPT_TIMEOUT    => $this->conf['timeout'],
            CURLOPT_COOKIEJAR  => $this->cookie_file,//结束后保存cookie
            CURLOPT_COOKIEFILE => $this->cookie_file,//读取cookie发送

            //数据相关
            CURLOPT_HEADER         => false, //返回header
            CURLOPT_NOBODY         => false, //返回body
            CURLOPT_RETURNTRANSFER => true, //返回结果数据,不直接输出

            //重定向
            CURLOPT_FOLLOWLOCATION => true, //自动获取重定向地址内容
            CURLOPT_MAXREDIRS      => 6,    //最大重定向次数
            CURLOPT_AUTOREFERER    => TRUE, //重定向时，自动设置 header 中的Referer:信息。

            //https
            CURLOPT_SSL_VERIFYPEER => false, //FALSE 禁止 cURL 验证对等证书（peer's certificate）。要验证的交换证书可以在 CURLOPT_CAINFO 选项中设置，或在 CURLOPT_CAPATH中设置证书目录。	
            CURLOPT_SSL_VERIFYHOST => 0,     //设置为 1 是检查服务器SSL证书中是否存在一个公用名(common name)  0 为不检查名称
        ];

        //post
        if ($method == 'POST') {
            $arr_option[CURLOPT_POSTFIELDS] = $arr_data; // post
        }
        

        return $arr_option;
    }


}