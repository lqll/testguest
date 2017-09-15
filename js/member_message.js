/**
 * Created by SEVEN on 2017/9/6.
 */

window.onload = function () {


    //批量删除
    var all = document.getElementById('all');
    var form = document.getElementsByTagName('form')[0];
    all.onclick = function () {
        for(var i= 0;i<form.elements.length ;i++){
            if (form.elements[i].checked !== 'chkall'){
                form.elements[i].checked = form.chkall.checked;
            }
        }
    };

    form.onsubmit = function () {
        if(confirm('确定要删除这批数据么')){
            return true;
        }else {
            return false;
        }
    }
};