import Helpers from "./helpers";
import Axios from 'axios';

export default class Article {
    constructor() {
        this.$articleDatatable = $('#article_datatable');
        this.init();
    }

    init() {
        this.initTable();
        this.initUpdateStatus();
        this.initDelete();
        this.initSetFeature();
    }

    initTable() {
        this.$articleDatatable.DataTable({
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
                    url: this.$articleDatatable.data('url'),
                    headers:
                        {
                            'X-CSRF-TOKEN': $('meta[name=csrf-token]').attr('content')
                        }
                }
            ,
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
                    title: 'Title',
                    name: 'title',
                    data: 'title',
                    class: 'text-left'
                },
                {
                    title: 'Feature',
                    name: 'feature',
                    data: 'feature',
                    class: 'text-center'
                },
                {
                    title: 'Status',
                    name: 'status',
                    data: 'status',
                    class: 'text-center'
                },
                {
                    title: 'Thumbnail',
                    name: 'thumbnail',
                    data: 'thumbnail',
                    class: 'text-center'
                },
                {
                    title: 'Actions',
                    name: 'actions',
                    data: 'actions',
                    class: 'text-center'
                }
            ]
        });
    }

    initUpdateStatus() {
        $(document).on('click', '.update_status', event => {
            event.preventDefault();
            let url = $(event.target).attr('href');
            Axios.patch(url).then(
                res => {
                    if (res.data && res.data.message) {
                        Helpers.showToast(res.data.message);
                    }
                    this.$articleDatatable.DataTable().ajax.reload();
                },
                err => {
                    Helpers.showToast(err.response.data.message, 'error')
                }
            )
        })
    }

    initDelete() {
        $(document).on('click', '.article_delete', event => {
            event.preventDefault();
            swal({
                title: 'Are you sure?',
                text: "You won't be able to revert this!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3f51b5',
                cancelButtonColor: '#ff4081',
                confirmButtonText: 'Great ',
                buttons: {
                    cancel: {
                        text: "Cancel",
                        value: null,
                        visible: true,
                        className: "btn btn-danger",
                        closeModal: true,
                    },
                    confirm: {
                        text: "OK",
                        value: true,
                        visible: true,
                        className: "btn btn-primary",
                        closeModal: true
                    }
                }
            }).then(isConfirm => {
                if (isConfirm) {
                    let url = $(event.target).attr('href');
                    Axios.delete(url).then(
                        res => {
                            if (res.data && res.data.message)
                                Helpers.showToast(res.data.message);
                            this.$articleDatatable.DataTable().ajax.reload();
                        },
                        err => {
                            Helpers.showToast(err.response.data.message, 'error')
                        }
                    )
                }
            })
        })
    }

    initSetFeature() {
        $(document).on('click', '.set-feature', event => {
            event.preventDefault();
            let url = $(event.currentTarget).attr('href');
            Axios.post(url, {id: $(event.currentTarget).data('id')})
                .then(
                    res => {
                        if (res.data && res.data.message) {
                            Helpers.showToast(res.data.message);
                        }
                        this.$articleDatatable.DataTable().ajax.reload();
                    },
                    err => {
                        Helpers.showToast(err.response.data.message, 'error')
                    }
                )
        })
    }
}
