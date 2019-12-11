import helpers from './helpers';
import axios from 'axios';

export default class Rooms {
    constructor() {
        this.$modalCreate = $('#room_modal_create');
        this.$formCreate = $('#room_form_create');
        this.$dataTable = $('#room_datatable');
        this.$modalEdit = $('#room_modal_edit');
        this.$formEdit = $('#room_form_edit');
        this.init();
    }

    init() {
        this.initDataTable();
        this.initCreate();
        this.initEdit();
        this.initDelete();
    }

    initDataTable() {
        let action = this.$dataTable.data('url');
        this.$dataTable.DataTable({
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
                    url: action,
                    headers:
                        {
                            'X-CSRF-TOKEN':
                                $('meta[name=csrf-token]').attr('content')
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
                    title: 'Name',
                    name: 'name',
                    data: 'name',
                    class: 'text-center'
                },
                {
                    title: 'Capacity',
                    name: 'capacity',
                    data: 'capacity',
                    class: 'text-center'
                },
                {
                    title: 'Action',
                    name: 'action',
                    data: 'action',
                    class: 'text-center'
                }
            ]
        })
    }

    initCreate() {
        this.$modalCreate.on('show.bs.modal', () => {
            this.$formCreate.find('.form-control').each((index, input) => {
                helpers.hideInputErrors($(input));
            });
        });
        this.$formCreate.submit(e => {
            e.preventDefault();
            let action = $(e.target).attr('action');
            axios.post(action, new FormData(e.target)).then(res => {
                if (res.data.message) {
                    helpers.showToast(res.data.message);
                    this.$modalCreate.modal('hide');
                    this.$dataTable.DataTable().ajax.reload();
                    setTimeout(() => location.reload(), 1000);
                }
            }).catch(err => {
                if (err.response.data.errors) {
                    helpers.showInputErrors(err.response.data.errors, 'room');
                }
                helpers.showToast(err.response.data.message, 'error');
            })
        })
    }

    initEdit() {
        this.$modalEdit.on('show.bs.modal', e => {
            this.$formEdit.find('.form-control').each((index, input) => {
                helpers.hideInputErrors($(input));
            });
            let btn = $(e.relatedTarget);
            this.$formEdit.find('select[name=channel_id]').val(btn.data('channel'));
            this.$formEdit.find('input[name=name]').val(btn.data('name'));
            this.$formEdit.find('input[name=capacity]').val(btn.data('capacity'));
            this.$formEdit.attr('action', btn.attr('href'));
        });
        this.$formEdit.submit(e => {
            e.preventDefault();
            let action = $(e.target).attr('action');
            axios.post(action, new FormData(e.target)).then(res => {
                if (res.data.message) {
                    helpers.showToast(res.data.message);
                    this.$modalEdit.modal('hide');
                    setTimeout(() => location.reload(), 1000);
                }
            }).catch(err => {
                if (err.response.data.errors) {
                    helpers.showInputErrors(err.response.data.errors, 'edit_room');
                }
                helpers.showToast(err.response.data.message, 'error');
            })
        });
    }

    initDelete() {
        $(document).on('click', '.room_delete', e => {
            e.preventDefault();
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
                    let action = $(e.target).attr('href');
                    axios.delete(action).then(res => {
                        swal({
                            title: 'Notification!',
                            text: res.data.message,
                            icon: 'success',
                            button: {
                                text: "Close",
                                value: true,
                                visible: true,
                                className: "btn btn-primary"
                            }
                        }).then(() => {
                            location.reload();
                        })
                    }).catch(err => {
                        helpers.showToast(err.response.data.message, 'error');
                    });
                }
            })
        })
    }
}
