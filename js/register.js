/**
 * Created by 84532 on 2017/8/17.
 */
window.onload = function () {
    var faceimg = document.getElementById('faceimg');
    faceimg.onclick = function () {
        window.open('face.php', 'face', 'width=600,height=400,top=0,left=0,scrollbar=1;')
    };

    //点击验证码局部刷新验证码
    code();

    //表单验证
    var fm = document.getElementsByTagName('form')[0];

    fm.onsubmit = function () {
        //能用客户端验证的尽量用客户端验证

        //用户名验证
        if (fm.username.value.length < 2 || fm.username.value.length > 20) {
            alert('用户名不能小于2位或者大于20位');
            fm.username.value = '';
            fm.username.focus();

            return false;
        }
        if (/[<>\'\"\ \ ]/.test(fm.username.value)) {
            alert('用户名不能包含非法字符');
            fm.username.value = '';
            fm.username.focus();

            return false;
        }

        //密码验证
        if (fm.password.value.length < 6 || fm.password.value.length > 20) {
            alert('密码不能小于6位或者大于20位');
            fm.password.value = '';
            fm.password.focus();
            return false;
        }
        if (fm.password.value !== fm.notpassword.value) {
            alert('密码确认不一致');
            fm.notpassword.value = '';
            fm.notpassword.focus();
            return false;
        }

        //密码提示与回答
        if (fm.question.value.length < 2 || fm.question.value.length > 20) {
            alert('密码提示不得小于2位不能大于20位');
            fm.question.value = '';
            fm.question.focus();
            return false;
        }

        if (fm.answer.value.length < 2 || fm.answer.value.length > 20) {
            alert('密码回答不得小于2位不能大于20位');
            fm.answer.value = '';
            fm.answer.focus();
            return false;
        }

        if (fm.question.value == fm.answer.value) {
            alert('密码提示与密码回答不能相等');
            fm.answer.value = '';
            fm.answer.focus();
            return false;
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

        //网址验证
        // if(fm.url.value !== ''){
        //     if (!(/^https?:\/\/(\w+\.)?[\w]+(\.\w+)+$/.test(fm.url.value))){
        //         alert('网址格式不正确');
        //         fm.url.value = "http://";
        //         fm.url.focus();
        //         return false;
        //     }
        // }


        if (fm.code.value.length !== 4) {
            alert('验证码必须是4位');
            fm.code.value = "";
            fm.code.focus();
        }


        return true;
    }


};