/**
 * Created by 84532 on 2017/8/30.
 */
window.onload = function () {
    code();

    var fm = document.getElementsByTagName('form')[0];

    //登录验证
    fm.onsubmit = function () {
        //能用客户端验证的尽量用客户端验证

        //用户名验证
        if(fm.username.value.length < 2 || fm.username.value.length > 20){
            alert('用户名不能小于2位或者大于20位');
            fm.username.value = '';
            fm.username.focus();

            return false;
        }
        if(/[<>\'\"\ \   ]/.test(fm.username.value)){
            alert('用户名不能包含非法字符');
            fm.username.value = '';
            fm.username.focus();

            return false;
        }

        //密码验证
        if(fm.password.value.length < 6 || fm.password.value.length > 20){
            alert('密码不能小于6位或者大于20位');
            fm.password.value = '';
            fm.password.focus();
            return false;
        }


        if (fm.code.value.length !== 4){
            alert('验证码必须是4位');
            fm.code.value = "";
            fm.code.focus();
        }


        return true;
    }


};