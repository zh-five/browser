<?php
/**
 * 模拟浏览器的请求
 * 
 * @author        肖武 <five@v5ip.com>
 * @datetime      2018/5/29 下午2:32
 */

namespace Five\Browser;

interface RequstInterface{
    
    public function __construct($cookie_file = '/tmp/brower.cookie', $client_ip = '');
    
    public function pageGet($url, $arr_data = [], $referer = '');
    
    public function pagePost($url, $arr_data = [], $referer = '');
    
    public function ajaxGet($url, $arr_data = [], $referer = '');
    
    public function ajaxPost($url, $arr_data = [], $referer = '');
    
}