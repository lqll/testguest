/**
 * Created by 84532 on 2017/9/5.
 */
window.onload = function () {
    var ret = document.getElementById('return');
    var del = document.getElementById('delete');
    ret.onclick = function (){
        history.back();
    };

    del.onclick = function () {
        if(confirm('你确定要删除这条信息么')){
            location.href = '?action=deltet&id='+this.name;
        }


    }

};