window.emojioneVersion = "3.4.2";
function search(a){
    if(a == 1){
        document.getElementById('searchForm').style.display='block';
        document.getElementById('srch').addEventListener('keypress',myscript);
        document.getElementById('srch').addEventListener('keyup',myscript);


    }
    if(a == 2){
        document.getElementById('searchForm').style.display='none';
        document.getElementById('searchResponse').style.display='none';
    }  
}

function myscript(){
    console.log('ooo..');

    var request=new XMLHttpRequest();
    request.onreadystatechange=function(){
        if(this.readyState==4 & this.status==200){
            if(request.response.length >0){
                document.getElementById('ldg').innerHTML="";
                document.getElementById('searchResponse').style.display='block';
                document.getElementById('searchResponse').innerHTML=request.response;
            }else{
                document.getElementById('ldg').innerHTML='<img src="http://localhost:81/cocktailAPP/public/images/35.gif" id="loading">';
                document.getElementById('searchResponse').style.display='none';
            }
      
        }
    };
    var s=document.getElementById('srch').value;
    var url="http://localhost:81/cocktailAPP/public/search";
    var send="string="+s;
    token = document.querySelector('meta[name="csrf-token"]').content;
   request.open("POST",url,true);
   request.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
    request.setRequestHeader('X-CSRF-TOKEN', token);
   request.send(send);
}