/**
 * Created by 84532 on 2017/8/17.
 */
window.onload = function () {
    var faceimg = document.getElementsByTagName('img');

    for(i = 0;i<faceimg.length;i++){
        faceimg[i].onclick = function () {
            _opener(this.alt);
        }
    }
};

function _opener(alt) {
    var face_img = opener.document.getElementById('faceimg');
    face_img.src = alt;
    opener.document.register.face.value = alt;
}
