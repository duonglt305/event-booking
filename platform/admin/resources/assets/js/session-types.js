import Helpers from "./helpers";
import Axios from 'axios';

class SessionTypes {
    constructor() {
        //table
        this.$dataTableBuilder = $('#dataTableBuilder');
        this.$tableCheckAll = $('input[id=table-check-all]');
        this.$sessionTypeBulkDelete = $('#session_type_bulk_delete');
        this.$modelUpdateSessionType = $('#model_update_session_type');
        this.$modelCreateSessionType = $('#model_create_session_type');
        // session type update form
        this.$sessionTypeFormUpdate = $('#session_type_form_update');
        this.$sessionTypeName = $('#session_type_name');
        this.$sessionTypeCost = $('#session_type_cost');
        this.currentUpdateTarget = null;

        // session type create form
        this.$sessionTypeFormCreate = $('#session_type_form_create');
        this.$name = $('#name');
        this.$cost = $('#cost');


        // bulk change name
        this.$modelBulkChangeName = $('#model_bulk_change_name');
        this.$formBulkChangeName = $('#form_bulk_change_name');
        this.$bulkChangeName = $('#bulk_change_name');

        // bulk change cost
        this.$modelBulkChangeCost = $('#model_bulk_change_cost');
        this.$formBulkChangeCost = $('#form_bulk_change_cost');
        this.$bulkChangeCostInput = $('#bulk_change_cost');

        this.init();
    }

    init() {
        this.initSessionTypeUpdate();
        this.initSessionTypeCreate();
        this.initSessionTypeDelete();
        this.initBulkChangeName();
        this.initBulkChangeCost();
        this.initBulkDelete();
    }

    initSessionTypeUpdate() {
        this.$modelUpdateSessionType.on('show.bs.modal', event => {
            let url = $(event.relatedTarget).attr('href');
            Axios.get(url).then(
                res => {
                    let data = res.data;
                    this.currentUpdateTarget = data;
                    this.$sessionTypeName.val(data.name);
                    if (data.cost)
                        this.$sessionTypeCost.val(parseInt(data.cost));
                },
                err => {
                    Helpers.showToast(err.response.data.message, 'error');
                }
            );
        }).on('hide.bs.modal', even => {
            this.$sessionTypeCost.val('');
            this.$sessionTypeName.val('');
            Helpers.hideInputErrors(this.$sessionTypeName);
        });

        this.$sessionTypeFormUpdate.submit(event => {
            event.preventDefault();
            let url = $(event.target).attr('action');
            url = url.slice(0, url.lastIndexOf('/') + 1) + this.currentUpdateTarget.id;

            Axios.patch(url, {
                session_type_name: this.$sessionTypeName.val(),
                session_type_cost: this.$sessionTypeCost.val()
            }).then(
                res => {
                    if (res.data.message) {
                        Helpers.showToast(res.data.message);
                        this.$modelUpdateSessionType.modal('hide');
                        this.$dataTableBuilder.DataTable().ajax.reload();
                    }
                },
                err => {
                    if (err.response.data.errors) {
                        Helpers.showInputErrors(err.response.data.errors);
                    }
                    Helpers.showToast(err.response.data.message, 'error');
                }
            )
        })
    }

    initSessionTypeCreate() {
        this.$modelCreateSessionType.on('hide.bs.modal', () => {
            this.$name.val('');
            this.$cost.val('');
        });
        this.$sessionTypeFormCreate.submit(event => {
            event.preventDefault();
            let url = $(event.target).attr('action');

            Axios.post(url, new FormData(event.target))
                .then(
                    res => {
                        if (res.data.message) {
                            Helpers.showToast(res.data.message);
                            this.$dataTableBuilder.DataTable().ajax.reload();
                            this.$modelCreateSessionType.modal('hide');
                        }
                    },
                    err => {
                        if (err.response.data.errors) {
                            Helpers.showInputErrors(err.response.data.errors);
                        }
                        Helpers.showToast(err.response.data.message, 'error');
                    }
                )
        })
    }

    initSessionTypeDelete() {
        $(document).on('click', '.session_type_delete', event => {
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
                    Axios.delete(url)
                        .then(
                            res => {
                                if (res.data.message) {
                                    Helpers.showToast(res.data.message);
                                    this.$dataTableBuilder.DataTable().ajax.reload();
                                }
                            },
                            err => {
                                Helpers.showToast(err.response.data.message, 'error');
                            }
                        )
                }
            })
        })
    }

    initBulkChangeName() {
        this.$modelBulkChangeName.on('hide.show.model', () => {
            this.$bulkChangeName.val('');
            Helpers.hideInputErrors(this.$bulkChangeName)
        });

        this.$formBulkChangeName.submit(event => {
            event.preventDefault();
            let url = $(event.target).attr('action');

            let ids = $('input[name=checkbox-multi-action]:checked').toArray().map(el => {
                return $(el).val();
            });

            let fd = new FormData(event.target);
            fd.append('ids', JSON.stringify(ids));

            Axios.post(url, fd)
                .then(
                    res => {
                        if (res.data.message) {
                            Helpers.showToast(res.data.message);
                            this.$modelBulkChangeName.modal('hide');
                            this.$dataTableBuilder.DataTable().ajax.reload();
                        }
                    },
                    err => {
                        if (err.response.data.errors) {
                            Helpers.showInputErrors(err.response.data.errors);
                        }
                        Helpers.showToast(err.response.data.message, 'error');
                    }
                );
        });
    }

    initBulkChangeCost() {
        this.$modelBulkChangeCost.on('hide.show.model', () => {
            this.$bulkChangeCostInput.val('');
            Helpers.hideInputErrors(this.$bulkChangeCostInput);
        });
        this.$formBulkChangeCost.submit(event => {
            event.preventDefault();
            let url = $(event.target).attr('action');

            let ids = $('input[name=checkbox-multi-action]:checked').toArray().map(el => {
                return $(el).val();
            });

            let fd = new FormData(event.target);
            fd.append('ids', JSON.stringify(ids));

            Axios.post(url, fd)
                .then(
                    res => {
                        if(res.data.message){
                            Helpers.showToast(res.data.message);
                            this.$modelBulkChangeCost.modal('hide');
                            this.$dataTableBuilder.DataTable().ajax.reload();
                        }
                    },
                    err => {
                        if (err.response.data.errors) {
                            Helpers.showInputErrors(err.response.data.errors);
                        }
                        Helpers.showToast(err.response.data.message, 'error');
                    }
                );
        });
    }

    initBulkDelete() {
        this.$sessionTypeBulkDelete.click(event => {
            event.preventDefault();
            let $checkboxMultiAction = $('input[name=checkbox-multi-action]:checked');

            if ($checkboxMultiAction.length === 0 && (this.$tableCheckAll.prop('checked') || !this.$tableCheckAll.prop('checked'))) return false;
            else {
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
                        let checkboxMultiAction = $('input[name=checkbox-multi-action]:checked').toArray();

                        checkboxMultiAction = checkboxMultiAction.map(el => {
                            return $(el).val();
                        });

                        Axios.delete(url + '?ids=' + JSON.stringify(checkboxMultiAction)).then(
                            res => {
                                if(res.data.message){
                                    Helpers.showToast(res.data.message);
                                    this.$dataTableBuilder.DataTable().ajax.reload();
                                }
                            },
                            err => {
                                Helpers.showToast(err.response.data.message, 'error')
                            }
                        )
                    }
                });
            }
        })
    }

}

$(() => {
    new SessionTypes();
});
