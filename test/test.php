<?php
/**
 * 测试
 *
 * @author        肖武 <five@v5ip.com>
 * @datetime      2018/5/29 下午8:29
 */

namespace Five\Browser;
include __DIR__.'/../vendor/autoload.php';

$obj = new test();
//$obj->pageGet();
//$obj->ajaxGet();
//$obj->pagePost();
//$obj->ajaxPost();
$obj->gov();

class test{
    
    function pageGet() {
        $url = 'http://xw33.shijiebang.com/demo/server?b=3';
        
        $b = new Request('/tmp/browser.cookie', '123.234.22.2');
        
        $arr = $b->pageGet($url, ['a' => 1], 'aa');
        print_r($arr);
    }
    
      
    function ajaxGet() {
        $url = 'http://xw33.shijiebang.com/demo/server?b=3';
        
        $b = new Request('/tmp/browser.cookie', '123.234.22.2');
        
        $arr = $b->ajaxGet($url, ['a' => 1], 'aa');
        print_r($arr);
    }
    
      
    function pagePost() {
        $url = 'http://xw33.shijiebang.com/demo/server?b=3';
        
        $b = new Request('/tmp/browser.cookie', '123.234.22.2');
        
        $arr = $b->pagePost($url, ['a' => 1], 'aa');
        print_r($arr);
    }
      
    function ajaxPost() {
        $url = 'http://xw33.shijiebang.com/demo/server?b=3';
        
        $b = new Request('/tmp/browser.cookie', '123.234.22.2');
        
        $arr = $b->ajaxPost($url, ['a' => 1], 'aa');
        print_r($arr);
    }
    
}
