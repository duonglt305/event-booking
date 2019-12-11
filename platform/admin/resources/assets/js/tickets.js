import helpers from './helpers';
import axios from 'axios';

export default class Tickets {
    constructor() {
        this.$delete = $('.ticket_delete');
        this.init();
    }

    init() {
        this.initDelete();
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
                confirmButtonText: 'Great ',
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
                        helpers.showToast(err.response.data.message, 'error');
                    });
                }
            })
        })
    }
}
