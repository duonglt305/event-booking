import Helpers from "./helpers";
import Axios from 'axios';

export default class Partners {
    constructor() {
        this.$partnerTable = $('#partner_datatable');

        // partner create
        this.$partnerModalCreate = $('#partner_modal_create');
        this.$partnerFormCreate = $('#partner_form_create');
        this.$partnerName = $('#partner_name');
        this.$partnerLogo = $('#partner_logo');
        this.$partnerDescription = $('#partner_description');


        // partner update
        this.$partnerModalEdit = $('#partner_modal_edit');
        this.$partnerFormEdit = $('#partner_form_edit');
        this.$updatePartnerName = $('#update_partner_name');
        this.$updatePartnerLogo = $('#update_partner_logo');
        this.$updatePartnerDescription = $('#update_partner_description');
        this.currentTarget = null;

        this.init();
    }

    init() {
        this.initTable();
        this.initPartnerCreate();
        this.initPartnerUpdate();
        this.initDeletePartner();
    }

    initTable() {
        this.$partnerTable.DataTable({
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
                    url: this.$partnerTable.data('url'),
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
                    title: 'Name',
                    name: 'name',
                    data: 'name',
                },
                {
                    title: 'Logo',
                    name: 'logo',
                    data: 'logo',
                    class: 'text-center py-1',
                },
                {
                    title: 'Description',
                    name: 'description',
                    data: 'description',
                },
                {
                    title: 'Actions',
                    name: 'actions',
                    data: 'actions',
                    class: 'text-center py-1',
                    orderable: false,
                    searchable: false
                }
            ]
        });
    }

    initPartnerCreate() {
        this.$partnerLogo.dropify();
        this.$partnerModalCreate.on('hide.bs.modal', event => {
            this.$partnerFormCreate.find('.dropify-clear').click();
            this.$partnerName.val('');
            this.$partnerDescription.val('');
            Helpers.hideInputErrors(this.$partnerName);
            Helpers.hideInputErrors(this.$partnerLogo);
        });

        this.$partnerFormCreate.submit(event => {
            event.preventDefault();
            let url = $(event.target).attr('action');
            Axios.post(url, new FormData(event.target)).then(
                res => {
                    if (res.data && res.data.message) {
                        Helpers.showToast(res.data.message);
                        this.$partnerTable.DataTable().ajax.reload();
                        this.$partnerModalCreate.modal('hide');
                    }
                },
                err => {
                    if (err.response.data.errors) {
                        Helpers.showInputErrors(err.response.data.errors, 'partner')
                    }
                    Helpers.showToast(err.response.data.message, 'error');
                }
            )
        });
    }

    initPartnerUpdate() {
        let photoDropify = this.$updatePartnerLogo.dropify();
        photoDropify = photoDropify.data('dropify');

        this.$partnerModalEdit.on('show.bs.modal', event => {
            let url = $(event.relatedTarget).attr('href');
            Axios.get(url).then(
                ({data}) => {
                    this.currentTarget = data;
                    this.$updatePartnerName.val(data.name);
                    this.$updatePartnerDescription.val(data.description);
                    photoDropify.settings.defaultFile = data.logo;
                    photoDropify.destroy();
                    photoDropify.init();
                },
                err => {
                    Helpers.showToast(err.response.data.message, 'error');
                }
            )
        }).on('hide.bs.modal', () => {
            this.$updatePartnerName.val('');
            this.$updatePartnerDescription.val('');
            Helpers.hideInputErrors(this.$updatePartnerName);
            this.$partnerFormEdit.find('.dropify-clear').click();
        });

        this.$partnerFormEdit.submit(event => {
            event.preventDefault();
            let url = $(event.target).attr('action');
            url = url.slice(0, url.lastIndexOf('/') + 1) + this.currentTarget.id;
            Axios.post(url, new FormData(event.target)).then(
                res => {
                    if (res.data && res.data.message) {
                        Helpers.showToast(res.data.message);
                        this.$partnerTable.DataTable().ajax.reload();
                        this.$partnerModalEdit.modal('hide');
                    }
                },
                err => {
                    if (err.response.data.errors) {
                        Helpers.showInputErrors(err.response.data.errors, 'update_partner');
                    }
                    Helpers.showToast(err.response.data.message);
                }
            )
        })
    }

    initDeletePartner() {
        $(document).on('click', '.partner_delete', event => {
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
                            this.$partnerTable.DataTable().ajax.reload();
                        },
                        err => {
                            Helpers.showToast(err.response.data.message, 'error')
                        }
                    )
                }
            })
        })
    }
}
