
function detail_persetujuan(id, buku_tanah) {
    $.ajax({
        type :'GET',
        url  : base_domain + '/json/notif/get/'+ id,
        success: function (data) {
            if(data.status) {
                $('#modal-persetujuan').modal('show');
                $('#data_persetujuan').html(data['table']);
                $('#pesan_persetujuan').html(data['pesan']);
   				$('#data_button').html('<button type="button" class="btn btn-default pull-left" data-dismiss="modal">Tidak</button><a href="#" onclick="setuju('+buku_tanah+')" data-id="'+id+'" class="btn btn-primary">Terima</a>');
            } else {

            }
        }
    });
	return false;
}

function setuju(id) {
    $.ajax({
        type :'GET',
        url  : base_domain + '/json/notif/setujui/'+ id,
        success: function (data) {
	        window.location = current_url;
        }
    });
	return false;
}