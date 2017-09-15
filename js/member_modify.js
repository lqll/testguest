/**
 * Created by SEVEN on 2017/9/3.
 */
window.onload = function () {
    code();
    var fm = document.getElementsByTagName('form')[0];
    fm.onsubmit = function () {

        //密码验证
        if(fm.password.value !== ''){
            if (fm.password.value.length < 6 || fm.password.value.length > 20) {
                alert('密码不能小于6位或者大于20位');
                fm.password.value = '';
                fm.password.focus();
                return false;
            }
        }

        //邮箱验证

        if (!(/^[\w\-\.]+@[\w\-\.]+(\.\w+)+$/.test(fm.email.value))) {
            alert('邮件格式不正确');
            fm.email.value = "";
            fm.email.focus();
            return false;
        }


        //qq验证
        if (fm.qq.value !== '') {
            if (!(/^[1-9]{1}[0-9]{4,9}$/.test(fm.qq.value))) {
                alert('qq格式不正确');
                fm.qq.value = "";
                fm.qq.focus();
                return false;
            }
        }


        if (fm.code.value.length !== 4) {
            alert('验证码必须是4位');
            fm.code.value = "";
            fm.code.focus();
        }

        return true;

    }
};