import Helpers from "./helpers";
import Axios from 'axios';

class Notification {
    constructor() {
        this.$notifyDatatable = $('#notify_datatable');
        this.$maskAsRead = $('#mask-as-read');
        this.init();
    }

    init() {
        this.initTable();
        this.initMaskAsRead();
    }

    initTable() {
        this.$notifyDatatable.DataTable({
            dom: "<'row'" +
                "<'col-lg-6 col-12'l>" +
                "<'col-lg-6 col-12'f>" +
                ">" +
                "<'row'<'col-12'<'table-responsive't>>>" +
                "<'row'<'col-12 col-lg-6'i><'col-12 col-lg-6'p>>",
            serverSide: true,
            ajax:
                {
                    method: 'post',
                    url: this.$notifyDatatable.data('url'),
                    headers:
                        {
                            'X-CSRF-TOKEN': $('meta[name=csrf-token]').attr('content')
                        }
                }
            ,
            pageLength: 100,
            columns: [
                {
                    title: '#',
                    name: 'DT_RowIndex',
                    data: 'DT_RowIndex',
                    class: 'text-center py-1',
                    orderable: false,
                    searchable: false
                },
                {
                    title: 'Status',
                    name: 'status',
                    data: 'status',
                    class: 'text-center'
                },
                {
                    title: 'Content',
                    name: 'content',
                    data: 'content',
                    class: 'text-center'
                },
                {
                    title: 'Time',
                    name: 'time',
                    data: 'time',
                    class: 'text-center'
                },
                {
                    title: 'Read at',
                    name: 'read_at',
                    data: 'read_at',
                    class: 'text-center'
                },
            ]
        });
    }

    initMaskAsRead() {
        this.$maskAsRead.click(event => {
            event.preventDefault();
            let url = $(event.target).data('url');
            Axios.post(url).then(
                res => {
                    if (res.data && res.data.message) {
                        Helpers.showToast(res.data.message);
                        setTimeout(()=>{
                            window.location.reload();
                        },1000)
                    }
                },
                err => {
                    Helpers.showToast(err.response.data.message, 'error');
                }
            )
        });
    }
}

$(() => {
    new Notification();
});
