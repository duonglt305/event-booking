import QrScanner from 'qr-scanner';
import Axios from 'axios';

QrScanner.WORKER_PATH = '/js/qr-scanner-worker.min.js';

class AttendeesVerify {
    constructor() {
        this.$scanner = $('#scanner');
        this.$roomFilter = $('#room-filter');
        this.$channelFilter = $('#channel-filter');
        this.$sessionSelect = $('#session-select');
        this.$codeShow = $('#code-show');
        this.$btnCheck = $('#btn-check');
        this.$modelVerify = $('#model-verify');
        this.$ticketInfoTable = $('#ticket-info-table');
        this.$sessionInfoTable = $('#session-info-table');
        this.$verifyUpdateBtn = $('#verify-update-btn');
        this.$attendeeInfoTable = $('#attendee-info-table');
        this.filterType = null;
        this.typeId = null;
        this.code = null;
        this.dataVerify = null;
        this.init();
    }

    init() {
        this.initScanner();
        this.initSelect2();

        this.$btnCheck.click(event => {
            event.preventDefault();
            if (this.code == null) {
                swal('Please scan your QR Code');
                return false;
            } else if (this.$sessionSelect.val() == null) {
                swal('Pleas select session');
                return false;
            } else {
                let data = {
                    code: this.code,
                    session: this.$sessionSelect.select2('data')[0].id
                };
                Axios.post($(event.currentTarget).data('url'), data).then(
                    ({data}) => {
                        if (data.message) {
                            const wrapper = document.createElement('div');
                            wrapper.innerHTML = data.message;
                            swal({
                                html: true,
                                icon: data.type === 'already_verified' ? 'info' : 'error',
                                content: wrapper
                            });
                            this.$codeShow.text('');
                        } else if (data.ticket && data.session) {
                            let {ticket, session, attendee} = data;
                            this.dataVerify = data;

                            let total = 0;
                            if (ticket.special_validity === null) {
                                total = 'Unlimited';
                            } else {
                                let type = ticket.special_validity.type;
                                total = type === 'date' ? 'Unlimited' : parseInt(ticket.special_validity.amount);
                            }

                            let ticketHtml = `<tr>
                                                    <th>Name</th>
                                                    <td>${ticket.name}</td>
                                                </tr>
                                                <tr>
                                                    <th>Cost</th>
                                                    <td>${(ticket.cost && ticket.cost != 0) ? ticket.cost : 'free'}</td>
                                                </tr>
                                                <tr>
                                                    <th>Amount</th>
                                                    <td>${total}</td>
                                              </tr>`;

                            let sessionHtml = `<tr>
                                                    <th>Name</th>
                                                    <td>${session.title}</td>
                                                </tr>
                                                <tr>
                                                    <th>Description</th>
                                                    <td>${session.description}</td>
                                                </tr>
                                                <tr>
                                                    <th>Start time - End time</th>
                                                    <td>${session.start_time} - ${session.end_time}</td>
                                                </tr>
                                                <tr>
                                                    <th>Type</th>
                                                    <td>${session.session_type.cost === 0 ? 'Talk' : 'Workshop'}</td>
                                                </tr>
                                                <tr>
                                                    <th>Room</th>
                                                    <td>${session.room.name}</td>
                                                </tr>
                                                <tr>
                                                    <th>Speaker</th>
                                                    <td>${session.speaker.firstname} ${session.speaker.lastname}</td>
                                                </tr>`;

                            let attendeeHtml = `<tr>
                                                    <th>Name</th>
                                                    <td>${attendee.firstname} ${attendee.lastname}</td>
                                                </tr>
                                                <tr>
                                                    <th>email</th>
                                                    <td>${attendee.email}</td>
                                                </tr>`;

                            this.$sessionInfoTable.find('tbody').html(sessionHtml);
                            this.$ticketInfoTable.find('tbody').html(ticketHtml);
                            this.$attendeeInfoTable.find('tbody').html(attendeeHtml);
                            this.$modelVerify.modal('show');
                        }
                    },
                    err => {

                    }
                )
            }
        });

        this.$verifyUpdateBtn.click(event => {
            event.preventDefault();
            if (this.dataVerify) {
                let attendeeId = this.dataVerify.attendee.id;
                let sessionId = this.dataVerify.session.id;
                let registrationId = this.dataVerify.ticket.registrations[0].id
                Axios.post(this.$verifyUpdateBtn.data('url'), {
                    attendee_id: attendeeId,
                    session_id: sessionId,
                    registration_id: registrationId
                })
                    .then(
                        ({data}) => {
                            this.$modelVerify.modal('hide');
                          swal(data.message).then(()=> {
                              window.location.reload();
                          });
                        }
                        , error => {
                            let message = error.response.data.message;
                            swal({
                                type: 'error',
                                text: message
                            })
                        }
                    )
            }
        });
    }

    initScanner() {
        // QrScanner.hasCamera().then(hasCamera => camHasCamera.textContent = hasCamera);
        //
        const scanner = new QrScanner(this.$scanner[0], result => {
            this.$codeShow.text(result);
            this.code = result;
        });
        scanner.start();
    }

    initSelect2() {
        this.$roomFilter.select2({
            placeholder: 'Filter by room',
            ajax: {
                url: this.$roomFilter.data('url'),
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
        this.$channelFilter.select2({
            placeholder: 'Filter by channels',
            ajax: {
                url: this.$channelFilter.data('url'),
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
                                text: `${item.name}`,
                                id: item.id,
                                title: `${item.name}`
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
        this.$roomFilter.on('select2:select', event => {
            this.filterType = 'rooms';
            this.typeId = event.params.data.id;
            this.$channelFilter.val(null).trigger('change');
            this.$sessionSelect.val(null).trigger('change');
            this.$sessionSelect.prop('disabled', false);
        });
        this.$channelFilter.on('select2:select', event => {
            this.filterType = 'channels';
            this.typeId = event.params.data.id;
            this.$roomFilter.val(null).trigger('change');
            this.$sessionSelect.val(null).trigger('change');
            this.$sessionSelect.prop('disabled', false);
        });

        this.$sessionSelect.select2({
            placeholder: 'Select session',
            ajax: {
                url: this.$sessionSelect.data('url'),
                dataType: 'json',
                delay: 250,
                data: params => {
                    return {
                        type: this.filterType,
                        key: params.term,
                        page: params.page,
                        type_id: this.typeId
                    };
                },
                processResults: function (data) {
                    return {
                        results: $.map(data, function (item) {
                            return {
                                text: `${item.title}`,
                                id: item.id,
                                title: `${item.title}`
                            }
                        })
                    }
                },
                cache: true
            },
            escapeMarkup: markup => markup
        });
        this.$sessionSelect.prop('disabled', true);
    }
}

$(() => {
    new AttendeesVerify();
});
