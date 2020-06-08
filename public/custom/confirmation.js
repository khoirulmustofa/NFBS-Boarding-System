$(document).ready(function () {

    /**
     * Modal confirmation untuk link.
     */
    $('a[data-confirm]').click(function() {
        var href = $(this).attr('href');
        if (!$('#dataConfirmModal').length) {
            $('body').append(
                '<div class="modal fade" id="dataConfirmModal" data-backdrop="static" data-keyboard="false" tabindex="-1" role="dialog" aria-labelledby="dataConfirmLabel" aria-hidden="true">' +
                    '<div class="modal-dialog">' +
                        '<div class="modal-content">' +
                        '<div class="modal-header">' +
                        	'<h5 class="modal-title" id="exampleModalLabel">Konfirmasi</h5>' +
                        	'<button type="button" class="close" data-dismiss="modal" aria-label="Close">' +
                          '<span aria-hidden="true">&times;</span>' +
                          '</button>' +
                          '</div>' +

                            '<div class="modal-body"></div>' +

                            '<div class="modal-footer">' +
                                '<button type="button" class="btn btn-danger pull-left" data-dismiss="modal">Tidak</button>' +
                                '<a class="btn btn-success" id="dataConfirmOK">Ya</a>' +
                            '</div>' +
                        '</div>' +
                    '</div>' +
                '</div>'
            );
        }
        $('#dataConfirmModal').find('.modal-body').text($(this).attr('data-confirm'));
        $('#dataConfirmOK').attr('href', href);
        $('#dataConfirmModal').modal({show: true});
        return false;
    });

    /**
     * Modal confirmation untuk form submit.
     */
     $('button[data-confirm]').click(function() {
        if (!$('#dataConfirmModal').length) {
            $('body').append(
                '<div class="modal fade" id="dataConfirmModal" data-backdrop="static" data-keyboard="false" tabindex="-1" role="dialog" aria-labelledby="dataConfirmLabel" aria-hidden="true">' +
                    '<div class="modal-dialog">' +
                        '<div class="modal-content">' +
                        '<div class="modal-header">' +
                    	'<h5 class="modal-title" id="exampleModalLabel">Konfirmasi</h5>' +
                    	'<button type="button" class="close" data-dismiss="modal" aria-label="Close">' +
                      '<span aria-hidden="true">&times;</span>' +
                      '</button>' +
                      '</div>' +

                            '<div class="modal-body"></div>' +

                            '<div class="modal-footer">' +
                                '<button type="button" class="btn btn-danger pull-left" data-dismiss="modal">Tidak</button>' +
                                '<button type="submit" class="btn btn-success" id="dataConfirmOK">Ya</button>' +
                            '</div>' +
                        '</div>' +
                    '</div>' +
                '</div>'
            );
        }
        $('#dataConfirmModal').find('.modal-body').text($(this).attr('data-confirm'));
        $('#dataConfirmModal').modal({show: true});

        // Jika tombol submit di-klik.
        $("#dataConfirmOK").click(function () {
            $("#myform").submit();
        });
        return false;
    });    

});