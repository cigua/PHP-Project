<?php
/*发送邮件方法
 *@param $to：接收者 $title：标题 $content：邮件内容
 *@return bool true:发送成功 false:发送失败
 */
function sendMail($to,$title,$content) {
    // 这个PHPMailer 就是之前从 Github上下载下来的那个项目
    require './PHPMailer/PHPMailerAutoload.php';

    $mail = new PHPMailer;

    // 是否启用smtp的debug进行调试 开发环境建议开启 生产环境注释掉即可 默认关闭debug调试模式，
    // 可选择的值有 1 、 2 、 3
    // $mail->SMTPDebug = 2;     

    //使用smtp鉴权方式发送邮件
    $mail->isSMTP();                                      
    //smtp需要鉴权 这个必须是true
    $mail->SMTPAuth = true;                               
    // qq 邮箱的 smtp服务器地址，这里当然也可以写其他的 smtp服务器地址
    $mail->Host = 'smtp.qq.com';
    //smtp登录的账号 这里填入字符串格式的qq号即可
    $mail->Username = '8019203928@qq.com';                 
    // 这个就是之前得到的授权码，一共16位
    $mail->Password = 'oplhduiskmhaweij';     
    //设置使用ssl加密方式登录鉴权                      
    $mail->SMTPSecure = 'ssl';                            
    // //设置ssl连接smtp服务器的远程服务器端口号，可选465或587
    $mail->Port = 465;

    //设置smtp的helo消息头 这个可有可无 内容任意
    // $mail->Helo = 'Hello smtp.qq.com Server';

    //设置发件人的主机域 可有可无 默认为localhost 内容任意，建议使用你的域名
    // $mail->Hostname = 'http://www.lsgogroup.com';

    //设置发送的邮件的编码 也可选 GB2312
    $mail->CharSet = 'UTF-8';                        

    $mail->setFrom('8019203928@qq.com', 'send_user_name');
    // $to 为收件人的邮箱地址，如果想一次性发送向多个邮箱地址，则只需要将下面这个方法多次调用即可
    $mail->addAddress($to);
    //邮件正文是否为html编码 注意此处是一个方法 不再是属性 true或false
    $mail->isHTML(true);
    // 该邮件的主题
    $mail->Subject = $title;
    // 该邮件的正文内容
    $mail->Body = $content;
    //为该邮件添加附件 该方法也有两个参数 第一个参数为附件存放的目录（相对目录、或绝对目录均可） 第二参数为在邮件附件中该附件的名称
    // $mail->addAttachment('./d.jpg','mm.jpg');
    //同样该方法可以多次调用 上传多个附件
    // $mail->addAttachment('./Jlib-1.1.0.js','Jlib.js');

    // 使用 send() 方法发送邮件
    if(!$mail->send()) {
      return 'Mailer Error: ' . $mail->ErrorInfo;
    } else {
        return "\nMessage has been sent";
    }
}

// 调用发送方法
var_dump(sendMail('8019203928@qq.com','会议主题','今天下午开会'));