import Helpers from "./helpers";
import Axios from 'axios';

export default class Sessions {
    constructor() {
        this.$sessionDatatable = $('#session_datatable');

        // from update session
        this.$sessionModalEdit = $('#session_modal_edit');
        this.$sessionFormEdit = $('#session_form_edit');
        this.$sessionTitle = $('#session_title');
        this.$sessionSessionTypeId = $('#session_session_type_id');
        this.$sessionSpeakerId = $('#session_speaker_id');
        this.$sessionRoomId = $('#session_room_id');
        this.$sessionStartTime = $('#session_start_time');
        this.$sessionEndTime = $('#session_end_time');
        this.$sessionDescription = $('#session_description');
        this.currentTarget = null;
        this.init();
    }

    init() {
        this.initSessionTable();
        this.initSelectSessionType();
        this.initSelectSpeaker();
        this.initSelectRoom();
        this.initUpdateSession();
        this.initDeleteSession();
    }

    initSelectSessionType() {
        this.$sessionSessionTypeId.select2({
            placeholder: 'Session type',
            ajax: {
                url: this.$sessionSessionTypeId.data('action'),
                dataType: 'json',
                data: function (params) {
                    return {
                        term: params.term,
                    };
                },
                processResults: function (data) {
                    return {
                        results: $.map(data.types, function (item) {
                            return {
                                id: item.id,
                                text: `${item.name} - ${(parseInt(item.cost) === 0 || !item.cost) ? 'Free' : item.cost}`,
                                data: item
                            }
                        })
                    }
                },
                cache: true,
            },
        });
    }

    initSelectSpeaker() {
        this.$sessionSpeakerId.select2({
            placeholder: 'Select one',
            ajax: {
                url: this.$sessionSpeakerId.data('url'),
                dataType: 'json',
                delay: 250,
                data: function (params) {
                    return {
                        term: params.term,
                        page: params.page,
                    };
                },
                processResults: function (data, params) {
                    params.page = params.page || 1;
                    return {
                        results: $.map(data.data, function (item) {
                            return {
                                text: `${item.firstname} ${item.lastname} - ${item.position} - ${item.company}`,
                                id: item.id,
                                title: `${item.firstname} ${item.lastname} - ${item.position} - ${item.company}`
                            }
                        }),
                        pagination: {
                            more: (params.page * 10) < data.total
                        }
                    };
                },
                cache: true
            },
            escapeMarkup: markup => markup
        });
    }

    initSelectRoom() {
        this.$sessionRoomId.select2({
            placeholder: 'Select one',
            ajax: {
                url: this.$sessionRoomId.data('url'),
                dataType: 'json',
                delay: 250,
                data: function (params) {
                    return {
                        term: params.term,
                        page: params.page,
                    };
                },
                processResults: function (data, params) {
                    params.page = params.page || 1;
                    return {
                        results: $.map(data.data, function (item) {
                            return {
                                text: `${item.name} | Channel: ${item.channel.name}`,
                                id: item.id,
                                title: `${item.name} | Channel: ${item.channel.name}`
                            }
                        }),
                        pagination: {
                            more: (params.page * 10) < data.total
                        }
                    };
                },
                cache: true
            },
            escapeMarkup: markup => markup
        });
    }

    initSessionTable() {
        let action = this.$sessionDatatable.data('url');
        this.$sessionDatatable.DataTable({
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
                    url:
                    action,
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
                    searchable: false,
                    width: '20px'
                },
                {
                    title: 'Time',
                    name: 'time',
                    data: 'time',
                    class: 'text-center',
                    width: '300px'
                },
                {
                    title: 'Type',
                    name: 'type',
                    data: 'type',
                    class: 'text-center',
                    width: '100px'
                },
                {
                    title: 'Title',
                    name: 'title',
                    data: 'title',
                    class: 'text-center'
                },
                {
                    title: 'Speaker',
                    name: 'speaker',
                    data: 'speaker',
                    class: 'text-center',
                    width: '200px'
                },
                {
                    title: 'Channel',
                    name: 'channel',
                    data: 'channel',
                    class: 'text-center',
                    width: '200px'
                },
                {
                    title: 'Actions',
                    name: 'actions',
                    data: 'actions',
                    class: 'text-center',
                    width: '70px'
                }
            ]
        })
    }

    initUpdateSession() {
        this.$sessionModalEdit.on('show.bs.modal', event => {
            let url = $(event.relatedTarget).attr('href');
            Axios.get(url).then(
                ({data}) => {
                    this.currentTarget = data;
                    this.setupUpdateForm(data);
                },
                err => {
                    Helpers.showToast(err.response.data.message)
                }
            )
        }).on('hide.bs.modal', () => {
            this.resetUpdateForm();
        });

        this.$sessionFormEdit.submit(event => {
            event.preventDefault();
            let url = $(event.target).attr('action');
            url = url.slice(0, url.lastIndexOf('/') + 1) + this.currentTarget.id;
            Axios.post(url, new FormData(event.target)).then(
                res => {
                    if (res.data && res.data.message) {
                        Helpers.showToast(res.data.message);
                        this.$sessionModalEdit.modal('hide');
                        this.$sessionDatatable.DataTable().ajax.reload();
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

    setupUpdateForm(data) {
        this.$sessionTitle.val(data.title);
        this.$sessionStartTime.val(data.start_time);
        this.$sessionEndTime.val(data.end_time);
        this.$sessionDescription.val(data.description);
        this.$sessionSessionTypeId.val(null)
            .append(new Option(
                `${data.session_type.name} - ${data.session_type.cost ? data.session_type.cost : 'Free'}`,
                data.session_type.id,
                false,
                true))
            .trigger('change');

        this.$sessionRoomId.val(null)
            .append(new Option(
                `${data.room.name} | Channel: ${data.channel.name}`,
                data.room.id,
                false,
                true
                )
            )
            .trigger('change');
        this.$sessionSpeakerId.val(null)
            .append(new Option(
                `${data.speaker.firstname} ${data.speaker.lastname}`,
                data.speaker.id,
                false,
                true
                )
            )
            .trigger('change');
    }

    resetUpdateForm() {
        this.$sessionTitle.val('');
        this.$sessionStartTime.val('');
        this.$sessionEndTime.val('');
        this.$sessionDescription.val('');
        this.$sessionSessionTypeId.val(null).trigger('change');
        this.$sessionRoomId.val(null).trigger('change');
        this.$sessionSpeakerId.val(null).trigger('change');
        Helpers.hideInputErrors(this.$sessionTitle);
        Helpers.hideInputErrors(this.$sessionStartTime);
        Helpers.hideInputErrors(this.$sessionEndTime);
        Helpers.hideInputErrors(this.$sessionSessionTypeId);
        Helpers.hideInputErrors(this.$sessionTitle);
        Helpers.hideInputErrors(this.$sessionSpeakerId);
    }

    initDeleteSession() {
        $(document).on('click', '.session_delete', event => {
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
                            this.$sessionDatatable.DataTable().ajax.reload();
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
