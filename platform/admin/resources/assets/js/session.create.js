import Helpers from "./helpers";
import Axios from "axios";
import SessionTypes from "./session.types";
import SessionSpeaker from "./session.speaker";

class SessionCreate {
    constructor() {
        this.$formCreate = $('#session_form_create');
        this.$selectSessionType = $('#session_type_id');
        this.$selectSpeaker = $('#speaker_id');
        this.$selectRoom = $('#room_id');
        this.init();
    }

    init() {
        new SessionTypes();
        new SessionSpeaker();
        this.initSelectSessionType();
        this.initSelectSpeaker();
        this.initSelectRoom();
        this.initCreate();
    }

    initSelectSessionType() {
        this.$selectSessionType.select2({
            placeholder: 'Session type',
            ajax: {
                url: this.$selectSessionType.data('action'),
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
        this.$selectSpeaker.select2({
            placeholder: 'Select one',
            ajax: {
                url: this.$selectSpeaker.data('url'),
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
        this.$selectRoom.select2({
            placeholder: 'Select one',
            ajax: {
                url: this.$selectRoom.data('url'),
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

    initCreate() {
        this.$formCreate.submit(e => {
            e.preventDefault();
            let action = $(e.target).attr('action');
            Axios.post(action, new FormData(e.target)).then(res => {
                if (res.data && res.data.message) {
                    Helpers.showToast(res.data.message);
                    setTimeout(() => {
                        window.location.href = res.data.url;
                    }, 1000);
                }
            }).catch(err => {
                if (err.response.status === 422) {
                    Helpers.showInputErrors(err.response.data.errors);
                    this.hideErrorSelect2([
                        this.$selectSpeaker,
                        this.$selectRoom,
                        this.$selectSessionType
                    ]);
                } else {
                    Helpers.showToast(err.response.data.message, 'error');
                }
            })
        });
    }

    hideErrorSelect2(els) {
        els.forEach(el => {
            $(el).on('select2:select', () => {
                Helpers.hideInputErrors(el)
            })
        })
    }
}

$(() => new SessionCreate());
