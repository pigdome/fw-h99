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

function verifySlip(imageBase64, ref1, amount) {
    var imageBlob = base64ImageToBlob(imageBase64);

    const html5QrCode = new Html5Qrcode("reader");
    const imageFile = imageBlob;

    html5QrCode.scanFile(imageFile, false)
        .then(qrCodeMessage => {
            tmwVerify(qrCodeMessage, ref1, amount);
        })
        .catch(err => {
            console.log(`Error scanning file. Reason: ${err}`)
        });
}

function tmwVerify(QRCode, ref1, amount) {
    const requestOptions = {
        method: "GET",
        redirect: "follow"
    };

    var params = new URLSearchParams({
        qrcode: QRCode,
        ref1: ref1,
        amount: amount
    });

    url = "/frontend/web/verifyslip.php";

    url = url + "?" + params.toString();

    $.ajax({ "url": url, "method": "GET" }).done(function (response) {
        if (response.status == 1) {
            msg = "ผลการตรวจสอบสลิป: " + response.msg + "\nเวลา : " + response.slip_time;
            alert(msg);
        }
    });
}


if ($(".post-credit-success").length > 0) {
    var myImage = document.getElementById("slipimage");
    var amount = document.getElementById("amount").textContent;

    var bankAccountNo = $("#bank_account_no").text().trim();
    var bankAccountName = $("#bank_account_name").text().trim();

    var ref1 = bankAccountNo + ":" + amount;

    toDataURL(myImage.src, function (dataURL) {
        console.log(dataURL);
        console.log(myImage.naturalWidth);
        console.log(myImage.naturalHeight);

        verifySlip(dataURL, ref1, amount);
    });
}