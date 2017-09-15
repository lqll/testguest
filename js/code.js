/**
 * Created by 84532 on 2017/8/30.
 */
function code() {
    var code = document.getElementById('code');
    code.onclick = function () {
        this.src = 'code.php?tm=' + Math.random()
    };
}