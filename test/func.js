/**
 * Created by Administrator on 2015/8/25.
 */

function checkLength(str){
    var len;//字节
    var len0;//字符
    Len=str.replace(/(\r\n)$/gm,'').split(''),len=len0=Len.length;
    for(o in Len)
    {
        if(Len[o].charCodeAt(0)>256)
        {
            len++;
        }
    }
    //alert(len + "字节");
    //alert(len0 + "字符");
    return len0;
}
