// LET MEF FIX
// apirak.fw@gmail.com

function toDataURL(url, callback) {
    var xhr = new XMLHttpRequest();
    xhr.open('get', url);
    xhr.responseType = 'blob';
    xhr.onload = function () {
        var fr = new FileReader();

        fr.onload = function () {
            callback(this.result);
        };

        fr.readAsDataURL(xhr.response); // async call
    };

    xhr.send();
}

function base64ImageToBlob(str) {
    // extract content type and base64 payload from original string
    var pos = str.indexOf(';base64,');
    var type = str.substring(5, pos);
    var b64 = str.substr(pos + 8);
    // decode base64
    var imageContent = atob(b64);
    // create an ArrayBuffer and a view (as unsigned 8-bit)
    var buffer = new ArrayBuffer(imageContent.length);
    var view = new Uint8Array(buffer);
    // fill the view, using the decoded base64
    for (var n = 0; n < imageContent.length; n++) {
        view[n] = imageContent.charCodeAt(n);
    }
    // convert ArrayBuffer to Blob
    var blob = new Blob([buffer], { type: type });
    return blob;
}

function verifyCredit(slip_code, ref1, credit_id) {
    var imageBlob = base64ImageToBlob(slip_code);

    const html5QrCode = new Html5Qrcode("reader");
    const imageFile = imageBlob;

    html5QrCode.scanFile(imageFile, false)
        .then(qrCodeMessage => {
            tmwVerify(qrCodeMessage, ref1, credit_id);
        })
        .catch(err => {
            console.log(`Error scanning file. Reason: ${err}`)
        });
}

function tmwVerify(QRCode, ref1, credit_id) {
    const requestOptions = {
        method: "GET",
        redirect: "follow"
    };

    var params = new URLSearchParams({
        qrcode: QRCode,
        ref1: ref1,
    });

    url = "/frontend/web/verifyslip.php";

    url = url + "?" + params.toString();

    $.ajax({ "url": url, "method": "GET" }).done(function (response) {
        if (response.status == 1) {
            msg = "ผลการตรวจสอบสลิป: " + response.msg + "\nเวลา : " + response.slip_time;

            url_approve = "/credit/approve-credit";
            var params = new URLSearchParams({
                credit_id: credit_id,
                amount: response.amount
            });
            url_approve = url_approve + "?" + params.toString();
            $.ajax({ "url": url_approve, "method": "GET" }).done(function (status) {
                if (status == "ok") {
                    msg = msg + "\nทำรายการสำเร็จ";
                    alert(msg);
                    window.location = '/post-credit-transection/deposit';
                }
                else {
                    msg = msg + "\nทำรายการไม่สำเร็จ";
                    msg = msg + "\n" + status;
                    alert(msg);
                }
            });
        }
    });
}

function getUrlParams(key) {
    const urlParams = new URLSearchParams(window.location.search);
    return urlParams.get(key);
}


if ($(".post-credit-success").length > 0) {
    var myImage = document.getElementById("slipimage");
    var amount = document.getElementById("amount").textContent;

    var bankAccountNo = $("#bank_account_no").text().trim();
    var bankAccountName = $("#bank_account_name").text().trim();

    var credit_id = getUrlParams('id');

    var ref1 = bankAccountNo + ":" + credit_id;

    toDataURL(myImage.src, function (slip_code) {
        verifyCredit(slip_code, ref1, credit_id);
    });
}