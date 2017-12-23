function checkphone(str) {  
  var myreg=/^[1][3,4,5,6,7,8,9][0-9]{9}$/;  
  if (!myreg.test(str)) {  
      return false;  
  } else {  
      return true;  
  }  
}  

function myreload(){
    window.location.href=updateUrl(window.location.href);
}

function updateUrl(url,k,v,rule){
    var rule= (eval('/('+ k+'=)([^&]*)/gi') || eval('/(t=)([^&]*)/gi'));  //默认是数字
    // var rule= (rule || '(?=\&)');  //默认是数字
    var k= (k || 't') +'=';  //默认是"t"
    var v= (v || +new Date());  //默认是 时间戳
    var reg=new RegExp(rule);  
    if(url.indexOf(k)>-1){ 
        return url.replace(reg,k+v);
    }else{ 
        if(url.indexOf('\?')>-1){
            var urlArr=url.split('\?');
            if(urlArr[1]){
                return urlArr[0]+'?'+urlArr[1]+'&'+k+v;
            }else{
                return urlArr[0]+'?'+k+v;
            }
        }else{
            if(url.indexOf('#')>-1){
                return url.split('#')[0]+'?'+k+v;
            }else{
                return url+'?'+k+v;
            }
        }
    }
}

$(".previmg").click(function(){
    $(this).next(".upload").click();
});

function preview(e){
    c = $(e).attr("data-class");
    var preview = $(e).prev()[0];
    var file = $(e)[0].files[0];
    var reader = new FileReader();
    reader.onloadend = function () {
    preview.src = reader.result;
    }
    if (file) {
    reader.readAsDataURL(file);
    } else {
    preview.src = "";
    }
    uploadimg(c);
}
//上传图片
function uploadimg(id){
    $.ajaxFileUpload({
        url: 'plugin.php?id=vipcard:deal', //用于文件上传的服务器端请求地址
        type:'POST',
        secureuri: false, //是否需要安全协议，一般设置为false
        fileElementId: id, //文件上传域的ID
        data:{"fid":id,m:'uploadimg'},
        dataType: 'json', //返回值类型 一般设置为json
        success: function (data)  //服务器成功响应处理函数
        {
            $("."+id).val(data.url);
        },
        error: function (data, status, e)//服务器响应失败处理函数
        {
            console.log(data);
            console.log(status);
            console.log(e);
        }
    })
}   
$("#fmsub").click(function(event) {
type = $('.type').val();
hid = $('.hid').val();
name = $('.name').val();
logo = $('.logo').val();
phone = $('.phone').val();
address = $('.address').val();
od = $('.od').val();
editor.sync();
des = html_encode($('#des').val());

$.post(ajaxurl, {a:type,hid:hid,name:name,logo:logo,phone:phone,address:address,od:od,des:des}, function(data, textStatus, xhr) {
if(data.code=="1"){
$.toast("操作成功");
}else{
$.toast(data.msg, "forbidden");
}
},'json');
});

