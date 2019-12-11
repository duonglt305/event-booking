import Helpers from './helpers';
import axios from 'axios';

export default class Channels {
    constructor() {
        this.$modalCreate = $('#channel_modal_create');
        this.$formCreate = $('#channel_form_create');
        this.$modalEdit = $('#channel_modal_edit');
        this.$formEdit = $('#channel_form_edit');
        this.$delete = $('.channel_delete');
        this.init();
    }


    init() {
        this.initCreate();
        this.initEdit();
        this.initDelete();
    }

    initCreate() {
        this.$modalCreate.on('show.bs.modal', (e) => {
            this.$formCreate.find('.form-control').each((index, input) => {
                Helpers.hideInputErrors($(input));
            });
        });
        this.$formCreate.submit(e => {
            e.preventDefault();
            let action = $(e.target).attr('action');
            axios.post(action, new FormData(e.target)).then(res => {
                Helpers.showToast(res.data.message);
                this.$modalCreate.modal('hide');
                setTimeout(() => location.reload(), 2000);
            }).catch(err => {
                if (err.response.status === 422) {
                    Helpers.showInputErrors(err.response.data.errors, 'channel');
                }
            });
        });
    }

    initEdit() {
        this.$modalEdit.on('show.bs.modal', e => {
            this.$formEdit.find('.form-control').each((index, input) => {
                Helpers.hideInputErrors($(input));
            });
            let btn = $(e.relatedTarget);
            let action = btn.attr('href');
            this.$formEdit.attr('action', action);
            this.$formEdit.find('input[name=name]').val(btn.data('name'));
        });
        this.$formEdit.submit(e => {
            e.preventDefault();
            let action = $(e.target).attr('action');
            axios.post(action, new FormData(e.target)).then(res => {
                Helpers.showToast(res.data.message);
                this.$modalEdit.modal('hide');
                setTimeout(() => location.reload(), 2000);
            }).catch(err => {
                if (err.response.status === 422) {
                    Helpers.showInputErrors(err.response.data.errors, 'edit_channel');
                }
                Helpers.showToast(err.response.data.message, 'error');
            })
        })
    }


    initDelete() {
        this.$delete.click(e => {
            e.preventDefault();
            swal({
                title: 'Are you sure?',
                text: "You won't be able to revert this!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3f51b5',
                cancelButtonColor: '#ff4081',
                buttons: {
                    confirm: {
                        text: "OK",
                        value: true,
                        visible: true,
                        className: "btn btn-primary",
                        closeModal: true
                    },
                    cancel: {
                        text: "Cancel",
                        value: null,
                        visible: true,
                        className: "btn btn-danger",
                        closeModal: true,
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
                        Helpers.showToast(err.response.data.message, 'error');
                    });
                }
            })
        })
    }
}
