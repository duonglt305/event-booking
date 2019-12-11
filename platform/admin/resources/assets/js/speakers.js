import Helpers from "./helpers";
import Axios from 'axios';

class Speakers {
    constructor() {
        this.$dataTableBuilder = $('#dataTableBuilder');
        this.$speakerBulkDelete = $('#speaker_bulk_delete');
        this.$tableCheckAll = $('#table-check-all');
        //create speaker
        this.$modelCreateSpeaker = $('#model_create_speaker');
        this.$speakerFormCreate = $('#speaker_form_create');
        this.$firstname = $('#firstname');
        this.$lastname = $('#lastname');
        this.$company = $('#company');
        this.$position = $('#position');
        this.$photo = $('#photo');
        this.$description = $('#description');


        //update speaker
        this.$modelUpdateSpeaker = $('#model_update_speaker');
        this.$speakerFormUpdate = $('#speaker_form_update');
        this.$updateFirstname = $('#update_firstname');
        this.$updateLastname = $('#update_lastname');
        this.$updateCompany = $('#update_company');
        this.$updatePosition = $('#update_position');
        this.$updatePhoto = $('#update_photo');
        this.$updateDescription = $('#update_description');
        this.currentUpdateTarget = null;

        // bulk change company
        this.$modelBulkChangesCompany = $('#model_bulk_changes_company');
        this.$formBulkChangesCompany = $('#form_bulk_changes_company');
        this.$bulkChangesCompanyInput = $('#bulk_changes_company');

        // bulk change position
        this.$modelBulkChangesPosition = $('#model_bulk_changes_position');
        this.$formBulkChangesPosition = $('#form_bulk_changes_position');
        this.$bulkChangesPositionInput = $('#bulk_changes_position');

        // bulk change description
        this.$modelBulkChangesDescription = $('#model_bulk_changes_description');
        this.$formBulkChangesDescription = $('#form_bulk_changes_description');
        this.$bulkChangesDescriptionInput = $('#bulk_changes_description');

        this.init();
    }

    init() {
        this.initCreateSpeaker();
        this.initUpdateSpeaker();
        this.initDeleteSpeaker();
        this.initBulkDelete();
        this.initBulkChangesCompany();
        this.initBulkChangesPosition();
        this.initBulkChangeDescription();
    }

    initCreateSpeaker() {
        this.$modelCreateSpeaker.on('hide.bs.modal', () => {
            this.resetCreateFrom();
        });
        this.$photo.dropify();

        this.$speakerFormCreate.submit(event => {
            event.preventDefault();
            let url = $(event.target).attr('action');
            Axios.post(url, new FormData(event.target))
                .then(
                    res => {
                        Helpers.showToast(res.data.message);
                        this.$modelCreateSpeaker.modal('hide');
                        this.$dataTableBuilder.DataTable().ajax.reload();
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

    initUpdateSpeaker() {
        let updatePhotoDropify = this.$updatePhoto.dropify();
        updatePhotoDropify = updatePhotoDropify.data('dropify');

        this.$modelUpdateSpeaker.on('show.bs.modal', event => {
            let url = $(event.relatedTarget).attr('href');
            Axios.get(url).then(
                ({data}) => {
                    this.currentUpdateTarget = data;
                    this.setupUpdateFrom(data, updatePhotoDropify)
                },
                err => {
                    Helpers.showToast(err.response.data.message, 'error')
                }
            )
        }).on('hide.bs.modal', () => {
            this.resetUpdateForm();
        });

        this.$speakerFormUpdate.submit(event => {
            event.preventDefault();

            if(!this.currentUpdateTarget) return false;

            let url = $(event.target).attr('action');
            url = url.slice(0, url.lastIndexOf('/') + 1) + this.currentUpdateTarget.id;

            let fd = new FormData(event.target);

            Axios.post(url, fd).then(
                res => {
                    Helpers.showToast(res.data.message);
                    this.$modelUpdateSpeaker.modal('hide');
                    this.$dataTableBuilder.DataTable().ajax.reload();
                },
                err => {
                    if (err.response.data.errors) {
                        Helpers.showInputErrors(err.response.data.errors);
                    }
                    Helpers.showToast(err.response.data.message, 'error');
                }
            )
        });
    }

    initDeleteSpeaker() {
        $(document).on('click', '.speaker_delete', event => {
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
                            Helpers.showToast(res.data.message);
                            this.$dataTableBuilder.DataTable().ajax.reload();
                        },
                        err => {
                            Helpers.showToast(err.response.data.message, 'error')
                        }
                    )

                }
            })
        })
    }

