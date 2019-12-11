import Helpers from "./helpers";
import Axios from 'axios';

export default class SessionSpeaker {
    constructor() {
        this.$modalCreate = $('#speaker_modal_create');
        this.$formCreate = $('#speaker_form_create');
        this.$speakerPhoto = $('#photo');
        this.init();
    }

    init() {
        this.initPhoto();
        this.initCreate();
    }

    initPhoto() {
        this.$speakerPhoto.dropify();
    }

    initCreate() {
        this.$modalCreate.on('hide.bs.modal', () => {
            this.$formCreate.find('.dropify-clear').click();
            this.$formCreate.find('.form-control').each((index, input) => {
                Helpers.hideInputErrors($(input), true);
            });
        });

        this.$formCreate.submit(event => {
            event.preventDefault();
            let url = $(event.target).attr('action');
            Axios.post(url, new FormData(event.target)).then(
                res => {
                    Helpers.showToast(res.data.message);
                    this.$modalCreate.modal('hide');
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
}
