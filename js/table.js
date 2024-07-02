$(document).ready( function () {
    $('#myTable').DataTable();
} );

var table = new DataTable('#myTable', {
    language: {
        url: '//cdn.datatables.net/plug-ins/2.0.8/i18n/pt-BR.json',
    },
});