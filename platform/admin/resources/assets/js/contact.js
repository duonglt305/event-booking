import Axios from "axios";
import Helpers from "./helpers";

class Contact {
    constructor() {
        this.$contactDatatable = $('#contact_datatable');
        this.$maskAsReadAll = $('#mask-as-read-all');
        this.init();
    }

    init() {
        this.initTable();
        this.initMaskAsRead();
    }

    initTable() {
        this.$contactDatatable.DataTable({
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
                    url: this.$contactDatatable.data('url'),
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
                    title: 'Sender',
                    name: 'sender',
                    data: 'sender',
                    class: 'text-center'
                },
                {
                    title: 'Message',
                    name: 'message',
                    data: 'message',
                    class: 'text-center'
                },
                {
                    title: 'Status',
                    name: 'status',
                    data: 'status',
                    class: 'text-center'
                },
                {
                    title: 'Time',
                    name: 'time',
                    data: 'time',
                    class: 'text-center'
                },
                {
                    title: 'Action',
                    name: 'action',
                    data: 'action',
                    class: 'text-center'
                },
            ]
        });
    }

    initMaskAsRead() {
        $(document).on('click', '.mask-as-read', event => {
            event.preventDefault();
            let id = $(event.target).data('id');
            let url = $(event.target).attr('href');
            Axios.post(url, {id}).then(
                res => {
                    if (res.data && res.data.message) {
                        Helpers.showToast(res.data.message);
                    }
                    this.$contactDatatable.DataTable().ajax.reload();
                },
                err => {
                    Helpers.showToast(err.response.data.message, 'error');
                })
        });

        this.$maskAsReadAll.click(event=>{
            let url = $(event.target).data('url');
            Axios.post(url).then(
                res=>{
                    if (res.data && res.data.message) {
                        Helpers.showToast(res.data.message);
                    }
                    this.$contactDatatable.DataTable().ajax.reload();
                },
                err => {
                    Helpers.showToast(err.response.data.message, 'error');
                }
            )
        });
    }

}

$(() => {
    new Contact();
});
