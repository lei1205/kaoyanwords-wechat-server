<?php

header('Content-type:text/html;charset=utf8');
require './weixin.class.php';
require './fromDB.php';

$appid="balabala";//这里请填你真实的参数值
$appsecret="balabala";//这里请填你真实的参数值
$token="balabala";//这里请填你真实的参数值

$wx=new WeChat($appid,$appsecret,$token);
$fdb=new fromdb();


//验证url
// $wx->firstValid();

//判断消息类型
$result=$wx->responseMsg();

if($result['type']=='text'){
    //文本消息


    $greetings = array('你好','你好呀','嗨','哈啰','哦我的朋友','你来啦','Hello','Hi','hello','hi');
    $char = "。、！？：；﹑•＂…‘’“”〝〞∕¦‖—　〈〉﹞﹝「」‹›〖〗】【»«』『〕〔》《﹐¸﹕︰﹔！¡？¿﹖﹌﹏﹋＇´ˊˋ ―﹫︳︴¯＿￣﹢﹦﹤‐­˜﹟﹩﹠﹪﹡﹨﹍﹉﹎﹊ˇ︵︶︷︸︹︿﹀︺︽︾ˉ﹁﹂﹃﹄︻︼（）";
        $pattern = array('/[[:punct:]]/i', '/['.$char.']/u', '/[ ]{2,}/');
        $str = preg_replace($pattern, '', $result['obj']->Content);

    if($str=='文章'){
        transmitLink($result['obj'], '文章列表','文章列表','https://example.com/sad.png','https://mp.weixin.qq.com/s/balabala');
    }
    elseif(in_array($str,$greetings)){
                $random_seed_greetings=rand(0,count($greetings)-1);
        transmitText($result['obj'], $greetings[$random_seed_greetings].'[旺柴]
查看往期内容请回复“文章”
背单词请回复“6”');
    }
    elseif($str=='6'){
        $words = $fdb->getwords();
        transmitText($result['obj'], '你知道'.$words.'的意思吗？
<a href="weixin://bizmsgmenu?msgmenucontent=6&msgmenuid=1">YES</a>  |  <a href="weixin://bizmsgmenu?msgmenucontent='.$words.'&msgmenuid=1">NO</a>');
    }
    elseif($fdb->check($str)){
        transmitText($result['obj'], $fdb->getinfo($str).'<a href="weixin://bizmsgmenu?msgmenucontent=6&msgmenuid=1">下一个单词</a>');
    }
    else{
        transmitText($result['obj'], $result['obj']->Content.'[旺柴]');
    }
}
elseif($result['type']=='image'){
    //图片消息
    transmitText($result['obj'], '我还不会看图说话/大哭');
}
elseif($result['type']=='voice'){
    //语音消息
    transmitText($result['obj'], '我不听我不听/白眼');
}


/*
 * 回复文本消息
 */
function transmitText($object, $content)
{
    $textTpl = "<xml>
        <ToUserName><![CDATA[%s]]></ToUserName>
        <FromUserName><![CDATA[%s]]></FromUserName>
        <CreateTime>%s</CreateTime>
        <MsgType><![CDATA[text]]></MsgType>
        <Content><![CDATA[%s]]></Content>
        </xml>";
    $result = sprintf($textTpl, $object->FromUserName, $object->ToUserName, time(), $content);
    file_put_contents('./test.txt',$result);
    echo $result;die;
    // return $result;
}

/*
 * 回复链接消息
 */
function transmitLink($object, $title, $description, $picurl, $url)
{
    $textTpl = "<xml>
        <ToUserName><![CDATA[%s]]></ToUserName>
        <FromUserName><![CDATA[%s]]></FromUserName>
        <CreateTime>%s</CreateTime>
        <MsgType><![CDATA[news]]></MsgType>
        <ArticleCount>1</ArticleCount>
        <Articles>
        <item>
        <Title><![CDATA[%s]]></Title>
        <Description><![CDATA[%s]]></Description>
        <PicUrl><![CDATA[%s]]></PicUrl>
        <Url><![CDATA[%s]]></Url>
        </item>
        <item>
        </xml>";
    $result = sprintf($textTpl, $object->FromUserName, $object->ToUserName, time(), $title,$description,$picurl,$url);
    file_put_contents('./test.txt',$result);
    echo $result;die;
    // return $result;
}
?>