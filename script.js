window.addEventListener('load', () => {
    var languages = document.querySelectorAll('#wp-admin-bar-salc-current-language .ab-submenu a');
    languages.forEach(function (item) {
        item.addEventListener('click', salc_change_admin_language);
    });
});

function salc_change_admin_language(e) {

    e.preventDefault;
    var language = this.getAttribute("href").substring(1);
    var request = new XMLHttpRequest();

    request.open('POST', props.ajax_url, true);
    request.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded;');

    request.onload = function () {
        if (this.status >= 200 && this.status < 400) {
            var response = JSON.parse(this.response);

            if (response.success) {
                location.reload();
            }
        } else {
            console.log(this.response);
        }
    };

    request.send('action=change_user_locale&nonce=' + props.nonce + '&lang=' + language);

    return false;
}