    initBulkDelete() {
        this.$speakerBulkDelete.click(event => {
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
                        let ids = $checkboxMultiAction.toArray().map(item => {
                            return $(item).val();
                        });
                        let url = this.$speakerBulkDelete.data('url');
                        Axios.delete(url + '?ids=' + JSON.stringify(ids)).then(
                            res => {
                                if (res.data && res.data.message)
                                    Helpers.showToast(res.data.message);
                                this.$dataTableBuilder.DataTable().ajax.reload();
                            },
                            err => {
                                Helpers.showToast(err.response.data.message, 'error')
                            }
                        )
                    }
                })
            }
        })
    }

    initBulkChangesCompany() {
        this.$modelBulkChangesCompany.on('hide.bs.modal', event => {
            this.$bulkChangesCompanyInput.val('');
            Helpers.hideInputErrors(this.$bulkChangesCompanyInput);
        });
        this.$formBulkChangesCompany.submit(event => {
            event.preventDefault();
            let $checkboxMultiAction = $('input[name=checkbox-multi-action]:checked');
            if ($checkboxMultiAction.length === 0 && (this.$tableCheckAll.prop('checked') || !this.$tableCheckAll.prop('checked'))) return false;
            else {
                let url = $(event.target).attr('action');
                let ids = $checkboxMultiAction.toArray().map(el => {
                    return $(el).val();
                });
                let fd = new FormData(event.target);
                fd.append('ids', JSON.stringify(ids));

                Axios.post(url, fd).then(
                    res => {
                        Helpers.showToast(res.data.message);
                        this.$dataTableBuilder.DataTable().ajax.reload();
                        this.$modelBulkChangesCompany.modal('hide');
                    },
                    err => {
                        if (err.response.status === 422) {
                            Helpers.showInputErrors(err.response.data.errors);
                        } else {
                            Helpers.showToast(err.response.data.message, 'error')
                        }
                    }
                )
            }
        })
    }

    initBulkChangesPosition() {
        this.$modelBulkChangesPosition.on('hide.bs.modal', event => {
            this.$bulkChangesPositionInput.val('');
            Helpers.hideInputErrors(this.$bulkChangesPositionInput);
        });
        this.$formBulkChangesPosition.submit(event => {
            event.preventDefault();
            let ids = $('input[name=checkbox-multi-action]:checked').toArray().map(item => {
                return $(item).val();
            });
            let url = $(event.target).attr('action');
            let fd = new FormData(event.target);
            fd.append('ids', JSON.stringify(ids));
            Axios.post(url, fd).then(
                res => {
                    Helpers.showToast(res.data.message);
                    this.$dataTableBuilder.DataTable().ajax.reload();
                    this.$modelBulkChangesPosition.modal('hide');
                },
                err => {
                    if (err.response.status === 422) {
                        Helpers.showInputErrors(err.response.data.errors)
                    } else {
                        Helpers.showToast(err.response.data.message)
                    }
                }
            )
        })
    }

    initBulkChangeDescription() {
        this.$modelBulkChangesDescription.on('hide.ba.modal', () => {
            this.$bulkChangesDescriptionInput.val('');
            Helpers.hideInputErrors(this.$bulkChangesDescriptionInput);
        });

        this.$formBulkChangesDescription.submit(event => {
            event.preventDefault();

            let ids = $('input[name=checkbox-multi-action]:checked').toArray().map(item => {
                return $(item).val();
            });

            let url = $(event.target).attr('action');

            let fd = new FormData(event.target);
            fd.append('ids', JSON.stringify(ids));
            Axios.post(url, fd).then(
                res => {
                    Helpers.showToast(res.data.message);
                    this.$dataTableBuilder.DataTable().ajax.reload();
                    this.$modelBulkChangesDescription.modal('hide');
                },
                err => {
                    if (err.response.status === 422) {
                        Helpers.showInputErrors(err.response.data.errors)
                    } else {
                        Helpers.showToast(err.response.data.message, 'error');
                    }
                }
            )
        })
    }

    setupUpdateFrom(data, updatePhotoDropify) {
        this.$updateFirstname.val(data.firstname);
        this.$updateLastname.val(data.lastname);
        this.$updateCompany.val(data.company);
        this.$updateDescription.val(data.description);
        this.$updatePosition.val(data.position);
        updatePhotoDropify.settings.defaultFile = data.photo;
        updatePhotoDropify.destroy();
        updatePhotoDropify.init();
    }

    resetUpdateForm() {
        this.$updateDescription.val('');
        this.$updatePosition.val('');
        this.$updateCompany.val('');
        this.$updateLastname.val('');
        this.$updateFirstname.val('');
        this.$speakerFormUpdate.find('.dropify-clear').click();
        Helpers.hideInputErrors(this.$updatePosition);
        Helpers.hideInputErrors(this.$updateCompany);
        Helpers.hideInputErrors(this.$updateLastname);
        Helpers.hideInputErrors(this.$updateFirstname);
        Helpers.hideInputErrors(this.$updatePhoto);
    }

    resetCreateFrom() {
        this.$firstname.val('');
        this.$lastname.val('');
        this.$company.val('');
        this.$position.val('');
        this.$speakerFormCreate.find('.dropify-clear').click();
        Helpers.hideInputErrors(this.$firstname);
        Helpers.hideInputErrors(this.$lastname);
        Helpers.hideInputErrors(this.$company);
        Helpers.hideInputErrors(this.$position);
        Helpers.hideInputErrors(this.$photo);
    }
}

$(() => {
    new Speakers();
});
