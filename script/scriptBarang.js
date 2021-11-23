var cari = document.getElementById('cari');
var bungkus = document.getElementById('bungkus');

cari.addEventListener('keyup', function () {
    var ajax = new XMLHttpRequest();

    ajax.onreadystatechange = function () {
        if (ajax.readyState == 4 && ajax.status == 200) {
            bungkus.innerHTML = ajax.responseText;
        }
    }
    ajax.open('GET', 'search.php?keyword=' + cari.value, true);
    ajax.send();
});