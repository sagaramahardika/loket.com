$(document).ready(function () {

    if ( $('table#event').length > 0 ) {
        $('#event').DataTable({
            "processing": true,
            "serverSide": true,
            "ajax": {
                "url": config.routes.user.event,
                "dataType": "json",
                "type": "POST",
                "data": {
                    _token: config.token
                }
            },
            "columns": [
                { "data": "name" },
                { "data": "organizer" },
                { "data": "date_start" },
                { "data": "date_end" },
                { "data": "time_start" },
                { "data": "time_end" },
                { "data": "location_name" },
                { "data": "location_address" },
                { "data": "location_city" },
                { "data": "options" },
            ]
        });
    }

    if ( $('div#event').length > 0 ) {
        $('#date_start').datetimepicker({ format: 'MM/DD/YYYY' });
        $('#date_end').datetimepicker({ format: 'MM/DD/YYYY' });
        $('#time_start').datetimepicker({ format: 'HH:mm' });
        $('#time_end').datetimepicker({ format: 'HH:mm' });
    }

    if ( $('table#ticket').length > 0 ) {
        var id_event = $("#id_event").val();
        $('#ticket').DataTable({
            "processing": true,
            "serverSide": true,
            "ajax": {
                "url": config.routes.user.ticket,
                "dataType": "json",
                "type": "POST",
                "data": {
                    id_event: id_event,
                    _token: config.token
                }
            },
            "columns": [
                { "data": "name" },
                { "data": "description" },
                { "data": "price" },
                { "data": "quantity" },
                { "data": "options" },
            ]
        });
    }

});