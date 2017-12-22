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