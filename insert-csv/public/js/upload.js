$(document).ready(function(){
    let chunk_size = 1024 * 1024; // 1Mo par 1Mo
    let reader = new FileReader();

    let toast = $('#toast');

    $('#insertForm').submit(function(e) {
        e.preventDefault();

        let fileInput = document
            .getElementById('file')
            .files[0];

        $('#progress-div').removeClass('d-none');

        truncateDbThenUploadFile(fileInput);
    });

    function truncateDbThenUploadFile(fileInput) {
        jQuery.post('/appel/ajaxTruncateDb', {}).done(function() {
            uploadFile(fileInput);
        }).fail(function () {
            replaceToastContentError();
            displayToast();
        });
    }

    function uploadFile(fileInput) {
        _uploadChunk(fileInput, 0, chunk_size);
    }

    function advanceProgressBar(newPercentage) {
        $('#progress-div .progress-bar').attr('aria-valuenow', newPercentage);
        $('#progress-div .progress-bar').attr('style', 'width: '+ newPercentage + '%');
        $('#progress-div .progress-bar').html(newPercentage + '%');
    }

    function replaceToastContentError() {
        $("#toast .toast-body").html('Erreur interne.')
        toast.removeClass('bg-primary').addClass('bg-danger');
    }

    function displayToast() {
        window.setTimeout(function(){
            $('#progress-div').addClass('d-none');
            $('#liveToast').removeClass('hide');
            toast.toast('show');
        }, 1000);
    }

    function reloadPageAfterXMillisecond(millisecond) {
        window.setTimeout(function(){
            document.location.reload();
        }, millisecond);
    }

    function _uploadChunk(file, offset, range) {
        if(offset >= file.size) {
            jQuery.post('/appel/ajaxUploadFileChunk', {
                filename: file.name,
                eof: true
            }).done(function(success) {
                advanceProgressBar('100');
                displayToast();
            }).fail(function () {
                replaceToastContentError();
                displayToast();
            });
            reloadPageAfterXMillisecond(3000);
            return;
        }

        reader.addEventListener('load', function(e) {
            let filename = file.name;
            let index = offset / chunk_size;
            let data = e.target.result.split(';base64,')[1];
            let numberOfBounds = file.size / chunk_size;
            let percentageByBound = Math.round(100 / numberOfBounds);
            let payload = {
                filename: filename,
                index: index,
                data: data,
                submit: 'submit'
            };

            jQuery.post('/appel/ajaxUploadFileChunk',
                payload,
                function() {
                    _uploadChunk(file, offset + range, chunk_size);
                }
            ).done(function(success) {
                if (index !== Math.round(numberOfBounds)) {
                    let newPercentage = parseInt($('#progress-div .progress-bar').attr('aria-valuenow')) + parseInt(percentageByBound);
                    advanceProgressBar(newPercentage);
                }
            }).fail(function () {
                replaceToastContentError();
                displayToast();
                reloadPageAfterXMillisecond(3000);
            });
        }, {once: true} );

        let chunk = file.slice(offset, offset + range);
        reader.readAsDataURL(chunk);
    }
});